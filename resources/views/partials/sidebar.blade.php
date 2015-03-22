<!-- Sidebar component with st-effect-1 (set on the toggle button within the navbar) -->
<div class="sidebar left sidebar-size-2 sidebar-offset-0 sidebar-visible-desktop sidebar-visible-mobile sidebar-skin-dark" id="sidebar-menu" data-type="collapse">
    <div data-scrollable>
        <ul class="sidebar-menu">
            <li class="">
                <a href="{{ URL::to('home') }}"><i class="icon-ship-wheel"></i> <span>Home</span></a>
            </li>
            <li class=""><a href="{{ URL::to('me') }}"><i class="icon-user-1"></i> <span>Profile</span></a>
            </li>
            <li class=""><a href="{{ URL::to('family') }}"><i class="fa fa-group"></i> <span>Family</span></a>
            </li>
            <li class=""><a href="{{ URL::to('messages') }}"><i class="fa fa-envelope-o"></i> <span>Messages</span></a>
            <li class=""><a href="{{ URL::to('forum') }}"><i class="fa fa-wechat"></i> <span>Discussions</span></a>
    </div>
</div>