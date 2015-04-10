<?php namespace MyFamily\Http\Controllers;

use Flash;
use MyFamily\Http\Controllers\Controller;
use MyFamily\Http\Requests\EditProfileRequest;
use MyFamily\Repositories\ActivityRepository;
use MyFamily\Repositories\UserRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use Pictures;

class ProfileController extends Controller {

    private $users;

    public function __construct(UserRepository $users, ActivityRepository $activity)
	{
		$this->middleware('auth');
        $this->users = $users;
        $this->activity = $activity;
    }

	/**
	 * Display the logged in users profile
	 *
	 * @return Response
	 */
	public function showCurrentUser()
	{
        return view( 'profile.showProfile', [
            'user'           => \Auth::user(),
            'recentActivity' => $this->activity->getUserFeed( \Auth::user() )
        ] );
	}

    /**
     * Show a users profile
     *
     * @param $user
     * @return Response
     */
	public function showUser($user)
	{
        $user = $this->users->findOrFail( $user );
        return view( 'profile.showProfile', [
            'user' => $user,
            'recentActivity' => $this->activity->getUserFeed( $user )
        ] );
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id, EditProfileRequest $request)
	{
        return view( 'profile.editProfile', ['user' => $this->users->findOrFail( $id )] );
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
