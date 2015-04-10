<div class="pull-right">
    <a href="{{ URL::to($editUrl) }}" class="btn btn-stroke btn-default btn-xs"><i class="fa fa-pencil"></i></a>
    @if(isset($deleteUrl))
        <a href="{{ URL::to($deleteUrl) }}" class="btn btn-stroke btn-danger btn-xs"><i class="fa fa-close"></i></a>
    @endif

</div>