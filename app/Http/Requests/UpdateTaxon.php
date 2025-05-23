<?php

namespace App\Http\Requests;

use App\ConservationDocument;
use App\ConservationLegislation;
use App\Country;
use App\Http\Controllers\Api\TaxonomyController;
use App\RedList;
use App\Rules\UniqueTaxonName;
use App\Stage;
use App\Support\Localization;
use App\Synonym;
use App\Taxon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTaxon extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('update', $this->taxon);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', new UniqueTaxonName($this->parent_id, $this->taxon->id)],
            'parent_id' => ['nullable', 'exists:taxa,id'],
            'rank' => ['required', Rule::in(array_keys(Taxon::RANKS))],
            'author' => ['nullable', 'string'],
            'fe_old_id' => ['nullable', 'integer'],
            'fe_id' => ['nullable'],
            'restricted' => ['boolean'],
            'allochthonous' => ['boolean'],
            'invasive' => ['boolean'],
            'stages_ids' => ['nullable', 'array'],
            'stages_ids.*' => ['required', Rule::in(Stage::pluck('id')->all())],
            'conservation_legislations_ids' => [
                'nullable', 'array', Rule::in(ConservationLegislation::pluck('id')->all()),
            ],
            'conservation_documents_ids' => [
                'nullable', 'array', Rule::in(ConservationDocument::pluck('id')->all()),
            ],
            'red_lists_data' => ['nullable', 'array'],
            'red_lists_data.*' => ['array'],
            'red_lists_data.*.red_list_id' => [
                'required',
                Rule::in(RedList::pluck('id')->all()),
            ],
            'red_lists_data.*.category' => [
                'required',
                Rule::in(RedList::CATEGORIES),
            ],
            'reason' => ['required', 'string', 'max:255'],
            'native_name' => ['required', 'array'],
            'description' => ['required', 'array'],
            'uses_atlas_codes' => ['boolean'],
            'countries_ids' => ['nullable', 'array'],
            'countries_ids.*' => ['required', Rule::in(Country::pluck('id')->all())],
            'synonyms' => ['array'],
            'removed_synonyms' => ['array'],
            'countries' => ['array'],
            'countries.*.restricted' => 'boolean',
            'countries.*.allochthonous' => 'boolean',
            'countries.*.invasive' => 'boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'parent_id' => 'parent',
        ];
    }

    /**
     * Update taxon using request data.
     *
     * @param  \App\Taxon  $taxon
     * @return \App\Taxon
     */
    public function save(Taxon $taxon)
    {
        return DB::transaction(function () use ($taxon) {
            $oldData = $taxon->load([
                'parent', 'stages', 'conservationLegislations', 'redLists',
                'conservationDocuments', 'countries',
            ])->toArray();

            $taxon->update(array_merge(array_map('trim', $this->only(['name', 'rank'])), $this->only([
                'parent_id', 'fe_old_id', 'fe_id', 'author', 'restricted', 'allochthonous', 'invasive', 'uses_atlas_codes',
            ]), Localization::transformTranslations($this->only([
                'description', 'native_name',
            ]))));

            $this->updateSynonyms($taxon);

            $oldCountries = $taxon->countries()->get();

            $this->syncRelations($taxon);

            $this->updateCountriesAdditionalData($taxon);

            $this->logUpdatedActivity($taxon, $oldData);

            $taxon->save();

            $taxon = $taxon->load(['parent', 'synonyms']);

            (new TaxonomyController)->sendUpdatesToLocalDatabases($taxon, $oldCountries, $this->input('reason'));

            return $taxon;
        });
    }

    /**
     * Map red list data to format required to store the value.
     *
     * @param  array  $redListsData
     * @return array
     */
    protected function mapRedListsData(array $redListsData = [])
    {
        return collect($redListsData)->mapWithKeys(function ($item) {
            return [$item['red_list_id'] => ['category' => $item['category']]];
        })->all();
    }

    private function updateCountriesAdditionalData(Taxon $taxon)
    {
        $countriesData = $this->input('countries', []);

        foreach ($countriesData as $countryId => $countryData) {
            $taxon->countries()->updateExistingPivot($countryId, [
                'restricted' => $countryData['restricted'] ?? false,
                'allochthonous' => $countryData['allochthonous'] ?? false,
                'invasive' => $countryData['invasive'] ?? false,
            ]);
        }
    }

    /**
     * Sync taxon relations.
     *
     * @param  \App\Taxon  $taxon
     * @return void
     */
    protected function syncRelations(Taxon $taxon)
    {
        $taxon->stages()->sync($this->input('stages_ids', []));
        $taxon->conservationLegislations()->sync($this->input('conservation_legislations_ids', []));
        $taxon->conservationDocuments()->sync($this->input('conservation_documents_ids', []));
        $taxon->redLists()->sync(
            $this->mapRedListsData($this->input('red_lists_data', []))
        );
        $taxon->countries()->sync($this->input('countries_ids', []));
    }

    protected function logUpdatedActivity(Taxon $taxon, $oldData)
    {
        activity()->performedOn($taxon)
            ->causedBy($this->user())
            ->withProperty('old', $this->getChangedData($taxon, $oldData))
            ->withProperty('reason', $this->input('reason'))
            ->log('updated');
    }

    protected function getChangedData(Taxon $taxon, $oldData)
    {
        $changed = array_keys($taxon->getChanges());

        $data = [];
        foreach ($oldData as $key => $value) {
            if ('stages' === $key && $this->stagesAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('conservation_legislations' === $key && $this->conservationLegislationsAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('conservation_documents' === $key && $this->conservationDocumentsAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('red_lists' === $key && $this->redListsAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('countries' === $key && $this->countriesAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('translations' === $key) {
                if ($this->translationIsChanged('description', collect($value), $taxon->translations)) {
                    $data['description'] = null;
                }

                if ($this->translationIsChanged('native_name', collect($value), $taxon->translations)) {
                    $data['native_name'] = null;
                }
            } elseif (in_array($key, $changed)) {
                if ('parent_id' === $key) {
                    $data['parent'] = $oldData['parent'] ? $oldData['parent']['name'] : $value;
                } elseif ('rank' === $key) {
                    $data[$key] = ['value' => $value, 'label' => 'taxonomy.'.$value];
                } elseif (in_array($key, ['description', 'native_name'])) {
                    $data[$key] = null;
                } elseif (in_array($key, ['restricted', 'allochthonous', 'invasive', 'uses_atlas_codes'])) {
                    $data[$key] = ['value' => $value, 'label' => $value ? 'Yes' : 'No'];
                } else {
                    $data[$key] = $value;
                }
            }
        }

        return $data;
    }

    protected function stagesAreChanged($taxon, $oldValue)
    {
        $taxon->load('stages');

        return $oldValue->count() !== $taxon->stages->count()
            || ($oldValue->isNotEmpty() && $taxon->stages->isNotEmpty()
            && $oldValue->pluck('id')->diff($taxon->stages->pluck('id'))->isNotEmpty());
    }

    protected function conservationLegislationsAreChanged($taxon, $oldValue)
    {
        $taxon->load('conservationLegislations');

        return $oldValue->count() !== $taxon->conservationLegislations->count()
            || ($oldValue->isNotEmpty() && $taxon->conservationLegislations->isNotEmpty()
            && $oldValue->pluck('id')->diff($taxon->conservationLegislations->pluck('id'))->isNotEmpty());
    }

    protected function conservationDocumentsAreChanged($taxon, $oldValue)
    {
        $taxon->load('conservationDocuments');

        return $oldValue->count() !== $taxon->conservationDocuments->count()
            || ($oldValue->isNotEmpty() && ! $taxon->conservationDocuments->isNotEmpty()
            && $oldValue->pluck('id')->diff($taxon->conservationDocuments->pluck('id'))->isNotEmpty());
    }

    protected function redListsAreChanged($taxon, $oldValue)
    {
        $taxon->load('redLists');

        return $oldValue->count() !== $taxon->redLists->count()
            || (! $oldValue->isEmpty() && ! $taxon->redLists->isEmpty()
            && $oldValue->pluck('id')->diff($taxon->redLists->pluck('id'))->isNotEmpty()
            || $oldValue->filter(function ($oldRedList) use ($taxon) {
                return $taxon->redLists->contains(function ($redList) use ($oldRedList) {
                    return $redList->id === $oldRedList['id']
                        && $redList->pivot->category === Arr::get($oldRedList, 'pivot.category');
                });
            })->count() !== $oldValue->count());
    }

    public function translationIsChanged($translatedAttribute, $oldValue, $value)
    {
        $old = $oldValue->mapWithKeys(function ($translation) use ($translatedAttribute) {
            return [$translation['locale'] => $translation[$translatedAttribute] ?? null];
        });


        $new = $value->mapWithKeys(function ($translation) use ($translatedAttribute) {
            return [$translation->locale => $translation->{$translatedAttribute}];
        });

        return ! $old->diffAssoc($new)->isEmpty() || ! $new->diffAssoc($old)->isEmpty();
    }

    protected function updateSynonyms(Taxon $taxon)
    {
        foreach ($this->input('removed_synonyms') as $removed) {
            Synonym::find($removed['id'])->delete();
        }

        foreach ($this->input('synonyms') as $synonym) {
            if (isset($synonym['id'])) {
                continue;
            }
            $s = Synonym::create([
                'name' => $synonym['name'],
                'author' => $synonym['author'],
                'taxon_id' => $taxon->id,
            ]);
            $s->save();
        }
    }

    protected function countriesAreChanged(Taxon $taxon, $oldValue)
    {
        $taxon->load('countries');

        return $oldValue->count() !== $taxon->countries->count()
            || ($oldValue->isNotEmpty() && $taxon->countries->isNotEmpty()
                && $oldValue->pluck('id')->diff($taxon->countries->pluck('id'))->isNotEmpty());
    }
}
