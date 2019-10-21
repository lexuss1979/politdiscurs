@extends('layouts.main')

@section('page-wrapper')
    <div class="main-wrapper @yield("page-wrapper-class",'')" id="app">
        <div class="bg-wrapper-overlay"></div>
        <div class="page-wrapper">
        @include('parts.header')
        <main>
            @yield('content')
        </main>
        @include('parts.footer')
        </div>

    </div>
@endsection
