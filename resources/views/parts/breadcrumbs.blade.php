@if(isset($breadcrumbs) )
    <div class="breadcrumbs">
        <ul>
            <li><a href="/">Главная</a></li>
            @foreach($breadcrumbs as $step)
                @if(is_null($step['link']) || $loop->last)
                    <li>{!! $step['title'] !!}</li>
                    @else
                    <li><a href="{{$step['link']}}">{!! $step['title'] !!}</a></li>
                @endif

            @endforeach
        </ul>
    </div>
@endif
