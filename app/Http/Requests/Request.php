<?php namespace MyFamily\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;
use MyFamily\Traits\RespondsWithJson;

abstract class Request extends FormRequest {

    use RespondsWithJson;

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
        throw new HttpResponseException($this->respondUnauthorized('Failed Authorization'));
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        return $this->respondUnauthorized('Forbidden');
    }

}
