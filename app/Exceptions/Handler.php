<?php namespace MyFamily\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use MyFamily\Traits\RespondsWithJson;
use MyFamily\Errors;
use Exception;

class Handler extends ExceptionHandler {

    use RespondsWithJson;

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
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
        if ($e instanceof ModelNotFoundException)
            return $this->respondNotFound('Resource not found');

        if($e instanceof NotFoundHttpException)
            return $this->respondNotFound('Page not found');

        if ($e instanceof TokenExpiredException)
            return $this->setErrorCode( Errors::TOKEN_EXPIRED )->respondUnauthorized( $e->getMessage() );

        if ($e instanceof JWTException && strpos($e->getMessage(), 'The token could not be parsed from the request') !== false)
            return $this->setErrorCode( Errors::NO_TOKEN_PRESENT )->respondUnauthorized( $e->getMessage() );

        if ($e instanceof JWTException || $e instanceof TokenInvalidException)
            return $this->setErrorCode( Errors::INVALID_TOKEN )->respondBadRequest( $e->getMessage() );

        if($e instanceof InvalidRelationshipException)
            return $this->setErrorCode( Errors::INVALID_RELATIONSHIP)->RespondBadRequest($e->getMessage());

		return parent::render($request, $e);

	}

}
