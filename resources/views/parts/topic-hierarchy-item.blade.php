<div class="topic level-{{$topic->level}}">
    <a href="{{$topic->route()}}">{{$topic->title}}</a>
    @each('parts.topic-hierarchy-item',$topic->children,'topic')
</div>
