<?php namespace MyFamily\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;
use MyFamily\Traits\RespondsWithJson;

abstract class Request extends FormRequest {

    use RespondsWithJson;

    const NO_TOKEN_PRESENT  = 101;
    const TOKEN_EXPIRED     = 102;
    const INVALID_TOKEN     = 103;
    const UNAUTHORIZED      = 104;

    public function allExceptNull($columns = null)
    {
        $all = parent::except( $columns );

        return array_filter( $all );

    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return mixed
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->setErrorCode(100)->respondUnauthorized('Failed Authorization'));
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        return $this->setErrorCode(self::FORBIDDEN)->respondForbidden('Forbidden');
    }

}
