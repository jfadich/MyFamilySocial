<div class="panel panel-primary">
    <div class="panel-heading panel-heading-gray">
        <i class="md-apps"></i> Recent Activity
    </div>
    <div class="panel-body">
        <div class="timeline row" data-toggle="isotope">
            @foreach($user->activity()->select(\DB::raw('*,count(id) as activity_count'))->take(5)->latest()->groupBy('target_type', 'target_id')->get() as $activity)

                @include('activity.types.'.$activity->name, ['action' => $activity])

            @endforeach
        </div>
    </div>
</div>


