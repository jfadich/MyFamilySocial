<?php namespace MyFamily\Http\Controllers;

use MyFamily\Activity;
use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ActivitiesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    public function index()
    {
        return view( 'activity.show', [
            'activity' => Activity::latest()->select( \DB::raw( '*,count(id) as activity_count' ) )->groupBy( 'owner_id',
                'name', 'target_id', \DB::raw( 'date(created_at)' ) )->simplePaginate( 20 )
        ] );
    }

}
