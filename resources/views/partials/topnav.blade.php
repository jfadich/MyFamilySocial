<!-- Fixed navbar -->
<div class="navbar navbar-main navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="#sidebar-menu" data-effect="st-effect-1" data-toggle="sidebar-menu" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#sidebar-chat" data-toggle="sidebar-menu" data-effect="st-effect-1" class="toggle pull-right visible-xs "><i class="fa fa-comments"></i></a>
            <a class="navbar-brand navbar-brand-primary hidden-xs" href="{{ URL::to('/') }}">Fadich Family</a>
        </div>
        <div class="collapse navbar-collapse" id="main-nav">
            <ul class="nav navbar-nav hidden-xs">
                <!-- messages -->
                <li class="dropdown notifications hidden-xs hidden-sm">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object thumb" src="images/people/50/guy-2.jpg" alt="people">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="pull-right">
                                    <span class="label label-default">5 min</span>
                                </div>
                                <h5 class="media-heading">Adrian D.</h5>
                                <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object thumb" src="images/people/50/woman-7.jpg" alt="people">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="pull-right">
                                    <span class="label label-default">2 days</span>
                                </div>
                                <h5 class="media-heading">Jane B.</h5>
                                <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object thumb" src="images/people/50/guy-8.jpg" alt="people">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="pull-right">
                                    <span class="label label-default">3 days</span>
                                </div>
                                <h5 class="media-heading">Andrew M.</h5>
                                <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- // END messages -->
            </ul>
            <ul class="nav navbar-nav navbar-user">
                <!-- User -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="images/people/50/guy-5.jpg" width="35" alt="Bill" class="img-circle" /> {{ Auth::user()->first_name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="profile.html">Profile</a>
                        </li>
                        <li><a href="messages.html">Messages</a>
                        </li>
                        <li><a href="login.html">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form margin-none navbar-left hidden-xs ">
                <!-- Search -->
                <div class="search-1">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search a friend">
                    </div>
                </div>

            </form>

            @yield('page_nav')

            <ul class="nav navbar-nav navbar-right hidden-xs">
                <li class="pull-right">
                    <a href="#sidebar-chat" data-effect="st-effect-1" data-toggle="sidebar-menu">
                        <i class="fa fa-comments"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>