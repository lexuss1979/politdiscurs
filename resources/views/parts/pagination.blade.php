@if(isset($paging))
<div class="pagination">
    @if($paging['current'] > 1 )
        <a href="{{$paging['links']['prev']}}"><div class="btn-prev"></div></a>
    @else
        <div class="btn-prev disabled"></div>
    @endif
    <div class="current"><input type="text" value="{{$paging['current']}}" data-route="{{$paging['links']['current']}}" data-current="{{$paging['current']}}" data-total="{{$paging['total']}}" ></div>
    @if($paging['current'] < $paging['total'] )
        <a href="{{$paging['links']['next']}}"><div class="btn-next"></div></a>
    @else
        <div class="btn-next disabled"></div>
    @endif
    <div class="comment">из {{$paging['total']}}</div>
</div>
@endif
