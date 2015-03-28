@extends('layouts.photos')

@section('content')

    <div id="links">
        @foreach($albums as $photoAlbum)

            <div class="col-xs-12 col-md-6 item">
                <div class="timeline-block">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="media">
                                <div class="media-body">
                                    <div class="pull-right text-muted">
                                        @if(!$photoAlbum->shared)
                                            <small class="pull-right"><i class="fa fa-lock fa-2x"></i></small>
                                        @endif
                                    </div>
                                    <h4>{!! $photoAlbum->present()->link( $photoAlbum->name ) !!}</h4>
                                    <small class="text-muted"> {{ $photoAlbum->present()->updated_at }} </small>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>{{ $photoAlbum->description }}</p>

                            @foreach($photoAlbum->photos as $photo)
                                <div class="media md-col-3">
                                    <a class="img-thumbnail">
                                        {!! Html::image($photo->present()->url('image', 'thumb')) !!}
                                    </a>
                                </div>

                            @endforeach

                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>

@endsection