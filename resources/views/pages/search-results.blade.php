@extends('parts.page-wrapper')

@section('page-wrapper-class')
    search-results
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => null, 'title' => 'Результаты поиска']
        ]])

        <div class="content-block">
            <div class="content-block__main">
                <section class="search-panel settingless">
                    <div class="row">
                        <div class="col-12 text-center">
                            <form action="/search" method="get">
                                <input type="text" id="search-input" name="q"
                                       placeholder="Введите название книги, документа или автора" value="{{isset($query) ? $query : ''}}">
                                <button class="std-btn" type="submit">Найти</button>
                            </form>
                        </div>
                    </div>

                </section>
                <div class="content-block__main-body">
                    <div class="items-list {{ config('content.show-letter-placeholder') ?  'letters' : ''}}">
                        @if( count($results) == 0)
                            <p class="nothing-found">По вашему запросу "{{$query}}" ничего не найдено</p>
                        @else
                            @each('parts.article-list-item', $results, 'article')
                        @endif
                    </div>
                </div>
                @include('parts.sub-nav-line', ['class' => 'bottom' ])
            </div>
        </div>
    </main>
@stop
