@extends('parts.page-wrapper')

@section('headers')
    <div class="main-topic">{{$topic->parent()->title}}</div>
    <h1>{{$topic->title}}</h1>
    <h2>Онлайн библиотека книг, статей, докладов, документов</h2>
@stop

@section('page-wrapper-class')
    topic topic-{{$topic->code}}
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['paging' => $data['paging'] , 'breadcrumbs' => [
            ['link' => '/', 'title' => 'Главная'],
            ['link' => null, 'title' => $topic->parent()->title],
            ['link' => 'topics/'.$topic->id, 'title' => $topic->title],

        ]])


        <div class="content-block">
            <div class="content-block__sidebar">
                @include('parts.search-block')
                @include('parts.topic-filter')
            </div>
            <div class="content-block__main">
                <div class="content-block__main-body">
                    <div class="items-list {{ config('content.show-letter-placeholder') ?  'letters' : ''}}">
                        @each('parts.article-list-item', $data['content'], 'article')
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
