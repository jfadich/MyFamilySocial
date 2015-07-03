<?php namespace MyFamily\Http\Middleware;

use MyFamily\Exceptions\AuthorizationException;
use Tymon\JWTAuth\JWTAuth;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param JWTAuth $auth
     */
	public function __construct(JWTAuth $auth)
	{
		$this->auth = $auth;
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
	public function handle($request, \Closure $next)
	{
        if ( substr( $request->path(), 0, 5 ) !== 'auth/' ) {
            $this->auth->setRequest($request)->parseToken()->authenticate();

            if ( !$this->auth->toUser() ) {
                throw new AuthorizationException( 'User does not exist' );
            }
        }

        return $next($request);
	}

}
