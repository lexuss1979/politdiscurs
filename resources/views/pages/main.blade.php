@extends('parts.page-wrapper')


@section('content')
    <main class="main-page">
        <section class="topics">
            <h2>Международные отношения</h2>
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
                               placeholder="Введите поисковый запрос" value="{{isset($query) ? $query : ''}}">
                        <button class="std-btn" type="submit">Найти</button>
                    </form>
                </div>
            </div>
            <div class="row search-options">
                    <div class="col-12 m-auto">
                        <div class="options-subheader">Введите название документа, фамилию автора, год издания или публикации, название организации или поисковую фразу.</div>
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
                            <div class="carousel-item"  data-url="{{$mag->route()}}"  data-mgid="{{$mag->id}}"><div><img src="{{$mag->imgSrc()}}" onclick="enlarge('.magazines',{{$mag->id}});"><span onclick="goto('.magazines',{{$mag->id}});">{{$mag->name}}</span></div></div>
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
                            <div class="carousel-item"  data-mgid="{{$book->id}}" data-url="{{$book->route()}}">
                                <div>
                                    <img src="{{$book->imgSrc()}}" onclick="enlarge('.books',{{$book->id}});">
                                    <span onclick="goto('.books',{{$book->id}});">{{$book->title}}</span>
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
