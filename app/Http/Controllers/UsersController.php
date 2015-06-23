<?php namespace MyFamily\Http\Controllers;

use MyFamily\Transformers\FullUserTransformer;
use MyFamily\Http\Requests\EditProfileRequest;
use MyFamily\Repositories\ActivityRepository;
use MyFamily\Repositories\UserRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use League\Fractal\Manager;
use Pictures;
use JWTAuth;

class UsersController extends ApiController {

    /*
     * \MyFamily\Repositories\UserRepository
     */
    private $users;

    protected $availableIncludes = [ 'role', 'profile_pictures', 'albums' ];

    /**
     * @param UserRepository $users
     * @param ActivityRepository $activity
     * @param Manager $fractal
     * @param Request $request
     * @param FullUserTransformer $userTransformer
     * @throws \MyFamily\Exceptions\InvalidRelationshipException
     */
    public function __construct(UserRepository $users, ActivityRepository $activity, Manager $fractal, Request $request, FullUserTransformer $userTransformer)
	{
        parent::__construct($fractal, $request);
        $this->users = $users;
        $this->activity = $activity;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing all the users.
     *
     * @param FullUserTransformer $userTransformer
     * @return Response
     */
    public function index(FullUserTransformer $userTransformer)
    {
        return $this->respondWithCollection($this->users->getAll(), $userTransformer);
    }

	/**
	 * Display the logged in users profile
	 *
	 * @return Response
	 */
	public function showCurrentUser()
	{
        $user = JWTAuth::toUser();

        return $this->respondWithItem($user, $this->userTransformer);
	}

    /**
     * Show a users profile
     *
     * @param $user
     * @return Response
     */
	public function showUser($user)
	{
        $user = $this->users->find( $user );

        if( ! $user )
            return $this->respondNotFound('User not found');

        return $this->respondWithItem($user, $this->userTransformer);
	}

    /**
     * Search for a user by first name
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {

    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param EditProfileRequest $request
     * @return Response
     */
    public function update($id, EditProfileRequest $request)
	{
        $user = $this->users->findOrFail( $id );

        $user->update( $request->allExceptNull( 'profile_picture' ) );

        if ($request->hasFile( 'profile_picture' )) {
            $photo = Pictures::photos()->create( $request->file( 'profile_picture' ), $user );
            $user->updateProfilePicture( $photo );
        }

        $meta['status'] = 'success';

        return $this->respondWithItem($user, $this->userTransformer, $meta);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
