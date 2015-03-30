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
            'activity' => Activity::groupBy( ['subject_id', 'subject_type'] )->with( [
                'actor',
                'subject'
            ] )->simplePaginate( 20 )
        ] );
    }

}
