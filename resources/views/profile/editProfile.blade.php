@extends('layouts.master')

@section('content')
    <div class="media media-grid media-clearfix-xs">
        <div class="media-left">
            <div class="width-250 width-auto-xs">
                <div class="panel panel-primary widget-user-1 text-center">
                    <div class="avatar">
                        <form action="{{ url("profile/{$user->id}") }}" class="dropzone" id="profile">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <span class="dropzone-previews">
                                {!! $user->present()->profile_picture('thumb', ['class' => 'img-circle', 'id' => 'profile-picture']) !!}
                            </span>

                            <div class="fallback">
                                <input name="profile_picture" type="file"/>
                            </div>
                        </form>
                        <h3>{{ $user->present()->full_name }}</h3>
                    </div>

                    <div class="profile-icons margin-none" style="background: #F4F9F9">
                        <span><i class="fa fa-comment"></i> {{ $user->comments()->count() }}</span>
                        <span><i class="fa fa-photo"></i> 43</span>
                        <span><i class="fa fa-video-camera"></i> 3</span>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Account
                    </div>
                    <ul class="icon-list icon-list-block">

                        <li><i class="fa fa-key fa-fw"></i>{{ $user->role->name }}</li>

                    </ul>
                </div>

            </div>
        </div>
        <div class="media-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="md-mode-edit"></i> Edit Profile
                </div>
                <div class="panel-body">

                @include('profile._profileForm')

                </div>
            </div>
        </div>
    </div>
@stop

@section('pageFooter')
    <script type="text/javascript">
        $(document).ready(function () {

            Dropzone.options.profile = {
                paramName: 'profile_picture',
                previewsContainer: ".dropzone-previews",
                maxFiles: 1,
                uploadMultiple: false,
                acceptedFiles: 'image/*',
                dictDefaultMessage: "Click/Drop files here to upload",
                init: function () {
                    var myDropzone = this;

                    this.on("addedfile", function (file) {
                        $('#profile-picture').hide();
                    });
                    this.on("removedfile", function (file) {
                        $('#profile-picture').show();
                    });

                    this.on("maxfilesexceeded", function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                }
            };

        });

    </script>
@endsection