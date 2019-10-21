@extends('parts.page-wrapper')

@section('page-wrapper-class')
    search-results
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => '/', 'title' => 'Главная'],
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
                        @empty($results)
                            <p class="nothing-found">По вашему запросу "{{$query}}" ничего не найдено</p>
                        @endempty
                        @each('parts.article-list-item', $results, 'article')
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop