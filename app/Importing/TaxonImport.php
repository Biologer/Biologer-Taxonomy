<?php

namespace App\Importing;

use App\ConservationDocument;
use App\ConservationLegislation;
use App\Import;
use App\RedList;
use App\Stage;
use App\Support\Localization;
use App\Synonym;
use App\Taxon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TaxonImport extends BaseImport
{
    /**
     * Available conservation documents.
     *
     * @var EloquentCollection
     */
    private $conservationDocuments;

    /**
     * Available conservation legislations.
     *
     * @var EloquentCollection
     */
    private $conservationLegislations;

    /**
     * Available red lists.
     *
     * @var EloquentCollection
     */
    private $redLists;

    /**
     * Available stages.
     *
     * @var EloquentCollection
     */
    private $stages;

    /**
     * Create new importer instance.
     *
     * @param Import $import
     * @return void
     */
    public function __construct(Import $import)
    {
        parent::__construct($import);
        $this->fetchRelated();
    }

    /**
     * Fetch user that's creating taxa tree and other data related to taxa.
     *
     * @return void
     */
    private function fetchRelated()
    {
        $this->conservationDocuments = ConservationDocument::all();
        $this->conservationLegislations = ConservationLegislation::all();
        $this->redLists = RedList::all();
        $this->stages = Stage::all();
        $this->replace = $this->getBoolean($this->import->options->toArray(), 'replace');
    }

    /**
     * Definition of all calumns with their labels.
     *
     * @param  \App\User|null  $user
     * @return Collection
     */
    public static function columns($user = null): Collection
    {
        $locales = collect(LaravelLocalization::getSupportedLocales());

        return collect(array_keys(Taxon::RANKS))->map(function ($rank) {
            return [
                'label' => trans("taxonomy.{$rank}"),
                'value' => $rank,
                'required' => false,
            ];
        })->concat([
            [
                'label' => trans('labels.id'),
                'value' => 'id',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.author'),
                'value' => 'author',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.restricted'),
                'value' => 'restricted',
                'required' => true,
            ],
            [
                'label' => trans('labels.taxa.allochthonous'),
                'value' => 'allochthonous',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.invasive'),
                'value' => 'invasive',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.fe_old_id'),
                'value' => 'fe_old_id',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.fe_id'),
                'value' => 'fe_id',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.stages'),
                'value' => 'stages',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.conservation_legislations'),
                'value' => 'conservation_legislations',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.conservation_documents'),
                'value' => 'conservation_documents',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.red_lists'),
                'value' => 'red_lists',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.uses_atlas_codes'),
                'value' => 'uses_atlas_codes',
                'required' => false,
            ],
        ])->concat($locales->map(function ($locale, $localeCode) {
            $nativeName = trans('labels.taxa.native_name');
            $localeTranslation = trans('languages.'.$locale['name']);

            return [
                'label' => "{$nativeName} - {$localeTranslation}",
                'value' => 'native_name_'.Str::snake($localeCode),
                'required' => false,
            ];
        }))->concat($locales->map(function ($locale, $localeCode) {
            $description = trans('labels.taxa.description');
            $localeTranslation = trans('languages.'.$locale['name']);

            return [
                'label' => "{$description} - {$localeTranslation}",
                'value' => 'description_'.Str::snake($localeCode),
                'required' => false,
            ];
        }))->concat([
            [
                'label' => trans('labels.taxa.synonyms'),
                'value' => 'synonyms',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.countries'),
                'value' => 'countries',
                'required' => false,
            ],
        ]);
    }

    public function generateErrorsRoute(): string
    {
        return route('api.taxon-imports.errors', $this->model());
    }

    /**
     * Make validator instance.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function makeValidator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();
        $ranks = collect(array_keys(Taxon::RANKS));

        return Validator::make($data, [
            $locales->map(function ($locale) {
                $nativeName = trans('labels.taxa.native_name');
                $localeTranslation = trans('languages.'.$locale['name']);

                return [
                    "{$nativeName} - {$localeTranslation}" => ['nullable', 'string'],
                ];
            }),
            $ranks->map(function ($rank) {
                $label = trans("taxonomy.($rank}");

                return [
                    "{$label}" => ['nullable', 'string'],
                ];
            }),
            'id' => ['nullable', 'integer', 'min:1'],
            'author' => ['nullable', 'string'],
            'restricted' => ['nullable', 'string', Rule::in($this->yesNo())],
            'allochthonous' => ['nullable', 'string', Rule::in($this->yesNo())],
            'invasive' => ['nullable', 'string', Rule::in($this->yesNo())],
            'fe_old_id' => ['nullable', 'integer'],
            'fe_id' => ['nullable'],
            'uses_atlas_codes' => ['nullable', 'string', Rule::in($this->yesNo())],
            'synonyms' => ['nullable', 'string'],
        ], [
            $ranks->map(function ($rank) {
                return [
                    "{$rank}" => trans("taxonomy.($rank}"),
                ];
            }),
            'id' => trans('labels.id'),
            'author' => trans('labels.taxa.author'),
            'restricted' => trans('labels.taxa.restricted'),
            'allochthonous' => trans('labels.taxa.allochthonous'),
            'invasive' => trans('labels.taxa.invasive'),
            'fe_old_id' => trans('labels.taxa.fe_old_id'),
            'fe_id' => trans('labels.taxa.fe_id'),
            'stages' => trans('labels.taxa.stages'),
            'conservation_legislations' => trans('labels.taxa.conservation_legislations'),
            'conservation_documents' => trans('labels.taxa.conservation_documents'),
            'red_lists' => trans('labels.taxa.red_lists'),
            'uses_atlas_codes' => trans('labels.taxa.uses_atlas_codes'),
            'synonyms' => trans('labels.taxa.synonyms'),
        ]);
    }

    /**
     * "Yes" and "No" options translated in language the import is using.
     *
     * @return array
     */
    protected function yesNo(): array
    {
        $lang = $this->model()->lang;

        return [__('Yes', [], $lang), __('No', [], $lang)];
    }

    /**
     * Store data from single CSV row.
     *
     * @param  array  $taxon
     * @return void
     */
    protected function storeSingleItem(array $taxon)
    {
        $this->addEntireTreeOfTheTaxon($taxon);
    }


    /**
     * Create taxon with ancestor tree using data from one row.
     *
     * @param array $taxon
     * @return void
     */
    private function addEntireTreeOfTheTaxon(array $taxon)
    {
        if ($tree = $this->buildWorkingTree($taxon)) {
            // We assume that the rest of available information describes the
            // lowest ranked taxon in the row.
            $last = end($tree);

            // Depending on import settings, will replace or append data from import.
            if ($this->replace) {
                $last->fill($this->extractOtherTaxonData($taxon));
            } else {
                $last->fill($this->extractNonExistingData($last, $taxon));
                $last->update(array_merge(Localization::transformTranslations($this->getNonExistingLocaleData($last->toArray(), $taxon))));
            }

            $this->storeWorkingTree($tree);
            $this->saveRelations($last, $taxon);
        }
    }

    /**
     * Make taxa tree using data from a row.
     *
     * @param array $taxon
     * @return array
     */
    private function buildWorkingTree(array $taxon): array
    {
        $tree = [];
        $taxa = $this->getRankNamePairsForTree($taxon);
        $existing = $this->getExistingTaxaForPotentialTree($taxa);

        foreach ($taxa as $taxon) {
            $tree[] = $existing->first(function ($existingTaxon) use ($taxon) {
                return $this->isSameTaxon($existingTaxon, $taxon);
            }, new Taxon($taxon));
        }

        return $tree;
    }

    /**
     * Check if it's the same taxon as existing one.
     *
     * @param Taxon $existingTaxon
     * @param array $taxon
     * @return bool
     */
    private function isSameTaxon(Taxon $existingTaxon, array $taxon): bool
    {
        return $existingTaxon->rank === $taxon['rank'] &&
            strtolower($existingTaxon->name) === strtolower($taxon['name']);
    }

    /**
     * Get name and rank data for each taxon in the tree from the row.
     *
     * @param array $taxon
     * @return array
     */
    private function getRankNamePairsForTree(array $taxon): array
    {
        $tree = [];
        $ranks = array_keys(Taxon::RANKS);

        foreach ($ranks as $rank) {
            $name = trim($this->getNameForRank($rank, $taxon));

            if (! $name) {
                continue;
            }

            $tree[] = [
                'name' => $name,
                'rank' => $rank,
            ];
        }

        return $tree;
    }

    /**
     * Get the name of the taxon for given rank, using the data from the row.
     * We might need to compose it if species and subspecies contains only suffix.
     *
     * @param string $rank
     * @param array $taxon
     * @return string|null
     */
    private function getNameForRank(string $rank, array $taxon): ?string
    {
        return $taxon[$rank] ?? null;
    }

    /**
     * If we already have some taxon in database, we don't need to create it again,
     * we'll use the one we have.
     *
     * @param  array  $tree
     * @return EloquentCollection
     */
    private function getExistingTaxaForPotentialTree(array $tree): EloquentCollection
    {
        $query = Taxon::query()->with('ancestors');

        foreach ($tree as $taxon) {
            $query->orWhere(function ($q) use ($taxon) {
                $q->where('rank', $taxon['rank'])->where('name', 'like', trim($taxon['name']));
            });
        }

        return $query->get()->groupBy(function ($taxon) {
            return $taxon->isRoot() ? $taxon->id : $taxon->ancestors->filter->isRoot()->first()->id;
        })->sortByDesc(function ($group) {
            return $group->count();
        })->first() ?: EloquentCollection::make();
    }

    /**
     * Extract the rest of information that we'll use to describe the lowest taxon in the row.
     *
     * @param array $item
     * @return array
     */
    private function extractOtherTaxonData(array $item): array
    {
        return array_merge(
            [
                'author' => Arr::get($item, 'author') ?: null,
                'fe_old_id' => Arr::get($item, 'fe_old_id') ?: null,
                'fe_id' => Arr::get($item, 'fe_id') ?: null,
                'restricted' => $this->getBoolean($item, 'restricted'),
                'allochthonous' => $this->getBoolean($item, 'allochthonous'),
                'invasive' => $this->getBoolean($item, 'invasive'),
                'uses_atlas_codes' => $this->getBoolean($item, 'uses_atlas_codes'),
            ],
            Localization::transformTranslations($this->getLocaleData($item)),
        );
    }

    /**
     * Store the working tree of a row.
     * Some taxa might already exist, some are new and need to be created.
     *
     * @param array $tree
     * @return array
     */
    private function storeWorkingTree(array $tree): array
    {
        $sum = [];
        $last = null;

        foreach ($tree as $current) {
            // Connect the taxon with it's parent to establish ancestry.
            $current->parent_id = $last ? $last->id : null;
            $doesntExist = ! $current->exists;

            if ($current->isDirty() || $doesntExist) {
                $current->save();
            }

            // If we wanted to attribute the taxa tree to a user,
            // this is the place we do it, adding an entry to
            // activity log.
            if ($doesntExist && $this->model()->user) {
                activity()->performedOn($current)
                    ->causedBy($this->model()->user)
                    ->log('created');
            }

            $sum[] = $current;
            $last = $current;
        }

        return $sum;
    }

    /**
     * Connect the lowest taxon in the row with some of its relations.
     *
     * @param Taxon $taxon
     * @param array $data
     * @return void
     */
    private function saveRelations(Taxon $taxon, array $data)
    {
        $this->createSynonyms($data, $taxon);

        $taxon->conservationLegislations()->sync($this->getConservationLegislations($data), []);
        $taxon->conservationDocuments()->sync($this->getConservationDocuments($data), []);
        $taxon->stages()->sync($this->getStages($data), []);

        $redListData = $this->getRedLists($data);
        if ($redListData != null) {
            $taxon->redLists()->sync(
                collect($redListData)->mapWithKeys(function ($item, $key) {
                    return [$item['id'] => ['category' => $item['category']]];
                })
            );
        }
    }

    /**
     * Check if the value matches with "Yes" translation.
     *
     * @param string $value
     * @return bool
     */
    protected function isTranslatedYes(string $value): bool
    {
        $yes = __('Yes', [], $this->model()->lang);

        return strtolower($yes) === strtolower($value);
    }

    private function createSynonyms(array $item, $taxon)
    {
        $synonyms = Arr::get($item, 'synonyms');
        if (! $synonyms) {
            return;
        }

        foreach (explode('; ', $synonyms) as $synonym) {
            if (str_contains($synonym, ' [')) {
                $s = explode(' [', $synonym);
                $author = substr($s[1], 0, strlen($s[1]) - 1);
                $new_synonym = Synonym::firstOrCreate([
                    'name' => $s[0],
                    'author' => $author ?: null,
                    'taxon_id' => $taxon->id,
                ]);
            } else {
                $new_synonym = Synonym::firstOrCreate([
                    'name' => $synonym,
                    'author' => null,
                    'taxon_id' => $taxon->id,
                ]);
            }
            $new_synonym->save();
        }
    }

    private function getLocaleData($item): array
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();
        $localesData['native_name'] = [];
        $localesData['description'] = [];
        foreach ($locales as $localeCode => $locale) {
            if (Arr::get($item, 'native_name_'.Str::snake($localeCode)) != null) {
                $localesData['native_name'][$localeCode] = Arr::get($item, 'native_name_'.Str::snake($localeCode));
            }
            if (Arr::get($item, 'description_'.Str::snake($localeCode)) != null) {
                $localesData['description'][$localeCode] = Arr::get($item, 'description_'.Str::snake($localeCode));
            }
        }

        return $localesData;
    }

    private function getNonExistingLocaleData(array $existing, array $item): array
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();
        $localesData['native_name'] = [];
        $localesData['description'] = [];
        foreach ($locales as $localeCode => $locale) {
            foreach ($existing['translations'] as $oldTrans) {
                if ($localeCode == $oldTrans['locale']) {
                    if ($this->isEmpty($oldTrans, 'native_name')) {
                        if (Arr::get($item, 'native_name_'.Str::snake($localeCode)) != null) {
                            $localesData['native_name'][$localeCode] = Arr::get($item, 'native_name_'.Str::snake($localeCode));
                        }
                    } else {
                        $localesData['native_name'][$localeCode] = $oldTrans['native_name'];
                    }
                    if ($this->isEmpty($oldTrans, 'description')) {
                        if (Arr::get($item, 'description_'.Str::snake($localeCode)) != null) {
                            $localesData['description'][$localeCode] = Arr::get($item, 'description_'.Str::snake($localeCode));
                        }
                    } else {
                        $localesData['description'][$localeCode] = $oldTrans['description'];
                    }
                }
            }
        }

        return $localesData;
    }

    private function getBoolean(array $item, string $key): bool
    {
        $value = Arr::get($item, $key, false);

        return $this->isTranslatedYes($value) || filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     *  All separators must be semicolon with space afterwards ('; ').
     */
    private function getConservationLegislations(array $data)
    {
        $legislations = strtolower(Arr::get($data, 'conservation_legislations'));
        $legislation_ids = [];
        if (! $legislations) {
            return;
        }
        foreach (explode('; ', $legislations) as $legislation) {
            $leg = $this->conservationLegislations->first(function ($leg) use ($legislation) {
                return strtolower($leg->getNameAttribute()) == $legislation;
            });
            $legislation_ids[] = $leg ? $leg->id : null;
        }

        return $legislation_ids;
    }

    private function getConservationDocuments(array $data)
    {
        $documents = strtolower(Arr::get($data, 'conservation_documents'));
        $document_ids = [];
        if (! $documents) {
            return;
        }
        foreach (explode('; ', $documents) as $document) {
            $doc = $this->conservationDocuments->first(function ($doc) use ($document) {
                return strtolower($doc->getNameAttribute()) == $document;
            });
            $document_ids[] = $doc ? $doc->id : null;
        }

        return $document_ids;
    }

    private function getStages(array $data)
    {
        $stages = strtolower(Arr::get($data, 'stages'));
        $stage_ids = [];
        if (! $stages) {
            return;
        }
        foreach (explode('; ', $stages) as $translation) {
            $stage = $this->stages->first(function ($stage) use ($translation) {
                return strtolower($stage->name_translation) == $translation;
            });
            $stage_ids[] = $stage ? $stage->id : null;
        }

        return $stage_ids;
    }

    private function getRedLists(array $data)
    {
        $red_lists = Arr::get($data, 'red_lists');
        $collection = collect();
        if (! $red_lists) {
            return;
        }
        foreach (explode('; ', $red_lists) as $red_list) {
            $x = explode(' [', $red_list);
            $region = strtolower($x[0]);
            $category = substr($x[1], 0, strlen($x[1]) - 1);

            $red_list = $this->redLists->first(function ($rl) use ($region) {
                return strtolower($rl->getNameAttribute()) == $region;
            });
            if ($red_list) {
                $collection->push(['id' => $red_list->id, 'category' => $category]);
            }
        }

        return $collection;
    }

    private function extractNonExistingData(Taxon $last, array $input): array
    {
        $existing = $last->toArray();
        $collect = [];

        if ($this->isEmpty($existing, 'author')) {
            $collect['author'] = Arr::get($input, 'author') ?: null;
        }
        if ($this->isEmpty($existing, 'fe_old_id')) {
            $collect['fe_old_id'] = Arr::get($input, 'fe_old_id') ?: null;
        }
        if ($this->isEmpty($existing, 'fe_id')) {
            $collect['fe_id'] = Arr::get($input, 'fe_id') ?: null;
        }

        return array_merge(
            $collect,
            [
                'restricted' => $this->getBoolean($input, 'restricted'),
                'allochthonous' => $this->getBoolean($input, 'allochthonous'),
                'invasive' => $this->getBoolean($input, 'invasive'),
                'uses_atlas_codes' => $this->getBoolean($input, 'uses_atlas_codes'),
            ],
        );
    }

    private function isEmpty(array $existing, string $key): bool
    {
        if (! array_key_exists($key, $existing)) {
            return true;
        }

        if ($existing[$key] == null or $existing[$key] == '') {
            return true;
        }

        return false;
    }
}
