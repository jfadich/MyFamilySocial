
@section('page_nav')
<ul class="nav navbar-nav">
    <!-- User -->
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Categories <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
           @foreach($categories as $category)
               <li><a href="{{ URL::to('forum/'. $category->slug) }}">{{ $category->name }}</a> </li>
            @endforeach
        </ul>
    </li>
    <li><a href="{{ URL::to('forum/start-discussion') }}"><span class=""><i class="icon-add-symbol"></i></span> Add Post</a></li>
</ul>
@stop