<div class="item">
    <div class="item__img">
        <a @if(!is_null($article->file))target="_blank"@endif href="{{$article->route()}}"><img src="{{$article->imgSrc()}}" alt="{{$article->title}}"><span class="letter style-@php echo RAND(1,8) @endphp"><span>{{$article->letter()}}</span></span></a>
    </div>
    <div class="item__text"><a @if(!is_null($article->file))target="_blank"@endif href="{{$article->route()}}" class="item__header">{{$article->title}}</a>
        <div class="author_year">{{$article->authors_string}} Год издания: {{$article->year}}</div>
        <p class="item__desc">{{$article->annotation}}</p>
    </div>
</div>
