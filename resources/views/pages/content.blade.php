@extends('parts.page-wrapper')
@section('page-wrapper-class')
    static
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', ['breadcrumbs' => [
            ['link' => 'content/', 'title' => 'Содержание'],

        ]])
        <div class="content-block">
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>Содержание</h1>
                </div>
                <div class="content-block__main-body">
                    <section class="article">
                        @each('parts.topic-hierarchy-item',$topics,'topic')
                        <div class="topic level-0">
                            <div><a href="{{route('docs')}}">Документы</a></div>
                        </div>
                        <div class="topic level-0">
                            <div><a href="{{route('magazines')}}">Журналы</a></div>
                        </div>
                    </section>

                </div>
            </div>

        </div>


    </main>
@stop
