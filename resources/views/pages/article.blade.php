@extends('parts.page-wrapper')
@section('page-title'){{$article->title}}@stop
@section('page-description'){{$article->annotation}}@stop

@section('headers')
    <div class="main-topic">{{$article->topic->parent()->title}}</div>
    <h1>{{$article->topic->title}}</h1>
    <h2>Онлайн библиотека книг, статей, докладов, документов</h2>
@stop


@section('page-wrapper-class')
    article-item topic topic-{{$article->topic->parent()->code}}
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => $article->breadcrumbs()])


        <div class="content-block">
            <div class="content-block__sidebar">
                <section class="article-item__img"><img src="{{$article->imgSrc()}}"></section>
                <section>
                    <label class="bold">Авторы:</label>
                    <div class="authors">{{$article->authors_string}}</div>
                </section>
                <section>
                    <label class="bold">@if($article->isBook())Год издания:@elseГод публикации:@endif </label>
                    <div class="year">{{$article->year}}</div>
                </section>
                <section>
                    <label class="bold">Источник:</label>
                    <div class="source"><a target="_blank" href="{{$article->source->link}}">{{$article->source->name}}</a></div>
                </section>
                @if( isset($more) && sizeof($more) >0)
                    <section class="article-item__more">
                        <label class="bold">Смотри также:</label>
                        <ul>
                            @foreach($more as $item)
                                <li><a @if($item->openInNewTab())target="_blank"@endif href="{{$item->route()}}" class="inner-link" data-count="{{$loop->index+1}}">{{$item->title}}</a></li>
                            @endforeach
                        </ul>
                    </section>
                @endif
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
                        <div class="book-link">
                            @if($article->isBook())
                                <p><strong>Читать, заказать или приобрести:</strong>
                                <br><a target="_blank" href="{{$article->externalUrl()}}">{{$article->externalUrl()}}</a>
                                </p>

                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@stop
