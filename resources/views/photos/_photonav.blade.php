@section('page_nav')

    <ul class="nav navbar-nav">

        @if(UAC::canCurrentUser('CreatePhotoAlbum'))
            <li>
                <a href="#">
                    <i class="fa fa-plus"></i> Create Album
                </a>
            </li>
        @endif

        @if(isset($album) && UAC::canCurrentUser('UploadPhotoToAlbum', $album))
            <li>
                <a href="#" id="clickable">
                    <i class="fa fa-plus"></i> Add Photo
                </a>
            </li>
            @endif
                    <!-- // END messages -->
    </ul>

@stop


