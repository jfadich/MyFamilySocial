<?php namespace MyFamily\Http\Controllers;

use MyFamily\Http\Requests;
use MyFamily\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller {

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
		return view('profile.showProfile', ['user' => \MyFamily\User::findOrFail($user)]);
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
