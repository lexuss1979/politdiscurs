@extends('parts.page-wrapper')

@section('page-wrapper-class')
    magazines
@stop

@section('content')
    <main class="content-page">
        @include('parts.main-menu')
        @include('parts.sub-nav-line', [ 'breadcrumbs' => [
            ['link' => '/', 'title' => 'Главная'],
            ['link' => 'magazines/', 'title' => 'Журналы']
        ]])

        <div class="content-block">
            <div class="content-block__main">
                <div class="content-block__main-header">
                    <h1>Журналы</h1>
                </div>
                <div class="content-block__main-body">
                    <div class="tile-list">
                        <div class="row">
                            @foreach($magazines as $item)
                                <div class="col-3">
                                    <div class="tile">
                                        <a href="{{$item->route()}}"><img src="{{$item->imgSrc()}}" alt=""><span>{{$item->name}}</span></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
