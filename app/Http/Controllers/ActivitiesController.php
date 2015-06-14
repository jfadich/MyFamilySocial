<?php namespace MyFamily\Http\Controllers;

use MyFamily\Activity;
use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;

use Illuminate\Http\Request;
use MyFamily\Repositories\ActivityRepository;
use MyFamily\Transformers\ActivityTransformer;

class ActivitiesController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @param ActivityRepository $activities
     * @param ActivityTransformer $activityTransformer
     */
    public function __construct(ActivityRepository $activities, ActivityTransformer $activityTransformer)
    {
        $this->activityTransformer = $activityTransformer;
        $this->activities = $activities;
    }

    public function index()
    {
        return $this->respondWithCollection( $this->activities->getFeed(), $this->activityTransformer );
    }

}
