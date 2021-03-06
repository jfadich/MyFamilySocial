<?php namespace MyFamily\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'MyFamily\DBLogger\Http\DBLoggerMiddleware',
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Barryvdh\Cors\Middleware\HandleCors'
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
        'auth' => 'MyFamily\Http\Middleware\Authenticate',
		'guest' => 'MyFamily\Http\Middleware\RedirectIfAuthenticated',
	];

}
