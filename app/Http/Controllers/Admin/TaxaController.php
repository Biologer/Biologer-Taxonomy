<?php

namespace App\Http\Controllers\Admin;

use App\ConservationDocument;
use App\ConservationLegislation;
use App\Country;
use App\Exports\Taxa\CustomTaxaExport;
use App\RedList;
use App\Stage;
use App\Taxon;

class TaxaController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.taxa.index', [
            'exportColumns' => CustomTaxaExport::availableColumnData(),
            'ranks' => Taxon::getRankOptions(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Show page to create taxon.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.taxa.create', [
            'ranks' => Taxon::getRankOptions(),
            'conservationLegislations' => ConservationLegislation::all(),
            'conservationDocuments' => ConservationDocument::all(),
            'redLists' => RedList::all(),
            'redListCategories' => collect(RedList::CATEGORIES),
            'stages' => Stage::all(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Show page to edit taxon.
     *
     * @param \App\Taxon $taxon
     * @return \Illuminate\View\View
     */
    public function edit(Taxon $taxon)
    {
        return view('admin.taxa.edit', [
            'taxon' => $taxon->load([
                'parent',
                'redLists',
                'conservationLegislations',
                'conservationDocuments',
                'stages',
                'countries',
            ]),
            'ranks' => Taxon::getRankOptions(),
            'conservationLegislations' => ConservationLegislation::all(),
            'conservationDocuments' => ConservationDocument::all(),
            'redLists' => RedList::all(),
            'redListCategories' => collect(RedList::CATEGORIES),
            'stages' => Stage::all(),
            'synonyms' => $taxon->load(['synonyms']),
            'countries' => Country::all(),
        ]);
    }
}
