<?php namespace MyFamily\Http\Middleware;

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
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, \Closure $next)
	{
        if($request->path() !== 'auth/register' && $request->path() !== 'auth/login')
            $this->auth->setRequest($request)->parseToken()->authenticate();

        return $next($request);
	}

}
