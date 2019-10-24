@extends('parts.page-wrapper')


@section('content')
<main class="content-page">
    @include('parts.main-menu')
    @include('parts.sub-nav-line', ['breadcrumbs' => [
        ['link' => 'about/', 'title' => 'О проекте'],

    ]])
    <div class="content-block">
        <div class="content-block__main">
            <div class="content-block__main-header">
                <h1>О проекте</h1>
            </div>
            <div class="content-block__main-body">
                <section class="article">
                    <p style="text-align: justify;"><span style="line-height: 1.5;">Образовательный ресурс «Российская цивилизация в пространстве, времени и мировом контексте» создан большим коллективом авторов, консультантов, составителей, редакторов под руководством Центра политических и международных исследований и Российской ассоциации политической науки.</span></p>
                    <p style="text-align: justify;">Ресурс является междисциплинарным и содержит сведения, статьи, материалы и иллюстрации по таким областям знания, как теория цивилизаций, российская история, государственное и общественное устройство России, географическая и социально-экономическая информация о России, российская культура, положение и политика России в международной системе.</p>
                    <p style="text-align: justify;">При реализации проекта использовались средства государственной поддержки, выделенные в качестве гранта в соответствии c распоряжением Президента Российской Федерации от 17.01.2014 № 11-рп и на основании конкурса, проведенного Обществом «Знание» России</p>
                    <p style="text-align: justify;">Для работы над проектом был создан представительный Научно-редакционный Совет из экспертов и ученых разных специальностей, а также группа редакторов-составителей (их состав приведен в разделе «Авторы»). Была проведена большая работа по научному взаимодействию с архивами, музеями, энциклопедиями и энциклопедическими он-лайн изданиями, научными журналами, институтами системы Российской Академии наук. Специально для данного проекта были созданы сотни новых информационно-аналитических материалов. Были также согласованы с правообладателями разрешения на использование и воспроизведение ранее созданных информационно-аналитических материалов. Уникальной является электронная оболочка образовательного ресурса, для которой художники создали многочисленные коллажи и изображения, составившие образный фон «российской цивилизации». Ресурс включил в себя также художественные и фото- иллюстрации, географические и политические карты, схемы, аудиофайлы, видеолекции.</p>
                    <p style="text-align: justify;"><strong>Интерактивная карта России</strong> «оживает» по мере прокрутки расположенной под ее изображением символической Ленты времени и показывает, как росли и прирастали российские земли, как менялись в разные исторические эпохи границы России.</p>
                    <p style="text-align: justify;"><strong>Лента времени</strong> охватывает лишь несколько десятков основных событий многовековой российской истории, составляющие ее изображения и фотографии можно увеличить, рассмотреть в деталях, прочитать связанные с событиями исторические статьи. Однако гораздо более полную картину исторического развития российской цивилизации дают многие сотни статей разделов «История», «География», «Культура», «Россия в мире» и др.</p>
                    <p style="text-align: justify;"><strong>Медиатека</strong> содержит около тысячи иллюстративных и справочных материалов - политические и географические карты, иллюстрации, фотографии, статистику и графики, видеолекции, музыкальные аудиофайлы, а также списки научной и учебной литературы и Интернет-источников к каждому разделу, для того, чтобы читатели могли продолжить ознакомление с информацией по заинтересовавшим их темам.</p>
                    <p style="text-align: justify;">Образовательный ресурс «Российская цивилизация…» имеет научно-образовательный характер и создан для использования преподавателями, студентами, магистрантами, аспирантами, исследователями, всеми, кто интересуется комплексными знаниями о нашей стране и обществе.</p>
                    <h2 style="text-align: justify;">Общий замысел проекта</h2>
                    <p style="text-align: justify;">Вступив в XXI в., человечество все больше задумывается над перспективами развития общества, культуры и цивилизации. XX век показал невиданное ранее ускорение темпов общественного развития, а изменения, которые в прежние времена занимали столетия, стали происходить на протяжении жизни всего одного поколения. Поиск адекватных ответов на вызовы XXI века становится одной из главных задач для политиков, ученых и экспертов, общественных деятелей и представителей гражданского общества. Роль России как одной из ведущих мировых держав в этом процессе весьма велика. Осознание своих культурно-цивилизационных и исторических особенностей, понимание своей роли и места в стремительно меняющемся мире и выбор дальнейших путей развития для нашей страны сегодня становится особенно актуальными.</p>
                    <p style="text-align: justify;">Вопросы «Существует ли российская цивилизация?», «В чем специфика российской цивилизации?», «Восток или Запад преобладает в ней?», «В каком направлении должно идти развитие России и есть ли у нее свой особый путь?», «Какова роль России в мировой политике и сфера ее глобальной ответственности?», наконец, «Какой вклад Россия вносит и может внести в решение глобальных проблем XXI века?» &nbsp;активно обсуждаются в статьях и материалах данного образовательного ресурса.&nbsp;</p>
                    <p style="text-align: justify;">Российская цивилизация принадлежит к числу древнейших цивилизаций в мире, которая прошла ряд этапов в своем развитии, претерпев несколько модернизаций со своими особенностями и разной степенью завершенности. Концепций, описывающих российскую цивилизацию много. В одних концепциях Россия представляется как часть европейской цивилизации, в других - как самобытная евразийская цивилизация, согласно третьим Россия вообще не является самостоятельной цивилизацией, а представляет собой составное цивилизационно неоднородное общество. Наконец, российская цивилизация представляется как вобравшая в себя элементы множества других цивилизаций, &nbsp;уникальный сплав, несводимый ни к одному из своих компонентов.&nbsp;</p>
                    <p style="text-align: justify;">Действительно, Россия является уникальной страной, чье географическое положение и особенности исторического развития предопределяют цивилизационную многокомпонентность, которую вряд ли можно найти в какой-либо другой стране. Расположенная между двумя мощными центрами цивилизационного влияния — Востоком и Западом, Россия включает в свой состав огромное этническое, религиозное и культурное многообразие народов. На протяжении многих веков формирование и становление российской цивилизации было связано с &nbsp;определенной духовно-ценностной религиозной формой, влиянием православия. В то же время, в XX в. российская цивилизация прогрессировала и в безрелигиозной, атеистической форме. При этом, на протяжении многих веков Россия всегда являлась и продолжает оставаться одним из ведущих центров развития науки и культуры, подарив миру выдающихся ученых, художников, композиторов, писателей.&nbsp;</p>
                    <p style="text-align: justify;">От древних времен до современности Россия пережила немало конфликтов и войн, она объединяла земли и народы. В ХХ веке в России происходили революционные смены государственного устройства и идеологии, которые непосредственно затрагивали и оказывали влияние на развитие многих других государств в различных регионах мира. Прекращение существования Российской империи, распад СССР и формирование современного российского государства – Российской Федерации в течение всего одного столетия ставит непростые задачи восстановления внутренних связей, внутреннего стержня, объединяющего все исторические формы проявления российской цивилизации – от Древней Руси до современной России.</p>
                    <p style="text-align: justify;">Проект «Российская цивилизация в пространстве, времени и мировом контексте» представляет собой попытку синтеза всех сторон и аспектов развития российской цивилизации, российского государства и российского общества в единой социо-культурной, политологической и исторической перспективе в общемировом контексте.</p>
                    <h2 style="text-align: justify;">Контакты:&nbsp;</h2>
                    <p style="text-align: justify;">Электронная почта проекта - centercpis@gmail.сом</p>
                </section>
            </div>
        </div>

    </div>


</main>
@stop
