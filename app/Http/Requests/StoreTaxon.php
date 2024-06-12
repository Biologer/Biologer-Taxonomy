<?php

namespace App\Http\Requests;

use App\ConservationDocument;
use App\ConservationLegislation;
use App\Country;
use App\RedList;
use App\Rules\UniqueTaxonName;
use App\Stage;
use App\Support\Localization;
use App\Synonym;
use App\Taxon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class StoreTaxon extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('create', [Taxon::class, $this->input('parent_id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', new UniqueTaxonName($this->parent_id)],
            'parent_id' => ['nullable', 'exists:taxa,id'],
            'rank' => ['required', Rule::in(array_keys(Taxon::RANKS))],
            'author' => ['nullable', 'string'],
            'fe_old_id' => ['nullable', 'integer'],
            'fe_id' => ['nullable'],
            'restricted' => ['boolean'],
            'allochthonous' => ['boolean'],
            'invasive' => ['boolean'],
            'stages_ids' => ['nullable', 'array'],
            'stages_ids.*' => ['required', Rule::in(Stage::pluck('id'))],
            'conservation_legislations_ids' => [
                'nullable', 'array', Rule::in(ConservationLegislation::pluck('id')),
            ],
            'conservation_documents_ids' => [
                'nullable', 'array', Rule::in(ConservationDocument::pluck('id')),
            ],
            'red_lists_data' => ['nullable', 'array'],
            'red_lists_data.*' => ['array'],
            'red_lists_data.*.red_list_id' => [
                'required',
                Rule::in(RedList::pluck('id')),
            ],
            'red_lists_data.*.category' => [
                'required',
                Rule::in(RedList::CATEGORIES),
            ],
            'native_name' => ['required', 'array'],
            'description' => ['required', 'array'],
            'uses_atlas_codes' => ['boolean'],
            'countries_ids' => ['nullable', 'array'],
            'countries_ids.*' => ['required', Rule::in(Country::pluck('id')->all())],
            'synonyms' => ['array'],
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
     * Create taxon using request data.
     *
     * @return \App\Taxon
     */
    protected function createTaxon()
    {
        return Taxon::create(array_merge(array_map('trim', $this->only(['name', 'rank'])), $this->only([
            'parent_id', 'fe_id', 'author', 'fe_old_id', 'restricted', 'allochthonous', 'invasive', 'uses_atlas_codes',
        ]), Localization::transformTranslations($this->only([
            'description', 'native_name',
        ]))));
    }

    /**
     * Map red list data to format required to store the value.
     *
     * @param  array  $redListsData
     * @return array
     */
    protected function mapRedListsData($redListsData = [])
    {
        return collect($redListsData)->mapWithKeys(function ($item) {
            return [$item['red_list_id'] => ['category' => $item['category']]];
        })->all();
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

    /**
     * Store the information.
     *
     * @return \App\Taxon
     */
    public function save()
    {
        return DB::transaction(function () {
            return tap($this->createTaxon(), function ($taxon) {
                $this->createSynonyms($taxon);
                $this->syncRelations($taxon);
                $this->logCreatedActivity($taxon);
                $this->sendNewTaxonToLocalDatabases($taxon->load('conservationLegislations', 'redLists', 'conservationDocuments', 'stages', 'synonyms', 'countries'));
            });
        });
    }

    /**
     * Log taxon created activity.
     *
     * @param  \App\Taxon  $taxon
     * @return void
     */
    protected function logCreatedActivity(Taxon $taxon)
    {
        activity()->performedOn($taxon)
            ->causedBy($this->user())
            ->log('created');
    }

    private function createSynonyms($taxon)
    {
        foreach ($this->input('synonyms') as $synonym) {
            $s = Synonym::create([
                'name' => $synonym['name'],
                'author' => $synonym['author'],
                'taxon_id' => $taxon->id,
            ]);
            $s->save();
        }
    }

    private function sendNewTaxonToLocalDatabases($taxon)
    {
        $data['taxon'] = $taxon->toArray();
        $data['parent'] = '';
        if ($taxon->parent_id) {
            $data['parent'] = $taxon['parent'];
        }
        $data['taxon']['reason'] = $this->input('reason');

        foreach ($taxon->countries()->get() as $country) {
            if (! $country->active) {
                continue;
            }
            
            $data['country_ref'] = [];

            foreach ($country->redLists()->get()->toArray() as $item) {
                $data['country_ref']['redLists'][$item['pivot']['red_list_id']] = $item['pivot']['ref_id'];
            }
            foreach ($country->conservationLegislations()->get()->toArray() as $item) {
                $data['country_ref']['legs'][$item['pivot']['leg_id']] = $item['pivot']['ref_id'];
            }
            foreach ($country->conservationDocuments()->get()->toArray() as $item) {
                $data['country_ref']['docs'][$item['pivot']['doc_id']] = $item['pivot']['ref_id'];
            }

            $data['key'] = config('biologer.taxonomy_key_'.$country->code);

            http::post($country->url.'/api/taxonomy/sync', $data);
        }
    }
}
