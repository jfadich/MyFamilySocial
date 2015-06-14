<?php namespace MyFamily\Http\Requests;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use MyFamily\Traits\RespondsWithJson;
use MyFamily\Errors;

abstract class Request extends FormRequest {

    use RespondsWithJson;

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
        return $this->setErrorCode( Errors::INVALID_ENTITY )->respondUnprocessableEntity( $errors );
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
