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
                    <form action="/search" method="get">
                        <input type="text" id="search-input" name="q"
                               placeholder="Введите название книги, документа или автора" value="{{isset($query) ? $query : ''}}">
                        <button class="std-btn" type="submit">Найти</button>
                    </form>
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
        <!--section class="media-examples magazines">
            <h2>Журналы</h2>
            <img src="../img/layout/temp/carousel1.jpg">
            <button class="std-btn">Посмотреть все ({{$magazinesCount}})</button>
        </section-->
        <section class="media-examples magazines">
            <h2>Журналы</h2>
            <div class="carousel-wrapper">
                <div class="left-btn"></div>
                <div class="carousel-container">
                    <div class="carousel">
                        @foreach($magazines as $mag)
                            <div class="carousel-item" onclick="enlarge('.magazines',{{$mag->id}});" data-mgid="{{$mag->id}}" data-url="{{$mag->route()}}"><div><img src="{{$mag->imgSrc()}}"><span>{{$mag->name}}</span></div></div>
                        @endforeach
                    </div>
                </div>
                <div class="right-btn"></div>
            </div>

            <button class="std-btn" onclick="window.location.href='{{route('magazines')}}'">Посмотреть все ({{$magazinesCount}})</button>
        </section>
        <section class="media-examples books">
            <h2>Книги</h2>
            <div class="carousel-wrapper">
                <div class="left-btn"></div>
                <div class="carousel-container">
                    <div class="carousel">
                        @foreach($books as $book)
                            <div class="carousel-item" onclick="enlarge('.books',{{$book->id}});" data-mgid="{{$book->id}}" data-url="{{$book->route()}}">
                                <div>
                                    <img src="{{$book->imgSrc()}}">
                                    <span>{{$book->title}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="right-btn"></div>
            </div>
            <button class="std-btn"  onclick="window.location.href='{{route('books')}}'">Посмотреть все ({{$booksCount}})</button>
        </section>
    </main>
@endsection
