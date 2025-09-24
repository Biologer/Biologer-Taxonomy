@extends('layouts.main', ['title' => 'Локална заједница'])

@section('content')
    <section class="section content">
        <div class="container">
            <h1>Локална заједница</h1>

            <p>
                Назив локалне заједнице: {{ config('biologer.community.name') }}.<br>
                Држава: {{ __(config('biologer.community.country')) }}.</br>
                Адреса: {{ config('biologer.community.address') }}.
            </p>

            <p class="has-text-justified">
                <b>Администратори</b> су лица која управљају базом података, имају
                увид у све податке у оквиру локалне Биологер платформе и задужени
                су за целокупну организацију Локалне заједнице. Почетни тим Администратора
                одобрава Пројектни тим приликом покретања нове Локалне заједнице.
                Нови Администратори се обично бирају из редова Уредника, за шта је
                неопходна сагласност 2/3 постојећих Администратора. Администратори
                имају право да располажу свим подацима и да доносе одлуке о њиховом
                коришћењу (у складу са лиценцама које изаберу Корисници).
            </p>

            <p class="has-text-justified">
                Администратори Локалне заједнице „{{ config('biologer.community.name') }}“ су:
            </p>

            <ul>
                @foreach ($admins as $admin)
                    <li>{{ $admin->full_name }}</li>
                @endforeach
            </ul>

        </div>
    </section>
@endsection
