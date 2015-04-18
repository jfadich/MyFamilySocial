<?php namespace MyFamily\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

abstract class ApiController extends BaseController {

    protected $statusCode = 200;

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
                'statusCode' => $this->getStatusCode()
            ]
        ]);
    }
    protected function respondNotFound($message = 'Resource not found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

}
