<?php namespace MyFamily\Http\Controllers;

use MyFamily\Activity;
use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;

use Illuminate\Http\Request;
use MyFamily\Repositories\ActivityRepository;

class ActivitiesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @param ActivityRepository $activities
     */
    public function __construct(ActivityRepository $activities)
    {
        $this->activities = $activities;
        $this->middleware( 'auth' );
    }

    public function index()
    {
        return view( 'activity.show', [
            'activity' => $this->activities->getFeed()
        ] );
    }

}
