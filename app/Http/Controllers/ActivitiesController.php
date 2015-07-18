<?php namespace MyFamily\Http\Controllers;

use MyFamily\Transformers\ActivityTransformer;
use MyFamily\Repositories\ActivityRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use League\Fractal\Manager;

class ActivitiesController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @param ActivityRepository $activities
     * @param ActivityTransformer $activityTransformer
     * @param Manager $fractal
     * @param Request $request
     */
    public function __construct(
        ActivityRepository $activities,
        ActivityTransformer $activityTransformer,
        Manager $fractal,
        Request $request
    )
    {
        parent::__construct( $fractal, $request );
        $this->activityTransformer = $activityTransformer;
        $this->activities = $activities;
    }

    public function index()
    {
        return $this->respondWithCollection( $this->activities->getFeed(), $this->activityTransformer );
    }

}
