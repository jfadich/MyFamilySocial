<?php namespace MyFamily\Traits;

use Illuminate\Http\Response;

trait RespondsWithJson
{
    protected $statusCode = 200;

    protected function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->getStatusCode(), $headers);
    }

    protected function respondWithError($message)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for erroring on a 200...",
                E_USER_WARNING
            );
        }

        return $this->respond([
            'error' => [
                'message' => $message,
                'http_code' => $this->getStatusCode(),
            ]
        ]);
    }

    protected function respondNotFound($message = 'Resource not found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }


    protected function respondUnauthorized($message = 'You are not authorized')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    protected function respondBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function respond($data, $headers = [])
    {
        return response($data, $this->getStatusCode(), $headers);
    }
}