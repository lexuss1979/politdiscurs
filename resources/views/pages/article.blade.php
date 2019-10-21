@extends('parts.page-wrapper')

@section('headers')
    <div class="main-topic">{{$article->topic->parent()->title}}</div>
    <h1>{{$article->topic->title}}</h1>
    <h2>Онлайн библиотека книг, статей, докладов, документов</h2>
@stop


@section('page-wrapper-class')
    article-item topic-{{$article->topic->code}}
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => '/', 'title' => 'Главная'],
            ['link' => null, 'title' => $article->topic->parent()->title],
            ['link' => 'topics/'.$article->topic->id, 'title' => $article->topic->title],
            ['link' => 'articles/'.$article->id, 'title' => $article->title],

        ]])


        <div class="content-block">
            <div class="content-block__sidebar">
                <section class="article-item__img"><img src="{{$article->imgSrc()}}"></section>
                <section>
                    <label>Авторы:</label>
                    <div class="authors">{{$article->authors_string}}</div>
                </section>
                <section>
                    <label>Год издания:</label>
                    <div class="year">{{$article->year}}</div>
                </section>
            </div>
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>{{$article->title}}</h1>
                </div>
                <div class="content-block__main-body">
                    <section class="article">
                        <div>
                            {!! $article->html !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@stop
