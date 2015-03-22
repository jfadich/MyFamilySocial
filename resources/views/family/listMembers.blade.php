@extends('layouts.master')

@section('content')
    <h1>Family Members</h1>

    <div class="row">
        @foreach($users as $user)
            <div class="col-md-6 col-lg-4 item">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div class="pull-left">
                                {!! $user->present()->profile_picture('small', ['class' => 'media-object img-circle'])
                                !!}
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading margin-v-5"><a
                                            href="{{ url('profile/'.$user->id) }}">{{ $user->present()->full_name }}</a>
                                </h4>
                                <div class="profile-icons">
                                    <span><i class="fa fa-comments"></i>{{ $user->comments()->count() }}</span>
                                    <span><i class="fa fa-photo"></i> 43</span>
                                    <span><i class="fa fa-video-camera"></i> 3</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop