@extends('layouts.photos')

@section('content')

    <div id="links">
        @foreach($albums as $photoAlbum)

            <div class="col-xs-12 col-md-6 item">
                <div class="timeline-block">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="media">
                                <div class="media-body">
                                    <div class="pull-right text-muted">
                                        @if(!$photoAlbum->shared)
                                            <small class="pull-right" title="View only"><i class="fa fa-lock fa-2x"></i>
                                            </small>
                                        @endif
                                    </div>
                                    <h4>{!! $photoAlbum->present()->link( $photoAlbum->name ) !!}</h4>
                                    <small class="text-muted"> {{ $photoAlbum->present()->updated_at }} </small>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>{{ $photoAlbum->description }}</p>


                            @for ($i = 0; $i < min(12, count($photoAlbum->photos)); $i++)
                                <div class="media md-col-3">
                                    <a class="img-thumbnail img-block-thumb">
                                        {!! Html::image($photoAlbum->photos[$i]->present()->url('image', 'thumb')) !!}
                                    </a>
                                </div>
                            @endfor


                        </div>

                    </div>
                </div>
            </div>

        @endforeach
        <div class="text-center">
            {!! $albums->render() !!}
        </div>
    </div>

@endsection