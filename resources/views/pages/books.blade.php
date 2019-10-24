@extends('parts.page-wrapper')


@section('page-wrapper-class')
  books
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['paging' => $data['paging'] , 'breadcrumbs' => [
            ['link' => 'books', 'title' => 'Книги'],

        ]])


        <div class="content-block">
            <div class="content-block__sidebar">
                @include('parts.search-block')
                @include('parts.book-filter')
            </div>
            <div class="content-block__main">
                <div class="content-block__main-body">
                    <div class="items-list {{ config('content.show-letter-placeholder') ?  'letters' : ''}}">
                        @each('parts.article-list-item', $data['content'], 'article')
                    </div>
                </div>
                @include('parts.sub-nav-line', ['paging' => $data['paging'],'class' => 'bottom' ])
            </div>
        </div>

    </main>
@stop
