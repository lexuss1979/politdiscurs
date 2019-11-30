@extends('parts.page-wrapper')
@section('page-wrapper-class')
    static
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => 'partners/', 'title' => 'Партнеры'],
            ['link' => 'partners/rapn', 'title' => 'Российская ассоциациация политической науки'],

        ]])
        <div class="content-block">
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>РОССИЙСКАЯ АССОЦИАЦИАЦИЯ ПОЛИТИЧЕСКОЙ НАУКИ</h1>
                </div>
                <div class="content-block__main-body">
                    <section class="article">
                        <p>Российская ассоциация политической науки (РАПН) восходит своей историей к середине 1950-х гг.: участие в III Всемирном конгрессе Международной Ассоциации политической науки (Стокгольм, 1955) дает организации статус коллективного члена МАПН. В апреле 1960 г. Секция реорганизуется в Советскую Ассоциацию политических (государствоведческих) наук.</p>
                        <p>Значимым событием в истории Ассоциации стал ХI Всемирный конгресс МАПН (Москва, 1979), в котором участвовали более 1500 человек. Конгресс придал значительный импульс развитию отечественной политической науки.</p>
                        <p>В 1991 г. Общероссийская общественная организация &quot;Российская ассоциация политической науки&quot; становится преемницей САПН, в том числе как член МАПН.</p>
                        <p>Ныне РАПН действует в 60 регионах страны и насчитывает более 1000 человек. Молодежное отделение РАПН составляет около 250 человек.</p>
                        <p>В 1990-е – первой половине 2000-х годов особую роль в развитии российской политологии сыграл учрежденный при участии РАПН журнал «Политические исследования (Полис)», институциональный член МАПН. В последние годы возрастает значение журнала «Политическая наука», одним из учредителей которого является также РАПН. В современных условиях постоянно растет значение сайта РАПН (<a  href="http://rapn.ru/" target="_blank">http://rapn.ru/</a>).</p>
                        <p>Крупными вехами институционализации политической науки, фактором профессионализации и специализации сообщества стали 6 Всероссийских конгрессов политологов. Первый из них прошел в 1998 г.; в ноябре 2015 года в МГИМО (У) МИД России состоится юбилейный 7-й конгресс, посвященный 60-летию организации.
                        </p>
                        <p>Ежегодно (за исключением года проведения конгрессов) РАПН проводит всероссийские конференции с международным участием. Новым этапом в развитии ассоциации стал проект «Субдисциплины». В его рамках ИК РАПН выполнили серию исследований, результаты которых в 2010-2012 гг. опубликованы в соответствующей рубрике журнала «Полис» и изданы РОССПЭН в серии «Библиотека РАПН».
                        </p>
                        <p>Под эгидой РАПН выполняются исследовательские проекты, поддерживаемые грантами президента РФ, а также РФФИ, РГНФ, ИНОП.
                        </p>
                        <p>В 2013 г. Министерство образования и науки РФ закрепило за РАПН Центра ответственности по выработке предложений относительно определения объемов и структуры контрольных цифр приема укрупненной группы направлений подготовки (УГНП) 41.00.00. Политические науки и регионоведение – специальности политология, международные отношения, регионоведение России, зарубежное регионоведение, востоковедение и африканистика.  В условиях сокращения контрольных цифр приема практически по всем обществоведческим специальностям РАПН удалось добиться существенного увеличения контрольных цифр по своей группе специальностей относительно прошлых лет.
                        </p>
                        <p>РАПН активно участвует в учебно-методической работе. В июле 2015 г. приказом министра образования и науки РФ Д.В.Ливанова президент РАПН О.В.Гаман-Голутвина, (руководит РАПН с 2010 г.), была назначена председателем Федерального Учебно-методического объединения по УГНП 41.00.00.
                        </p>
                        <p>Роль РАПН в общественной жизни страны был отмечена руководством страны: в 2014 г. Указом президента РФ В.В.Путина руководитель организации О.В.Гаман-Голутвина была награждена медалью ордена «За заслуги перед Отечеством» II степени.</p>
                        <p>РАПН – динамично развивающаяся общественная организация, которая сильна своими региональными отделениями, действующими на базе практически всех основных университетов страны.
                        </p>
                        <p>Основные итоги научного развития отечественной политологии за два столетия и в последние двадцать лет отражены в фундаментальном издании «Российская политическая наука : в 5 томах / Под общ. ред. А. И. Соловьева» (М.: РАПН, РОССПЭН, 2008). В 2015 г. готовится к изданию новая серия «Российская политическая наука: истоки и перспективы».
                        </p>
                        <p><a href="https://www.rapn.ru/" target="_blank">https://www.rapn.ru/</a></p>
                    </section>
                </div>
            </div>

        </div>


    </main>
@stop
