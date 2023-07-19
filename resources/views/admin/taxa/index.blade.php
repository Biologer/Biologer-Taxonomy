@extends('layouts.dashboard', ['title' => __('navigation.taxa')])

@section('content')
    <div class="box">
        <nz-taxa-table
            list-route="api.taxa.index"
            edit-route="admin.taxa.edit"
            delete-route="api.taxa.destroy"
            add-country-url="{{ route('api.taxonomy.add_country') }}"
            remove-country-url="{{ route('api.taxonomy.remove_country') }}"
            export-url="{{ route('api.taxon-exports.store') }}"
            :export-columns="{{ $exportColumns }}"
            :ranks="{{ $ranks }}"
            :countries=" {{ $countries }}"
            empty="{{ __('No data...') }}"
            show-activity-log
        >
        </nz-taxa-table>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.taxa') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('admin.taxa.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.add') }}</span>
    </a>
    <a href="{{ route('admin.taxa-import.index') }}" class="button is-secondary is-outlined ml-2">
        @include('components.icon', ['icon' => 'upload'])
        <span>{{ __('navigation.import') }}</span>
    </a>
@endsection
