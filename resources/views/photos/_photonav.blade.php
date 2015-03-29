@section('page_nav')

    <ul class="nav navbar-nav">

        @if(UAC::canCurrentUser('CreatePhotoAlbum'))
            <li>
                <a href="{{ action('AlbumsController@create') }}">
                    <i class="fa fa-plus"></i> Create Album
                </a>
            </li>
        @endif
            @if(isset($album) && (strpos(Route::current()->getActionName(), 'AlbumsController@edit') === false) &&  UAC::canCurrentUser('UploadPhotoToAlbum', $album))
            <li>
                <a href="#" id="clickable">
                    <i class="fa fa-plus"></i> Add Photo
                </a>
            </li>

            @endif

    </ul>

@stop

@section('page_nav_small')
    @if(isset($album) && (strpos(Route::current()->getActionName(), 'AlbumsController@edit') === false) &&  UAC::canCurrentUser('UploadPhotoToAlbum', $album))
        <a href="#" id="clickable" class="toggle pull-right visible-xs "><i class="fa fa-picture-o"></i></a>
    @endif
@endsection


