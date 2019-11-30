@extends('parts.page-wrapper')
@section('page-wrapper-class')
    static
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => 'partners/', 'title' => 'Партнеры'],
            ['link' => 'partners/imi', 'title' => 'Институт международных исследований'],

        ]])
        <div class="content-block">
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>ИНСТИТУТ МЕЖДУНАРОДНЫХ ИССЛЕДОВАНИЙ</h1>
                </div>
                <div class="content-block__main-body">
                    <section class="article">
                        <p>Институт международных исследований (ИМИ) МГИМО МИД России создан в мае 2009 года в целях развития и углубления аналитической работы Университета в области международных отношений, решения задач по выявлению тенденций эволюции международных процессов, освоения новых исследовательских вопросов, проведения экспертизы и обоснования внешнеполитических инициатив и мероприятий.</p>
                        <p>ИМИ является правопреемником и продолжателем исследовательских и аналитических структур МГИМО — Проблемной научно-исследовательской лаборатории системного анализа международных отношений (1976-1990 гг.), Центра международных исследований (1990-2004 гг.) и Научно-координационного совета по международным исследованиям (2004-2009 гг.).</p>
                        <p>Получателями научно-экспертной продукции Института международных исследований являются основные государственные структуры, занимающиеся вопросами формирования внешней политики страны: Администрация Президента РФ, Аппарат Правительства РФ, Совет Федерации, Государственная Дума, Совет Безопасности РФ, Министерство иностранных дел, Министерство обороны, ОДКБ и другие.</p>
                        <p>
                            В состав Института международных исследований входит 11 научно- исследовательских центров, охватывающих своей деятельностью и научными интересами ключевые международные проблемы — от вопросов развития на постсоветском пространстве до проблем разоружения и урегулирования международных конфликтов, от анализа ситуаций в АТР до концептуальных проблем регионоведения. Коллективами центров ведется разноплановая научно-аналитическая работа, публикуются научно-исследовательские материалы, готовятся аналитические доклады и записки по актуальным вопросам мировой политики.
                        </p>
                        <p>Стратегия развития ИМИ предполагает создание в его рамках ряда новых исследовательских центров, нацеленных на изучение международных проблем, которые в ближайшие годы будут иметь определяющий характер для национальных интересов России. Речь, в частности, идет об исследовании международных политических элит, мировых экономических процессов и санкционной политики и др.</p>
                        <p>Директор ИМИ — Андрей Андреевич Сушенцов.</p>
                        <p>Заместитель директора ИМИ — Александр Леонидович Чечевишников.</p>
                        <p><a href="https://mgimo.ru/about/structure/ucheb-nauch/imi/" target="_blank" a>https://mgimo.ru/about/structure/ucheb-nauch/imi/</a></p>
                    </section>
                </div>
            </div>

        </div>


    </main>
@stop
