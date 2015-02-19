<div class="pull-right dropdown">
    <a href="#" data-toggle="dropdown" class="toggle-button">
        <i class="fa fa-pencil"></i>
    </a>
    <ul class="dropdown-menu" role="menu" style="position: inherit">
        @if(isset($editUrl))
        <li><a href="{{ URL::to($editUrl) }}">Edit</a>
        </li>
        @endif
        @if(isset($deleteUrl))
            <li><a href="{{ URL::to($deleteUrl) }}">Delete</a>
        </li>
            @endif
    </ul>
</div>