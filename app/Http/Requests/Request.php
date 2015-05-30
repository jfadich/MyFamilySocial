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
    const INVALID_ENTITY    = 201;
    const ENTITY_NOT_EXISTS = 202;
    const DUPLICATE_ENTITY  = 203;

    public function allExceptNull($columns = null)
    {
        $all = parent::except( $columns );

        return array_filter( $all );

    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return $this->setErrorCode(self::INVALID_ENTITY)->respondUnprocessableEntity($errors);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return mixed
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->setErrorCode(self::UNAUTHORIZED)->respondForbidden('You are not authorized to make this request'));
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
