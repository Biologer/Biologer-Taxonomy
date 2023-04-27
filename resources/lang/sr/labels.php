<?php

return [
    'id' => 'ID',
    'actions' => 'Акције',
    'created_at' => 'Направљено',

    'tables' => [
        'from_to_total' => 'Приказује се :from-:to од укупно :total',
    ],

    'sexes' => [
        'male' => 'Мужјак',
        'female' => 'Женка',
    ],

    'transfer' => [
        'available' => 'Доступне',
        'chosen' => 'Орабране',
    ],

    'login' => [
        'email' => 'Е-пошта',
        'password' => 'Лозинка',
        'forgot_password' => 'Заборавили сте лозинку?',
        'remember_me' => 'Запамти ме',
    ],

    'register' => [
        'first_name' => 'Име',
        'last_name' => 'Презиме',
        'institution' => 'Институција',
        'email' => 'Е-пошта',
        'password' => 'Лозинка',
        'password_confirmation' => 'Поновите лозинку',
        'verification_code' => 'Верификациони код',
        'accept' => 'Слажем се са <a href=":url" title="Политика приватности" target="_blank">Политиком приватности</a>',
    ],

    'forgot_password' => [
        'email' => 'Е-пошта',
    ],

    'reset_password' => [
        'email' => 'Адреса е-поште',
        'password' => 'Лозинка',
        'password_confirmation' => 'Потврдите лозинку',
    ],

    'users' => [
        'first_name' => 'Име',
        'last_name' => 'Презиме',
        'institution' => 'Институција',
        'roles' => 'Улоге',
        'curated_taxa' => 'Таксони које уређује',
        'email' => 'Е-пошта',
        'search' => 'Тражи',
    ],

    'taxa' => [
        'rank' => 'Таксономска категорија',
        'name' => 'Назив',
        'parent' => 'Родитељски таксон',
        'author' => 'Аутор',
        'native_name' => 'Народни назив',
        'description' => 'Опис',
        'fe_old_id' => '(стара) FaunaEuropea ID',
        'fe_id' => 'FaunaEuropea ID',
        'restricted' => 'Tаксон са органиченим подацима',
        'allochthonous' => 'Таксон је алохтон',
        'invasive' => 'Таксон је инвазиван',
        'stages' => 'Стадијуми',
        'conservation_legislations' => 'Законска заштита',
        'conservation_documents' => 'Остала документа',
        'red_lists' => 'Црвене листе',
        'add_red_list' => 'Додај црвену листу',
        'search_for_taxon' => 'Тражи таксон...',

        'include_lower_taxa' => 'Укључујући ниже таксоне',


        'atlas_codes' => 'Атлас кодови',
        'uses_atlas_codes' => 'Користи Атлас кодове',
        'synonyms' => 'Синоними',
        'add_synonym' => 'Додај синоним',
        'remove_synonym' => 'Обриши синоним',

        'synonym_name' => 'Назив',
        'synonym_author' => 'Аутор',
    ],

    'field_observations' => [
        'taxon' => 'Таксон',
        'original_identification' => 'Оригинална идентификација',
        'search_for_taxon' => 'Тражи таксон...',
        'date' => 'Датум',
        'year' => 'Година',
        'month' => 'Месец',
        'day' => 'Дан',
        'photos' => 'Фотографије',
        'upload' => 'Отпреми',
        'map' => 'Мапа',
        'latitude' => 'Географска ширина',
        'longitude' => 'Географска дужина',
        'accuracy_m' => 'Прецизност/Полупречник (m)',
        'accuracy' => 'Прецизност',
        'elevation_m' => 'Надморска висина (m)',
        'elevation' => 'Надморска висина',
        'location' => 'Локација',
        'details' => 'Детаљи',
        'more_details' => 'Више детаља',
        'less_details' => 'Мање детаља',
        'note' => 'Белешка',
        'number' => 'Број',
        'project' => 'Пројекат',
        'project_tooltip' => 'Ако су подаци прикупљени у оквиру пројекта, овде упишите назив/број пројекта.',
        'habitat' => 'Станиште',
        'found_on' => 'Нађено на',
        'found_on_tooltip' => 'Можете попунити ово поље ако је врста нађена на домаћину (нпр. латински назив биљке хранитељке гусенице), измет (нпр. измет козе за скарабеје), стрвина (за тврдокрилце стрвинаре), супстрат, итд.',
        'sex' => 'Пол',
        'stage' => 'Стадијум',
        'time' => 'Време',
        'observer' => 'Уочио',
        'identifier' => 'Идентификовао',
        'found_dead' => 'Јединка нађена мртва?',
        'found_dead_note' => 'Белешке о мртвој јединки',
        'data_license' => 'Лиценца податка',
        'image_license' => 'Лиценца слика',
        'default' => 'Подразумевано',
        'choose_a_stage' => 'Одаберите стадијум',
        'choose_a_value' => 'Одаберите вредност',
        'click_to_select' => 'Кликнитекако бисте одабрали...',
        'status' => 'Статус',
        'types' => 'Тип налаза',
        'types_placeholder' => 'Одаберите тип налаза',
        'dataset' => 'Сет података',
        'mgrs10k' => 'MGRS 10K',
        'atlas_code' => 'Атлас код',

        'statuses' => [
            'approved' => 'Одобрено',
            'unidentifiable' => 'Немогућа идентификација',
            'pending' => 'На чекању',
        ],

        'save_tooltip' => 'Чува тренутни налаз и враћа вас у листу  налаза. Можете користити и пречицу Ctrl+Enter на тастатури.',
        'save_more_tooltip' => 'Чува тренутни налаз, али вам омогућава да унесете још података са истог места. Можете користити и пречицу Ctrl+Shift+Enter на тастатури.',

        'include_lower_taxa' => 'Укључујући ниже таксоне',

        'submitted_using' => 'Послато преко',
    ],

    'view_groups' => [
        'name' => 'Назив',
        'parent' => 'Виша група',
        'description' => 'Опис',
        'taxa' => 'Таксони',
        'image' => 'Слика',
        'only_observed_taxa' => 'Само опажени таксони',
    ],

    'exports' => [
        'title' => 'Извоз',
        'processing' => 'Извоз у току... Ово може потрајати.',
        'only_checked' => 'Извези само чекиране',
        'apply_filters' => 'Примени филтере',
        'with_header' => 'Са називима колона',
        'finished' => 'Готово! Можете преузети извезену датотеку.',
        'columns' => 'Колоне',
        'types' => [
            'custom' => 'Прилагођено',
            'darwin_core' => 'Darwin Core',
        ],
    ],

    'imports' => [
        'choose_columns' => 'Одабери колоне',
        'select_import_file' => 'Одабери CSV/XLSX датотеку',
        'available' => 'Доступне',
        'chosen' => 'Одабране',
        'import' => 'Увези',
        'row_number' => 'Број реда',
        'error' => 'Грешка',
        'has_heading' => 'Први ред садржи називе колона',
        'columns' => 'Колоне',
        'user' => 'За корисника',
        'approve_curated' => 'Потврди налазе за таксоне које уређујем',
        'replace' => 'Замени постојеће податке са подацима из увоза',
        'append' => 'Само додај недостајуће податке из увоза, али не мењај постојеће податке',
    ],

    'announcements' => [
        'title' => 'Наслов',
        'message' => 'Текст',
        'private' => 'Само за чланове',
        'publish' => 'Објави',
    ],

    'publications' => [
        'type' => 'Тип публикације',
        'name' => 'Назив',
        'symposium_name' => 'Назив симпозијума',
        'book_chapter_name' => 'Назив књиге',
        'paper_name' => 'Назива часописа',
        'title' => 'Наслов',
        'year' => 'Година',
        'issue' => 'Број/издање',
        'publisher' => 'Издавач',
        'place' => 'Место издавања',
        'page_count' => 'Број страница',
        'page_range' => 'Од-до странице',
        'authors' => 'Аутори',
        'editors' => 'Уредници',
        'attachment' => 'Прилог',
        'link' => 'Линк',
        'doi' => 'DOI',
        'citation' => 'Цитирање',
        'citation_tooltip' => 'Ово поље ће се само генерисати ако остане празно',
        'add_author' => 'Додај аутора',
        'add_editor' => 'Додај уредника',
        'first_name' => 'Име',
        'last_name' => 'Презиме',

        'search' => 'Тражи',
    ],

    'literature_observations' => [
        'publication' => 'Публикација',
        'is_original_data' => 'Податак изворно из ове публикације?',
        'original_data' => 'Оригинални податак',
        'citation' => 'Цитирање',
        'cited_publication' => 'Цитирана публикација',
        'search_for_publication' => 'Тражи публикацију',
        'taxon' => 'Таксон',
        'search_for_taxon' => 'Тражи таксон',
        'date' => 'Датум',
        'year' => 'Година',
        'month' => 'Месец',
        'day' => 'Дан',
        'latitude' => 'Географска ширина',
        'longitude' => 'Географска дужина',
        'mgrs10k' => 'MGRS 10k',
        'accuracy' => 'Прецизност',
        'accuracy_m' => 'Прецизност (m)',
        'location' => 'Локација',
        'elevation' => 'Надморска висина',
        'elevation_m' => 'Надморска висина (m)',
        'minimum_elevation' => 'Минимална надморска висина',
        'minimum_elevation_m' => 'Минимална надморска висина (m)',
        'maximum_elevation' => 'Максимална надморска висина',
        'maximum_elevation_m' => 'Максимална надморска висина (m)',
        'stage' => 'Стадијум',
        'choose_a_stage' => 'Одаберите стадијум',
        'sex' => 'Пол',
        'choose_a_value' => 'Одаберите вредност',
        'number' => 'Број',
        'note' => 'Белешка',
        'habitat' => 'Станиште',
        'found_on' => 'Нађено на',
        'found_on_tooltip' => 'Можете попунити ово поље ако је врста нађена на (нпр. латински назив биљке хранитељке гусенице), измет (нпр. измет козе за скарабеје), стрвина (за тврдокрилце стрвинаре), супстрат, итд.',
        'time' => 'Време налаза',
        'click_to_select' => 'Кликните да одаберете',
        'project' => 'Пројекат',
        'project_tooltip' => 'Ако су подаци прикупљени у оквиру пројекта, овде упишите назив/број пројекта.',
        'dataset' => 'Сет података',
        'observer' => 'Уочио/ла',
        'identifier' => 'Идентификовао/ла',
        'original_date' => 'Оригинални датум',
        'original_locality' => 'Оригинални локалитет',
        'original_coordinates' => 'Оригиналне координате',
        'original_elevation' => 'Оригинална надморска висина',
        'original_elevation_placeholder' => 'нпр. 100-200m',
        'original_identification' => 'Оригинална идентификација',
        'original_identification_validity' => 'Валидност оригиналне идентификације',
        'other_original_data' => 'Остали оригинални подаци',
        'collecting_start_year' => 'Година почетка сакупљања',
        'collecting_start_month' => 'Месец почетка сакупљања',
        'collecting_end_year' => 'Година краја сакупљања',
        'collecting_end_month' => 'Месец краја сакупљања',
        'place_where_referenced_in_publication' => 'Место где је наведено у публикацији',
        'place_where_referenced_in_publication_placeholder' => 'нпр. Страница 45, Слика 4 или Табела 3',
        'georeferenced_by' => 'Геореференцирао/ла',
        'georeferenced_date' => 'Датум геореференцирања',

        'add_new_publication' => 'Додајте нову публикацију',

        'verbatim_data' => 'Подаци како су наведени у публикацији',

        'validity' => [
            'invalid' => 'Неисправна',
            'valid' => 'Исправна',
            'synonym' => 'Синоним',
        ],

        'save_tooltip' => 'Чува тренутни налаз и враћа вас у листу налаза. Можете користити и пречицу Ctrl+Enter на тастатури.',
        'save_more_tooltip' => 'Чува тренутни налаз, али вам омогућава да унесете још података са истог места. Можете користити и пречицу Ctrl+Shift+Enter на тастатури.',

        'save_more_same_taxon' => 'Сачувај (још, исти таксон)',
        'save_more_same_taxon_tooltip' => 'Чува тренутни налаз, али вам омогућава да унесете још података са истог места и за исти таксон.',

        'include_lower_taxa' => 'Укључујући ниже таксоне',
    ],

    'preferences' => [
        'account' => [
            'delete_account' => 'Обриши налог',
            'delete_observations' => 'Обриши и унете налазе',
        ],

        'notifications' => [
            'notification' => 'Нотификација',
            'inapp' => 'На сајту',
            'mail' => 'Е-поштом',

            'field_observation_approved' => 'Налаз је одобрен',
            'field_observation_edited' => 'Налаз је измењен',
            'field_observation_moved_to_pending' => 'Налаз је стављен на чекање',
            'field_observation_marked_unidentifiable' => 'Налаз је означен као да није могућа идентификација',
            'field_observation_for_approval' => 'Нов налаз за преглед',
        ],
    ],

    'countries' => 'Државе у којима је забележен таксон.',
];
