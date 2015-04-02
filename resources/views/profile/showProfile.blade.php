@extends('layouts.master')

@section('content')
    <div class="media media-grid media-clearfix-xs">
        <div class="media-left">
            <div class="width-250 width-auto-xs">
                <div class="panel panel-primary widget-user-1 text-center">
                    <div class="avatar">

                        {!! $user->present()->profile_picture('thumb', ['class' => 'img-circle']) !!}
                        <h3>{{ $user->present()->full_name }}</h3>

                        @if(UAC::canCurrentUser('EditProfileInfo', $user))
                            <a href="{{ url("profile/{$user->id}/edit") }}" class="btn btn-primary btn-stroke">Edit
                                Profile <i class="md-edit"></i></a>
                        @endif

                    </div>
                    <div class="profile-icons margin-none" style="background: #F4F9F9">
                        <span><i class="fa fa-comment"></i> {{ $user->comments()->count() }}</span>
                        <span><i class="fa fa-photo"></i> {{ $user->photos()->count() }}</span>
                        <span><i class="fa fa-video-camera"></i> 3</span>
                    </div>
                </div>
                <!-- Contact -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Contact
                    </div>
                    <ul class="icon-list icon-list-block">

                        <li><i class="fa fa-envelope fa-fw"></i> <a
                                    href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>

                        @unless(empty($user->phone_one))
                            <li><i class="fa fa-phone fa-fw"></i> {{ $user->phone_one }}</li>
                        @endif

                        @unless(empty($user->phone_two))
                                <li><i class="fa fa-phone fa-fw"></i> {{ $user->phone_two }}</li>
                        @endif

                                @unless(is_null($user->birthdate))
                                    <li><i class="fa fa-birthday-cake"></i> {{ $user->present()->birthday }}</li>
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

                <div class="tabbable">
                    <ul class="nav nav-tabs" tabindex="0" style="overflow: hidden; outline: none;">
                        <li class="active"><a href="#photos" data-toggle="tab" aria-expanded="true"><i
                                        class="fa fa-fw fa-picture-o"></i> Profile Photos</a>
                        </li>
                        @unless($user->albums->count() == 0)
                        <li class=""><a href="#albums" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-fw fa-folder"></i> Albums</a>
                        </li>
                        @endunless
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="photos">
                            @foreach($user->profile_pictures()->latest()->take(10)->get() as $photo)
                                <img src="{{ url('images/thumb/'.$photo->id) }}">
                            @endforeach
                        </div>
                        @unless($user->albums->count() == 0)
                            <div class="tab-pane fade" id="albums">

                                <ul class="list-group">
                                    @foreach($user->albums as $album)
                                        <li class="list-group-item img-grid">{!! $album->present()->link($album->name)
                                            !!}<br>
                                            <?php $photos = $album->photos()->take( 10 )->get(); ?>
                                            @foreach($photos as $photo)
                                                <a href="{{ $photo->present()->url() }}"><img
                                                            src="{!! $photo->present()->url('image','small') !!}"></a>
                                            @endforeach
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        @endunless
                    </div>
                </div>

                {{--
                |--------------------------------------------------------------------------
                | Comments
                |--------------------------------------------------------------------------
                --}}
            @unless($user->comments()->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        @include('profile._recentActivityPanel')
                    </div>
                </div>
            @endunless

            </div>
        </div>
    </div>
@stop