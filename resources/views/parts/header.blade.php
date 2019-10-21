<header>
    @if(View::hasSection('headers'))
        @yield('headers')
    @else
        <h1>{{$defaults['h1']}}</h1>
        <h2>{{$defaults['h2']}}</h2>
    @endif
</header>
