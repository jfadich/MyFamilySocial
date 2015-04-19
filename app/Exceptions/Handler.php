<?php namespace MyFamily\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($this->isHttpException($e))
			return $this->renderHttpException($e);

        // Throw 404 when an entity is not found
        if ($e instanceof ModelNotFoundException)
            return \Response::json(['error' => ['message' => 'Resource not found'] ], 404);

        if ($e instanceof TokenExpiredException)
            return \Response::json(['error' => ['message' => 'Expired token'] ], 400);
        if ($e instanceof JWTException)
            return \Response::json(['error' => ['message' => 'No token'] ], 400);


		return parent::render($request, $e);

	}

}
