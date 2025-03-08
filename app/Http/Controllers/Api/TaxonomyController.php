<?php

namespace App\Http\Controllers\Api;

use App\ConservationDocument;
use App\ConservationLegislation;
use App\Country;
use App\Http\Resources\TaxonResource;
use App\Jobs\SendTaxonSyncRequest;
use App\RedList;
use App\Support\Taxonomy;
use App\Taxon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaxonomyController
{
    use AuthorizesRequests;

    /**
     * Check connectivity to this database.
     */
    public function check(Request $request)
    {
        $input = $request->all();
        $country_code = Taxonomy::checkKey($input['key']);
        if ($country_code == '') {
            return response('Unauthorized!', 401);
        }

        $country = Country::findByCode($country_code);

        return response($country->name, 200);
    }


    /**
     * Connect to this database, while providing important data for synchronization to work.
     *
     * @param Request $request
     * @return Response
     */
    public function connect(Request $request)
    {
        $input = $request->all();
        $country_code = Taxonomy::checkKey($input['key']);
        if ($country_code == '') {
            return response('Unauthorized!', 401);
        }

        $country = Country::findByCode($country_code);
        if ($country->active) {
            return response('Already connected!');
        }

        $country->redLists()->syncWithoutDetaching($this->findOrCreateRedLists($input['red_lists']));
        $country->conservationDocuments()->syncWithoutDetaching($this->findOrCreateConservationDocuments($input['docs']));
        $country->conservationLegislations()->syncWithoutDetaching($this->findOrCreateConservationLegislationDocuments($input['legs']));

        // Set Country as active in further sync's
        $country->setActive();

        return response('Connected!', 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function disconnect(Request $request)
    {
        $input = $request->all();
        $country_code = Taxonomy::checkKey($input['key']);
        if ($country_code == '') {
            return response('Unauthorized!', 401);
        }

        $country = Country::findByCode($country_code);
        if ($country->active) {
            $country->setDeactive();
        }

        return response('Disconnected! Your server will no longer receive updates from Taxonomy base.', 200);
    }


    /**
     * Allow local databases to search for taxa in taxonomy database.
     *
     * @param Request $request
     * @return array|Application|ResponseFactory|Response
     */
    public function sync(Request $request)
    {
        $input = $request->all();
        $country_code = Taxonomy::checkKey($input['key']);
        if ($country_code == '') {
            return response('Unauthorized!', 401);
        }

        $country = Country::findByCode($country_code);

        $taxa = $input['taxa'];

        foreach ($taxa as $id => $item) {
            $taxon = Taxon::findByRankNameAndAncestor($item['name'], $item['rank'], $item['ancestor_name']);

            if ($taxon == null) {
                $taxa[$id]['response'] = '';

                continue;
            }
            $taxon->countries()->sync($country->id, false);

            $taxa[$id]['response'] = new TaxonResource($taxon->load([
                'conservationLegislations', 'redLists', 'conservationDocuments',
                'stages', 'synonyms', 'parent',
            ]));

            $taxa[$id]['response']['reason'] = 'Data updated from Biologer Taxonomy database.';
        }

        $country_ref = [];
        foreach ($country->redLists()->get()->toArray() as $item) {
            $country_ref['redLists'][$item['pivot']['red_list_id']] = $item['pivot']['ref_id'];
        }
        foreach ($country->conservationLegislations()->get()->toArray() as $item) {
            $country_ref['legs'][$item['pivot']['leg_id']] = $item['pivot']['ref_id'];
        }
        foreach ($country->conservationDocuments()->get()->toArray() as $item) {
            $country_ref['docs'][$item['pivot']['doc_id']] = $item['pivot']['ref_id'];
        }

        $data['taxa'] = $taxa;
        $data['country_ref'] = $country_ref;

        return $data;
    }

    private function findOrCreateRedLists($red_lists)
    {
        // Red lists
        $rls = RedList::all();
        $syncIds = [];
        foreach ($red_lists as $redlist) {
            $res = $rls->firstWhere('slug', $redlist['slug']);

            if ($res != null) {
                $syncIds[$res->id] = ['ref_id' => $redlist['id']];

                continue;
            }

            // Try by translation
            foreach ($redlist['translations'] as $trans) {
                foreach ($rls as $rl) {
                    foreach ($rl->translations as $rl_trans) {
                        if ($rl_trans->name == $trans['name']) {
                            $syncIds[$rl->id] = ['ref_id' => $redlist['id']];

                            continue 3;
                        }
                    }
                }
            }

            // Create new
            $res = RedList::firstOrCreate(['slug' => $redlist['slug']]);
            foreach ($redlist['translations'] as $trans) {
                $res->update([
                    $trans['locale'] => ['name' => $trans['name']],
                ]);
            }
            $syncIds[$res->id] = ['ref_id' => $redlist['id']];
        }

        return $syncIds;
    }

    private function findOrCreateConservationDocuments($docs)
    {
        // Conservation documents
        $cds = ConservationDocument::all();

        $syncIds = [];
        foreach ($docs as $doc) {
            $res = $cds->firstWhere('slug', $doc['slug']);

            if ($res != null) {
                $syncIds[$res->id] = ['ref_id' => $doc['id']];

                continue;
            }

            // Try by translation
            foreach ($doc['translations'] as $trans) {
                foreach ($cds as $rl) {
                    foreach ($rl->translations as $rl_trans) {
                        if ($rl_trans->name == $trans['name']) {
                            $syncIds[$rl->id] = ['ref_id' => $doc['id']];

                            continue 3;
                        }
                    }
                }
            }

            // Create new
            $res = ConservationDocument::firstOrCreate(['slug' => $doc['slug']]);
            foreach ($doc['translations'] as $trans) {
                $res->update([
                    $trans['locale'] => ['name' => $trans['name']],
                ]);
            }
            $syncIds[$res->id] = ['ref_id' => $doc['id']];
        }

        return $syncIds;
    }

    private function findOrCreateConservationLegislationDocuments($legs)
    {
        // Conservation legislations
        $clds = ConservationLegislation::all();

        $syncIds = [];
        foreach ($legs as $leg) {
            $res = $clds->firstWhere('slug', $leg['slug']);

            if ($res != null) {
                $syncIds[$res->id] = ['ref_id' => $leg['id']];

                continue;
            }

            // Try by translation
            foreach ($leg['translations'] as $trans) {
                foreach ($clds as $rl) {
                    foreach ($rl->translations as $rl_trans) {
                        if ($rl_trans->name == $trans['name']) {
                            $syncIds[$rl->id] = ['ref_id' => $leg['id']];

                            continue 3;
                        }
                    }
                }
            }

            // Create new
            $res = ConservationLegislation::firstOrCreate(['slug' => $leg['slug']]);
            foreach ($leg['translations'] as $trans) {
                $res->update([
                    $trans['locale'] => ['name' => $trans['name']],
                ]);
            }
            $syncIds[$res->id] = ['ref_id' => $leg['id']];
        }

        return $syncIds;
    }

    public function removeTaxon($taxon)
    {
        $data['taxon'] = $taxon->toArray();

        foreach ($taxon->countries()->get() as $country) {
            if (! $country->active) {
                continue;
            }

            $data['key'] = config('biologer.taxonomy_key_'.$country->code);

            // http::post($country->url.'/api/taxonomy/remove', $data);
            dispatch(new SendTaxonSyncRequest($country->url, '/api/taxonomy/remove', $data));
        }
    }

    public function addToCountry()
    {
        $taxa = Taxon::with([
            'conservationLegislations', 'redLists', 'conservationDocuments',
            'stages', 'synonyms', 'parent',
        ])->whereIn('id', request('taxa_ids'))->get();

        foreach ($taxa as $taxon) {
            $oldCountries = $taxon->countries()->get();

            $taxon->countries()->syncWithoutDetaching(request('country_id', []));

            $taxon->save();

            $this->sendUpdatesToLocalDatabases($taxon, $oldCountries, 'Adding taxon to country');
        }
    }

    public function removeFromCountry()
    {
        $taxa = Taxon::with([
            'conservationLegislations', 'redLists', 'conservationDocuments',
            'stages', 'synonyms', 'parent',
        ])->whereIn('id', request('taxa_ids'))->get();

        foreach ($taxa as $taxon) {
            $oldCountries = $taxon->countries()->get();

            $country_ids = [];

            foreach ($oldCountries as $country) {
                $country_ids[] = $country->id;
            }

            $country_id = request('country_id');

            if (($key = array_search($country_id, $country_ids)) !== false) {
                unset($country_ids[$key]);
            }

            $taxon->countries()->sync($country_ids);

            $taxon->save();

            $this->sendUpdatesToLocalDatabases($taxon, $oldCountries, 'Removing from current country');
        }
    }

    public function sendUpdatesToLocalDatabases(Taxon $taxon, $oldCountries, $reason, $country_id = null)
    {
        $data['taxon'] = $taxon->toArray();
        $data['parent'] = [];

        $parent = $taxon->parent;

        if ($parent) {
            $data['parent']['name'] = $parent->name;
            $data['parent']['rank'] = $parent->rank;
        }

        $data['taxon']['reason'] = $reason;
        $countries = $taxon->countries()->get();

        foreach ($countries as $country) {
            $data['key'] = config('biologer.taxonomy_key_'.$country->code);

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

            dispatch(new SendTaxonSyncRequest($country->url, '/api/taxonomy/sync', $data));
        }

        foreach ($oldCountries as $country) {
            // Taxon should be disconnected from taxonomy if it was previously here, otherwise just continue..
            if (! $countries->contains($country)) {
                $data['key'] = config('biologer.taxonomy_key_'.$country->code);

                dispatch(new SendTaxonSyncRequest($country->url, '/api/taxonomy/deselect', $data));
            }
        }

        if ($country_id) {
            $country = Country::find($country_id);
            $data['key'] = config('biologer.taxonomy_key_'.$country->code);

            dispatch(new SendTaxonSyncRequest($country->url, '/api/taxonomy/deselect', $data));
        }
    }
}
