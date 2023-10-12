<?php 
    $start  = $rows->firstItem();
    $end    = $rows->lastItem();

    $currPage = $rows->currentPage();
    $prevPage = $currPage - 1;
    $nextPage = $currPage + 1;
    $lastPage = $rows->lastPage();

    if ($prevPage < 1) {
        $prevPage = 1;
    }

    if ($nextPage > $lastPage) {
        $nextPage = $lastPage;
    }
?>

<div class="btn-group">
    <a class="btn btn-secondary btn-sm" href="{{ url()->current().'?page=1' }}" title="First Page"><span class="fa fa-angle-double-left"></span></a>
    <a class="btn btn-secondary btn-sm" href="{{ url()->current().'?page='.$prevPage }}" title="Previous Page"><span class="fa fa-angle-left"></span></a>
    <select class="btn btn-secondary btn-sm">
      @for($i = 1; $i <= $lastPage; $i++)
        <option value="{!! url()->current().'?page='.$i !!}"{!! ($i == $currPage ? ' selected="selected"' : '') !!}>Page {{ $i }} of {{ $lastPage }}</option>
      @endfor
    </select>
    <a class="btn btn-secondary btn-sm" href="{{ url()->current().'?page='.$nextPage }}" title="Next Page"><span class="fa fa-angle-right"></span></a>
    <a class="btn btn-secondary btn-sm" href="{{ url()->current().'?page='.$lastPage }}" title="Last Page"><span class="fa fa-angle-double-right"></span></a>
    <div class="btn btn-secondary btn-sm">{{ $rows->total() }} item{{ ($rows->total() > 1 ? 's' : '') }} found.</div>
  </div>