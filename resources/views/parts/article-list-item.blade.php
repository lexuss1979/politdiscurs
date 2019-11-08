<div class="item @if($article->img == null) no-cover @endif" data-id="{{$article->id}}">
    <div class="item__img">
        <a @if($article->openInNewTab())target="_blank"@endif href="{{$article->route()}}"><img src="{{$article->imgSrc()}}" alt="{{$article->title}}"><span class="letter style-@php echo RAND(1,8) @endphp"><span>{{$article->letter()}}</span></span></a>
    </div>
    <div class="item__text"><a @if($article->openInNewTab())target="_blank"@endif href="{{$article->route()}}" class="item__header">{{$article->title}}</a>
        <div class="article-topics">
            @foreach($article->topic->path() as $topic)
                @if($loop->index == 0)
                    <span class="root">{{$topic['title']}}</span>
                @else
                    <a href="{{$topic['route']}}">{{$topic['title']}}</a>
                @endif
            @endforeach
           </div>
        <div class="author">
            @if($article->authors_string == '')
                Группа авторов
                @else
                    @if(strpos($article->authors_string, ','))Авторы:
                    @elseАвтор:
                    @endif {{$article->authors_string}}
            @endif</div>

        <div class="year">@if($article->isBook())Год издания:@elseГод публикации:@endif {{$article->year}}</div>
        <p class="item__desc">{{$article->annotation}}</p>
        <div class="item-type type-{{$article->formatCode()}}"></div>
    </div>
</div>
