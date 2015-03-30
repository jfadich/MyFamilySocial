<div class="panel panel-default">
    <div class="panel-body text-center">

        <h2>{{ $title }}</h2>
        @unless(empty($lead))
            <p class="lead">
                {{ $lead }}
            </p>
        @endunless
    </div>

</div>