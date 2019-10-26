<div class="item" data-id="{{$article->id}}">
    <div class="item__img">
        <a @if($article->formatCode() == 'pdf' || $article->formatCode() == 'link')target="_blank"@endif href="{{$article->route()}}"><img src="{{$article->imgSrc()}}" alt="{{$article->title}}"><span class="letter style-@php echo RAND(1,8) @endphp"><span>{{$article->letter()}}</span></span></a>
    </div>
    <div class="item__text"><a @if($article->formatCode() == 'pdf' || $article->formatCode() == 'link')target="_blank"@endif href="{{$article->route()}}" class="item__header">{{$article->title}}</a>
        <div class="article-topics">
            @foreach($article->topic->path() as $topic)
                @if($loop->index == 0)
                    <span class="root">{{$topic['title']}}</span>
                @else
                    <a href="{{$topic['route']}}">{{$topic['title']}}</a>
                @endif
            @endforeach
           </div>
        <div class="author">@php if(strpos($article->authors_string, ',')){echo 'Авторы'; } else {echo 'Автор'; }@endphp: {{$article->authors_string}}</div>
        <div class="year">Год издания: {{$article->year}}</div>
        <p class="item__desc">{{$article->annotation}}</p>
        <div class="item-type type-{{$article->formatCode()}}"></div>
    </div>
</div>
