@extends('parts.page-wrapper')


@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => 'partners/', 'title' => 'Партнеры'],

        ]])
        <div class="content-block">
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>Партнеры</h1>
                </div>
                <div class="content-block__main-body">
                    <section class="article">
                         <p>Центр политических и международных исследований и Российская ассоциация политической науки благодарят организации, которые в разных формах внесли вклад в создание данного образовательного ресурса и подготовку материалов для него:</p>
                            <p>&nbsp;</p>
                            <div class="partners">
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/001.jpg" width="170"></div>
                                    <div class="prtname">Министерство образования и науки РФ</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/002.jpg" width="170"></div>
                                    <div class="prtname">Министерство культуры РФ</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/003.jpg" width="170"></div>
                                    <div class="prtname">Министерство иностранных дел РФ</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/004.jpg" width="170"></div>
                                    <div class="prtname">Общество «Знание» России</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/005.jpg" width="170"></div>
                                    <div class="prtname">МГИМО (У) МИД России</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/006.jpg" width="170"></div>
                                    <div class="prtname">Институт международных исследований МГИМО</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/007.jpg" width="170"></div>
                                    <div class="prtname">Центр Евро-атлантической безопасности ИМИ МГИМО</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/008.jpg" width="170"></div>
                                    <div class="prtname">Институт мировой экономики и международных отношений ИМЭМО РАН</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/009.jpg" width="170"></div>
                                    <div class="prtname">Центр международной безопасности ИМЭМО РАН</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/010.jpg" width="170"></div>
                                    <div class="prtname">Национальный исследовательский университет – Высшая Школа Экономики</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/011.jpg" width="170"></div>
                                    <div class="prtname">Институт российской истории РАН</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/012.jpg" width="170"></div>
                                    <div class="prtname">Институт этнологии и антропологии РАН</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/013.jpg" width="170"></div>
                                    <div class="prtname">Портал «История.РФ» Министерства культуры РФ</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/014.jpg" width="170"></div>
                                    <div class="prtname">ООО «Кирилл и Мефодий»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/015.jpg" width="170"></div>
                                    <div class="prtname">Международный междисциплинарный энциклопедический словарь «Глобалистика»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/016.jpg" width="170"></div>
                                    <div class="prtname">Универсальная научно-популярная онлайн-энциклопедия «Кругосвет»</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/017.jpg" width="170"></div>
                                    <div class="prtname">Российское философское общество</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/018.jpg" width="170"></div>
                                    <div class="prtname">Российское историческое общество</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/019.jpg" width="170"></div>
                                    <div class="prtname">Российское военно-историческое общество</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/020.jpg" width="170"></div>
                                    <div class="prtname">Российский государственный архив социально-политической литературы (РГАСПИ)</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/021.jpg" width="170"></div>
                                    <div class="prtname">Федеральное архивное агентство (РосАрхив)</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/022.jpg" width="170"></div>
                                    <div class="prtname">Российский государственный архив древних актов РГАДА</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/023.jpg" width="170"></div>
                                    <div class="prtname">Федеральный портал «Российское образование»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/024.jpg" width="170"></div>
                                    <div class="prtname">Государственная Третьяковская галерея</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/025.jpg" width="170"></div>
                                    <div class="prtname">Политехнический музей г. Москвы</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/026.jpg" width="170"></div>
                                    <div class="prtname">Федерация мира и согласия</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/027.jpg" width="170"></div>
                                    <div class="prtname">Российский Пагуошский комитет ученых при Президиуме РАН</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/028.jpg" width="170"></div>
                                    <div class="prtname">Научный журнал «ПОЛИС. Политические исследования»</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/029.jpg" width="170"></div>
                                    <div class="prtname">Научный журнал «Международная жизнь»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/030.jpg" width="170"></div>
                                    <div class="prtname">Научный журнал «Индекс безопасности»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/031.jpg" width="170"></div>
                                    <div class="prtname">Научный журнал «Вестник МГИМО»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/032.jpg" width="170"></div>
                                    <div class="prtname">Портал Российского Совета по международным делам (РСМД)</div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/033.jpg" width="170"></div>
                                    <div class="prtname">Интернет-издание «Российский миротворец»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/034.jpg" width="170"></div>
                                    <div class="prtname">Интернет-издание «Центральная Азия и Кавказ»</div>
                                </div>
                                <div class="prtitem">
                                    <div class="prtlogo"><img alt="" height="96" src="http://рос-мир.рф/sites/default/files/partner-logos/035.jpg" width="170"></div>
                                    <div class="prtname">Интернет-издание «Перспективы»</div>
                                </div>
                            </div>

                    </section>
                </div>
            </div>

        </div>


    </main>
@stop
