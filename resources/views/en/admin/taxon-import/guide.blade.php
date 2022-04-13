@extends('layouts.dashboard', ['title' => __('navigation.taxa_import')])

@section('content')
    <div class="box content">
        <h1>Taxons import guide</h1>

        <span>Work in progress</span>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('admin.taxa.index') }}">{{ __('navigation.taxa') }}</a></li>
            <li><a href="{{ route('admin.taxa-import.index') }}">{{ __('navigation.taxa_import') }}</a></li>
            <li class="is-active"><a>Uputstvo za uvoz</a></li>
        </ul>
    </div>
@endsection
