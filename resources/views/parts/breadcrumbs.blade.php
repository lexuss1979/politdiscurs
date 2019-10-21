@if(isset($breadcrumbs) )
    <div class="breadcrumbs">
        <ul>
            @foreach($breadcrumbs as $step)
                @if(is_null($step['link']))
                    <li>{{$step['title']}}</li>
                    @else
                    <li><a href="{{$step['link']}}">{{$step['title']}}</a></li>
                @endif

            @endforeach
        </ul>
    </div>
@endif
