@extends('layouts.master')

@section('content')
    <div class="media media-grid media-clearfix-xs">
        <div class="media-left">
            <div class="width-250 width-auto-xs">
                <div class="panel panel-primary widget-user-1 text-center">
                    <div class="avatar">
                        <img src="{{ URL::to('images/thumb/' . $user->profile_picture ) }}" alt="" class="img-circle">
                        <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                    </div>
                    <div class="profile-icons margin-none" style="background: #F4F9F9">
                        <span><i class="fa fa-comment"></i> {{ $user->comments()->count() }}</span>
                        <span><i class="fa fa-photo"></i> 43</span>
                        <span><i class="fa fa-video-camera"></i> 3</span>
                    </div>
                </div>
                <!-- Contact -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Contact
                    </div>
                    <ul class="icon-list icon-list-block">

                        <li><i class="fa fa-envelope fa-fw"></i> <a href="#">{{ $user->email }}</a></li>

                        @unless(empty($user->phone_one))
                            <li><i class="fa fa-phone fa-fw"></i> <a href="#">{{ $user->phone_one }}</a></li>
                        @endif

                        @unless(empty($user->phone_two))
                            <li><i class="fa fa-phone fa-fw"></i> <a href="#">{{ $user->phone_two }}</a></li>
                        @endif

                                @unless(is_null($user->birthdate))
                                    <li><i class="fa fa-birthday-cake"></i> <a href="#">{{ $user->birthday }}</a></li>
                                    @endif

                    </ul>
                </div>

                {{--
                |--------------------------------------------------------------------------
                | Address
                |--------------------------------------------------------------------------
                --}}
                @unless(empty($user->address) || empty($user->city) || empty($user->state) || empty($user->zip_code))

                        @include('profile._addressPanel')

                @endunless
            </div>
        </div>
        <div class="media-body">

            @unless($user->id === Auth::id())
            <div class="panel panel-default share">
                <div class="input-group">
                    <input type="text" class="form-control share-text" placeholder="Write message...">
                    <div class="input-group-btn">
                        <a class="btn btn-primary" href="#"><i class="fa fa-envelope"></i> Send Private Message</a>
                    </div>

                </div>
            </div>
            @endunless

            {{--
            |--------------------------------------------------------------------------
            | Comments
            |--------------------------------------------------------------------------
            --}}
            @unless($user->comments()->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        @include('profile._recentCommentsPanel')
                    </div>
                </div>
            @endunless

            </div>
        </div>
    </div>
@stop