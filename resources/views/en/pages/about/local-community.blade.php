@extends('layouts.main', ['title' => 'Local community'])

@section('content')
    <section class="section content">
        <div class="container">
            <h1>Local community</h1>

            <p>
                Name of the local community: {{ config('biologer.community.name') }}.
            </p>

            <p class="has-text-justified">
                <b>Administrators</b> are persons that manages the database, have the overview
                in all the data from local Biologer platform and are in charge for entire
                organisation of the Local community. The initial Administration team is
                approved by the Project team during the foundation of new Local community.
                New Administrators are usually chosen from the Editors team, and this
                decision must be approved by 2/3 of the current Administrators.
                Administrators have right to access the data and to decide about data
                usage (in accordance with the licenses chosen by the Users).
            </p>

            <p class="has-text-justified">
                Administrators of the Local community "{{ config('biologer.community.name') }}" are:
            </p>

            <ul>
                @foreach ($admins as $admin)
                    <li>{{ $admin->full_name }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
