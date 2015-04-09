
@section('page_nav')
    <ul class="nav navbar-nav">
        <!-- User -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                Categories <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
               @foreach($categories as $category)
                    <li>{!! $category->present()->link( $category->name ) !!}</a> </li>
                @endforeach
            </ul>
        </li>
        @if(UAC::canCurrentUser('CreateForumThread'))
            <li>
                <a href="{{ URL::to('forum/topic/create') }}@if(isset($heading)){{'?category='. $heading->id }} @endif "><span
                            class=""><i class="fa fa-plus"></i></span> Create
                    Topic</a></li>
        @endif
    </ul>
@stop

