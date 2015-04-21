<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests\EditProfileRequest;
use MyFamily\Repositories\ActivityRepository;
use MyFamily\Repositories\UserRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use League\Fractal\Manager;
use MyFamily\Transformers\FullUserTransformer;
use Pictures;
use JWTAuth;

class UsersController extends ApiController {

    private $users;

    public function __construct(UserRepository $users, ActivityRepository $activity, Manager $fractal, Request $request, FullUserTransformer $userTransformer)
	{
        parent::__construct($fractal, $request);
        $this->users = $users;
        $this->activity = $activity;
        $this->userTransformer = $userTransformer;
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

        if ($request->ajax()) {
            return ['message' => 'Profile Updated'];
        } else {
            Flash::success( 'Profile Updated' );
        }

        return view( 'profile.showProfile', ['user' => $user] );
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
