@extends('layouts.main')

@section('content')
    <section class="section is-hidden-touch mb-8">
        <div class="container has-text-centered">
            <h1><img src="{{ asset('img/logo.svg') }}" class="image banner-image mx-auto" alt="{{ config('app.name') }}"></h1>
        </div>
    </section>

    <div class="container py-8 px-4 desktop:px-16">
        <p class="is-size-4 mb-8">
            Are you a taxonomic expert? Biologer taxa is only a taxonomic backbone for local Biologer communities.
            Users have no permission to change anything within the taxonomic tree of life,
            but you might wish to register for an editor.
            Otherways, we suggest you register within our local communities in Serbia, Croatia, Bosnia and Herzegovina or Montenegro.
            <!-- { { __('pages.home.welcome') }} -->
            <!--  { { __('pages.home.stats', compact('community', 'userCount', 'observationCount')) }} -->

        </p>

        <section class="mt-8">
            @if ($announcements->isNotEmpty())
                <h2 class="is-size-2 has-text-centered mb-8">{{ __('pages.home.announcements.title') }}</h2>

                @each('partials.announcement', $announcements, 'announcement')

                <a href="{{ route('announcements.index') }}">{{ __('pages.home.announcements.see_all') }}</a>
            @endif
        </section>
    </div>
@endsection
