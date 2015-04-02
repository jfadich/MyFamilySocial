<div class="col-xs-12 col-md-6 col-lg-4 item">
    <div class="timeline-block">
        <div class="panel panel-primary" id="testing">

            {{--@if(isset($subTitle))
                <div class="panel-body">
                    {!! $subTitle !!}
                </div>
            @endif --}}
            @yield('cardTop')
            @yield('card')

        </div>
    </div>
</div>

