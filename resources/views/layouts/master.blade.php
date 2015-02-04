<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Fadich Family</title>
    <!-- Compressed Theme BUNDLE
Note: The bundle includes all the custom styling required for the current theme, however
it was tweaked for the current theme/module and does NOT include ALL of the standalone modules;
The bundle was generated using modern frontend development tools that are provided with the package
To learn more about the development process, please refer to the documentation. -->
   <link href="{{ URL::asset('css/theme-bundle.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <!-- Wrapper required for sidebar transitions -->
    <div class="st-container">

        @include('partials.topnav')

        @include('partials.sidebar')

        @include('partials.chatbar')

        <!-- sidebar effects OUTSIDE of st-pusher: -->
        <!-- st-effect-1, st-effect-2, st-effect-4, st-effect-5, st-effect-9, st-effect-10, st-effect-11, st-effect-12, st-effect-13 -->
        <!-- content push wrapper -->
        <div class="st-pusher" id="content">
            <!-- sidebar effects INSIDE of st-pusher: -->
            <!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->
            <!-- this is the wrapper for the content -->
            <div class="st-content">
                <!-- extra div for emulating position:fixed of the menu -->
                <div class="st-content-inner">
                    <div class="container-fluid">

                        @yield('content')

                    </div>
                </div>
                <!-- /st-content-inner -->
            </div>
            <!-- /st-content -->
        </div>
        <!-- /st-pusher -->

        @include('partials.footer')

    </div>
    <!-- /st-container -->
    <!-- Inline Script for colors and config objects; used by various external scripts; -->
    <script>
    var colors = {
        "danger-color": "#e74c3c",
        "success-color": "#81b53e",
        "warning-color": "#f0ad4e",
        "inverse-color": "#2c3e50",
        "info-color": "#2d7cb5",
        "default-color": "#6e7882",
        "default-light-color": "#cfd9db",
        "purple-color": "#9D8AC7",
        "mustard-color": "#d4d171",
        "lightred-color": "#e15258",
        "body-bg": "#f6f6f6"
    };
    var config = {
        theme: "social-1",
        skins: {
            "default": {
                "primary-color": "#16ae9f"
            },
            "orange": {
                "primary-color": "#e74c3c"
            },
            "blue": {
                "primary-color": "#4687ce"
            },
            "purple": {
                "primary-color": "#af86b9"
            },
            "brown": {
                "primary-color": "#c3a961"
            }
        }
    };
    </script>
    <!-- Separate Vendor Script Bundles -->
    <script src="{{ URL::asset('js/vendor-core.min.js') }}"></script>
    <script src="{{ URL::asset('js/vendor-tables.min.js') }}"></script>
    <script src="{{ URL::asset('js/vendor-forms.min.js') }}"></script>
    <!-- <script src="js/vendor-media.min.js"></script> -->
    <!-- <script src="js/vendor-player.min.js"></script> -->
    <!-- <script src="js/vendor-charts-all.min.js"></script> -->
    <!-- <script src="js/vendor-charts-flot.min.js"></script> -->
    <!-- <script src="js/vendor-charts-easy-pie.min.js"></script> -->
    <!-- <script src="js/vendor-charts-morris.min.js"></script> -->
    <!-- <script src="js/vendor-charts-sparkline.min.js"></script> -->
    <script src="{{ URL::asset('js/vendor-maps.min.js') }}"></script>
    <!-- <script src="js/vendor-tree.min.js"></script> -->
    <!-- <script src="js/vendor-nestable.min.js"></script> -->
    <!-- <script src="js/vendor-angular.min.js"></script> -->
    <!-- Compressed Vendor Scripts Bundle
    Includes all of the 3rd party JavaScript libraries above.
    The bundle was generated using modern frontend development tools that are provided with the package
    To learn more about the development process, please refer to the documentation.
    Do not use it simultaneously with the separate bundles above. -->
    <!-- <script src="js/vendor-bundle-all.min.js"></script> -->
    <!-- Compressed App Scripts Bundle
    Includes Custom Application JavaScript used for the current theme/module;
    Do not use it simultaneously with the standalone modules below. -->
    <!-- <script src="js/module-bundle-main.min.js"></script> -->
    <!-- Standalone Modules
    As a convenience, we provide the entire UI framework broke down in separate modules
    Some of the standalone modules may have not been used with the current theme/module
    but ALL the modules are 100% compatible -->
    <script src="{{ URL::asset('js/module-essentials.min.js') }}"></script>
    <script src="{{ URL::asset('js/module-layout.min.js') }}"></script>
    <script src="{{ URL::asset('js/module-sidebar.min.js') }}"></script>
    <!-- <script src="js/module-media.min.js"></script> -->
    <!-- <script src="js/module-player.min.js"></script> -->
    <script src="{{ URL::asset('js/module-timeline.min.js') }}"></script>
    <script src="{{ URL::asset('js/module-chat.min.js') }}"></script>
    <script src="{{ URL::asset('js/module-maps.min.js') }}"></script>
    <!-- <script src="js/module-charts-all.min.js"></script> -->
    <!-- <script src="js/module-charts-flot.min.js"></script> -->
    <!-- <script src="js/module-charts-easy-pie.min.js"></script> -->
    <!-- <script src="js/module-charts-morris.min.js"></script> -->
    <!-- <script src="js/module-charts-sparkline.min.js"></script> -->
    <!-- [social-1] Core Theme Script:
        Includes the custom JavaScript for this theme/module;
        The file has to be loaded in addition to the UI modules above;
        module-bundle-main.js already includes theme-core.js so this should be loaded
        ONLY when using the standalone modules; -->
    <script src="{{ URL::asset('js/theme-core.min.js') }}"></script>
</body>
</html>