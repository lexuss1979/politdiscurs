@extends('parts.page-wrapper')

@section('page-wrapper-class')
    docs
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['paging' => $data['paging'],
        'breadcrumbs' => [
            ['link' => null, 'title' => 'Документы']
        ]])

        <div class="content-block">
            <div class="content-block__main">
                <div class="content-block__main-body">
                    <div class="items-list {{ config('content.show-letter-placeholder') ?  'letters' : ''}}">
                        @if( count($data) == 0)
                            <p class="nothing-found">По вашему запросу "{{$query}}" ничего не найдено</p>
                        @else
                            @each('parts.article-list-item', $data['content'], 'article')
                        @endif
                    </div>
                </div>
                @include('parts.sub-nav-line', ['paging' => $data['paging'], 'class' => 'bottom' ])
            </div>
        </div>
    </main>
@stop
