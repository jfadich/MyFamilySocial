<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Controllers\Controller;
use MyFamily\Http\Requests\EditProfileRequest;
use MyFamily\Repositories\UserRepository;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;

class ProfileController extends Controller {

    private $users;

    /**
     * @var users
     */
    private $userRepository;

    public function __construct(UserRepository $users)
	{
		$this->middleware('auth');
        $this->users = $users;
    }

	/**
	 * Display the logged in users profile
	 *
	 * @return Response
	 */
	public function showCurrentUser()
	{
		return view('profile.showProfile', ['user' => \Auth::user()]);
	}

	/**
	 * Show a users profile
	 *
	 * @param $user
	 * @return Response
	 */
	public function showUser($user)
	{
		return view('profile.showProfile', ['user' => $this->users->findOrFail($user)]);
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
	public function edit($id)
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
        $user = \MyFamily\User::findOrFail( $id );
        $user->update( $request->only( ['first_name', 'last_name', 'email', 'phone_one', 'phone_two'] ) );

        if ($request->hasFile( 'profile_picture' )) {
            $photo = \Pictures::photos()->create( $request->file( 'profile_picture' ), $user->profileAlbum->id );
            $user->updateProfilePicture( $photo );
        }

        \Flash::success( 'Profile Updated' );

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
