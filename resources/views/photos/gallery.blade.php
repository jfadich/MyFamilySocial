@extends('layouts.photos')

@section('pageHeader')
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
@endsection

@section('content')


    <div class="panel panel-default">
        <div class="panel-body">
            {{-- Edit Icons --}}
            @if(UAC::canCurrentUser('EditPhotoAlbum', $album))
                @include('partials.editIcons', ['editUrl' => $album->present()->url('edit')])
            @endif
            <h2>{{ $album->name }}</h2>

            <p class="lead">
                {{ $album->description }}
            </p>

        </div>
        <div class="panel-footer panel-footer-primary">
            <div class="pull-right">
                <small class="text-muted">{{ $album->present()->created_at }}</small>
            </div>
            Created by {!! link_to($album->owner->present()->url, $album->owner->first_name) !!}
            @unless($album->tags->count() == 0)

                {!! $album->present()->tags() !!}

            @endunless
        </div>
    </div>

    <div class="dropzone hide"><span id="previews" class="dropzone-previews"> </span></div>

    <div id="links">
        <?php $photos = $album->photos()->latest()->paginate( 12 ); ?>
        @forelse($photos as $photo)
                <div class="media md-col-3">
                    <div class="cover overlay" style="background: white;">
                        <a href="{{ $photo->present()->url('image', 'large') }}" title="{{ $photo->name }}"
                           class="img-thumbnail img-block-medium" data-gallery>
                            {!! Html::image($photo->present()->url('image', 'medium')) !!}
                        </a>

                        <div class="overlay">
                            <div class="v-top">
                                <a href="{{ $photo->present()->url }}" class="btn btn-cover"><i
                                            class="fa fa-comments"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
        @empty
            <div class="jumbotron text-center bg-transparent margin-none">
                <h1>No photos added yet</h1>

                <p>Drag pictures anywhere to start upload</p>
            </div>

        @endforelse
    </div>
    <div class="text-center">{!! $photos->render() !!}</div>
    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>

                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pageFooter')
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

    @if(isset($album) && UAC::canCurrentUser('UploadPhotoToAlbum', $album))
        <script type="text/javascript">
            Dropzone.autoDiscover = false;
            new Dropzone(document.body, { // Make the whole body a dropzone
                paramName: "photo",
                url: "{{ action('PhotosController@store') }}", // Set the url
                previewsContainer: "#previews", // Define the container to display the previews
                clickable: "#clickable", // Define the element that should be used as click trigger to select files.
                acceptedFiles: 'image/*',
                sending: function (file, xhr, formData) {
                    formData.append("_token", '{{ csrf_token() }}');
                    formData.append("album_id", '{{ $album->id }}');
                },
                init: function () {
                    this.on("addedfile", function (file) {
                        $('.dropzone').removeClass('hide');
                    });
                    this.on("success", function (file, responseText) {
                        var source = $("#photo-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(JSON.parse(responseText));
                        console.log(html);
                        $("#links").prepend(html);
                        this.removeFile(file);
                    });
                }
            });

        </script>

        <script id="photo-template" type="text/x-handlebars-template">
            <div class="media md-col-3">
                <div class="cover overlay" style="background: white;">
                    <a href="@{{ photo.large }}" title="@{{ photo.name }}"
                       class="img-thumbnail img-block-medium" data-gallery>
                        <img src="@{{ photo.medium  }}"/>
                    </a>

                    <div class="overlay">
                        <div class="v-top">
                            <a href="@{{ photo.url }}" class="btn btn-cover"><i
                                        class="fa fa-comments"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    @endif

@endsection