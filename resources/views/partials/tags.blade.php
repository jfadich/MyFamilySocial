@foreach($tags as $tag)
    <a href="{{ $tag->present()->url }}" class="label label-grey-100">
        <i class="fa fa-tag"></i>&nbsp;{{ $tag->name }}
    </a>
@endforeach