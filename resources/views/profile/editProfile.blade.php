@extends('layouts.master')

@section('content')
    <div class="media media-grid media-clearfix-xs">
        <div class="media-left">
            <div class="width-250 width-auto-xs">
                <div class="panel panel-primary widget-user-1 text-center">
                    <div class="avatar">
                        <img src="{{ URL::to('images/thumb/'.$user->profile_picture) }}" alt="" class="img-circle">

                        <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                    </div>
                    <div class="profile-icons margin-none" style="background: #F4F9F9">
                        <span><i class="fa fa-comment"></i> {{ $user->comments()->count() }}</span>
                        <span><i class="fa fa-photo"></i> 43</span>
                        <span><i class="fa fa-video-camera"></i> 3</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="media-body">
            <div class="panel panel-default">
                <div class="panel-heading panel-heading-gray">
                    <i class="fa fa-bookmark"></i> Edit Profile
                </div>
                <div class="panel-body">
                    @include('profile._profileForm')
                </div>
            </div>
        </div>
    </div>
@stop