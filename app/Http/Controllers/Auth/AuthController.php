<?php namespace MyFamily\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use MyFamily\Http\Controllers\ApiController;
use Tymon\JWTAuth\Exceptions\JWTException;
use League\Fractal\Manager;

class AuthController extends ApiController
{

    public function __construct(Manager $fractal, Request $request)
    {
        $this->middleware('guest');
    }
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->respondUnauthorized('invalid_credentials');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->respondInternalError('could_not_create_token');
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}