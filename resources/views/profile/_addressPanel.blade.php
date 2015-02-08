<div class="panel panel-default">
    <div class="panel-heading panel-heading-gray">
        <i class="fa fa-fw fa-info-circle"></i> Address
    </div>
    <div class="panel-body">
        <address>
            <strong>{{ $user->first_name }} {{ $user->last_name }}</strong><br>
            {{ $user->address }}<br>
            {{ $user->city }}, {{ $user->state }} {{ $user->zip_code }}<br>
            {{ $user->country }}
        </address>
    </div>
</div>