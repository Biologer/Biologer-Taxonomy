@extends('layouts.main', ['title' => 'Lokalna zajednica'])

@section('content')
    <section class="section content">
        <div class="container">
            <h1>Lokalna zajednica</h1>

            <p>
                Naziv lokalne zajednice: {{ config('biologer.community.name') }}.
            </p>

            <p class="has-text-justified">
                <b>Administratori</b> su lica koja upravljaju bazom podataka, imaju
                uvid u sve podatke u okviru lokalne Biologer platforme i zaduženi
                su za cjelokupnu organizaciju Lokalne zajednice. Početni tim Administratora
                odobrava Projektni tim prilikom pokretanja nove Lokalne zajednice.
                Novi Administratori se obično biraju iz redova Urednika, za šta je
                neophodna saglasnost 2/3 postojećih Administratora. Administratori
                imaju pravo da raspolažu svim podacima i da donose odluke o njihovom
                korištenju (u skladu sa licencama koje izaberu Korisnici).
            </p>

            <p class="has-text-justified">
                Administratori Lokalne zajednice „{{ config('biologer.community.name') }}“ su:
            </p>

            <ul>
                @foreach ($admins as $admin)
                    <li>{{ $admin->full_name }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
