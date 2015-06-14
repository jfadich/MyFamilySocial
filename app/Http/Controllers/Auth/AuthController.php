<?php namespace MyFamily\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use MyFamily\Http\Controllers\ApiController;
use MyFamily\Http\Requests\CreateUserRequest;
use MyFamily\Repositories\UserRepository;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
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
        return $this->respondWithArray(compact('token'));
    }

    public function refresh(Request $request)
    {
        $token = JWTAuth::setRequest($request)->parseToken()->refresh();

        return response()->json(compact('token'));
    }

    public function register(CreateUserRequest $request, UserRepository $users) {
        $data = $request->all();
        $user = $users->createUser([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => 1,
        ]);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithArray(compact('token'));
    }
}
