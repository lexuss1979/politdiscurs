@extends('parts.page-wrapper')


@section('content')
    <main class="main-page">
        <section class="topics">
            <h2>Междунарожные отношения</h2>
            <div class="section-cards clearfix">
                @foreach($outerTopics as $topic)
                    <div class="tile topic-{{$topic->code}}">
                        <a href="topics/{{$topic->id}}"><span class="box"><span>{{$topic->title}}</span></span></a>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="topics">
            <h2>ВНУТРЕННЯЯ ПОЛИТИКА РОССИИ</h2>
            <div class="  section-cards clearfix">
                @foreach($innerTopics as $topic)
                    <div class="tile topic-{{$topic->code}}">
                        <a href="topics/{{$topic->id}}"><span class="box"><span>{{$topic->title}}</span></span></a>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="search-panel">
            <div class="row">
                <div class="col-12 text-center">
                    <input type="text" id="search-input" placeholder="Введите название книги, документа или автора">
                    <button class="std-btn">Найти</button>
                </div>
            </div>
            <div class="row search-options">
                <div class="col-5 row">
                    <div class="col-6"><input name="search-type"  type="radio"><label for="">Поиск по регионам</label></div>
                    <div class="col-6"><input name="search-type" type="radio"><label for="">По организациям</label></div>
                    <div class="col-6"><input name="search-type" type="radio"><label for="">По регионам</label></div>
                    <div class="col-6"><input name="search-type" type="radio"><label for="">По году публикации</label></div>
                </div>
                <div class="col-7">
                    <div class="options-subheader text-center">Искать по типу контента</div>
                    <div class="options-group row">
                        <div class="option col-3"><input name="books" type="checkbox"><label for="">Книги</label></div>
                        <div class="option col-3"><input name="docs" type="checkbox"><label for="">Документы</label></div>
                        <div class="option col-3"><input name="articles" type="checkbox"><label for="">Статьи</label></div>
                        <div class="option col-3"><input name="magazines" type="checkbox"><label for="">Журналы</label></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="close-btn">Закрыть настройки поиска</div>
                </div>
            </div>

        </section>
        <section class="media-examples magazines">
            <h2>Журналы</h2>
            <img src="../img/layout/temp/carousel1.jpg">
            <button class="std-btn">Посмотреть все (16)</button>
        </section>
        <section class="media-examples books">
            <h2>Книги</h2>
            <img src="../img/layout/temp/carousel2.jpg">
            <button class="std-btn">Посмотреть все (156)</button>
        </section>
    </main>
@endsection
