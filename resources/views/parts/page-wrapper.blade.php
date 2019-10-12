@extends('layouts.main')

@section('page-wrapper')
    <div class="page-wrapper @if(isset($bgcolor)) {{$bgcolor}} @endif" >
        @include('parts.header')
        <main>
            @yield('content')
        </main>
        @include('parts.footer')
    </div>
@endsection
