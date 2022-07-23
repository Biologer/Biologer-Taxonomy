@extends('layouts.main', ['title' => __('navigation.closed_license')])

@section('content')
    <div class="container">
        <h1 class="title is-1 has-text-centered mt-4">Привремено затворена лиценца</h1>
        <p class="subtitle is-2 has-text-centered">Лиценца за податке са привремено ограниченим правом приступа (затворена на {{ config('biologer.license_closed_period') }} године)</p>

        <section class="section has-text-justified">
            <p class="mb-4">
                Ова лиценца ближе одређује правила и услове коришћења података из
                Биологер базе података, које корисници не желе одмах да деле са другима.
                Подаци су скривени на период од {{ config('biologer.license_closed_period') }} године и не приказују се на мапи,
                након чега ће бити приказани у целости. Такав начин чувања података може
                бити користан уколико се подаци прикупљају за потребе научног истраживања
                и оставља довољно времена аутору да податке независно објави, пре објавиљива
                у оквиру Биологер платформе.
            </p>

            <p class="mb-4">
                Одабиром ове лиценце привремено се ограничава видљивост унетих података
                осталим корисницима базе. У прве {{ config('biologer.license_closed_period') }} године након уноса податка,
                он ће бити видљив само аутору налаза, таксономским експертима који
                верификују налазе и администраторима веб странице. Подаци под овом
                лиценцом неће одмах бити приказивани на картама распрострањености таксона,
                нити ће корисници моћи да их извезу из базе података. Након {{ config('biologer.license_closed_period') }} године
                од датума уноса налаза у базу податак ће постати отворен и делиће се
                под условима Кријејтив комонс лиценца, ауторство-делити под истим условима (CC BY-SA 4.0).
            </p>

            <p class="mb-4">
                Избором ове лиценце аутори задржавају сва права над унетим подацима.
                Администратори Биологера и таксономски експерти задржавају право
                на употребу података унетих под овом лиценцом и то за потребе израде
                докумената од националног значаја, потребе заштите природе
                (Црвене књиге, Црвене листе, ревизија закона, дефинисање граница заштићених подручја и сл.)
                и за потребе статистичке обраде података (нпр. зарад заштите и очувања таксона и њихових станишта),
                али без објављивања изворног податка. У случају коришћена података за научне публикације,
                могуће је употребити податак у сумарном приказу, без детаља о оригиналном налазу.
                У случају да постоји потреба да се изворни податак под овом лиценцом објави у целости,
                Администратори Биологера и таксономски експерти морају то учинити уз сагласност аутора податка.
            </p>
        </section>
    </div>
@endsection