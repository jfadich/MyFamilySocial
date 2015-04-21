<?php namespace MyFamily\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'MyFamily\Http\Middleware\CORS',
		//'Illuminate\Cookie\Middleware\EncryptCookies',
		//'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		//'Illuminate\Session\Middleware\StartSession',
		//'Illuminate\View\Middleware\ShareErrorsFromSession',
		//'MyFamily\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'MyFamily\Http\MiddleWare\Authenticate',
		'guest' => 'MyFamily\Http\Middleware\RedirectIfAuthenticated',
	];

}
