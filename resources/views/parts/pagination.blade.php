@if(isset($paging))
<div class="pagination">
    @if($paging['current'] > 1 )
        <a href="{{$paging['links']['prev']}}"><div class="btn-prev"></div></a>
    @else
        <div class="btn-prev disabled"></div>
    @endif
    <div class="current">{{$paging['current']}}</div>
    @if($paging['current'] < $paging['total'] )
        <a href="{{$paging['links']['next']}}"><div class="btn-next"></div></a>
    @else
        <div class="btn-next disabled"></div>
    @endif
    <div class="comment">из {{$paging['total']}}</div>
</div>
@endif
