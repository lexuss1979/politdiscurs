@extends('parts.page-wrapper')

@section('page-wrapper-class')
    magazine-item
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => route('magazines'), 'title' => 'Журналы'],
            ['link' => route('magazine-item',['magazine' => $magazine->id]), 'title' => $magazine->name],

        ]])


        <div class="content-block">
            <div class="content-block__sidebar">
                @include('parts.search-block')
                <section class="magazine-item__img">
                    <img title="{{$magazine->name}}" src="{{$magazine->imgSrc()}}" alt="">
                </section>
                <section  class="magazine-item__link">
                    <label class="bold">Сайт журнала:</label>
                    <a href="{{$magazine->link}}" class="external-link">{{$magazine->link}}</a>
                </section>
                @if( isset($more) && sizeof($more) >0)
                <section class="magazine-item__more">
                    <label class="bold">Журналы:</label>
                    <ul>
                        @foreach($more as $item)
                            <li><a href="{{$item->route()}}" class="inner-link" data-count="{{$loop->index+1}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </section>
                @endif
            </div>
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>{{$magazine->name}}</h1>
                </div>
                <div class="content-block__main-body">
                    <section class="article">
                        <div>
                            {!! $magazine->description !!}
                        </div>
                        @if(count($magazine->articles) > 0)
                            <div class="linked-articles">
                                <h2>Избранные статьи</h2>
                                <foldable>
                                    <ul>
                                        @foreach($magazine->articles as $article)
                                            <li><a href="{{$article->route()}}">{{$article->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </foldable>

                            </div>
                        @endif

                    </section>
                </div>
            </div>
        </div>
    </main>
@stop
