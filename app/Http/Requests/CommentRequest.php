<?php namespace MyFamily\Http\Requests;

use MyFamily\Services\Authorization\AccessControl;

class CommentRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     * @throws \MyFamily\Exceptions\AuthorizationException
     */
    public function authorize(AccessControl $uac)
    {
        if($this->method() == 'DELETE')
            return $uac->canCurrentUser( 'DeleteComment', \MyFamily\Comment::findorFail( $this->comment ) );

        if($this->method() == 'PATCH')
            return $uac->canCurrentUser( 'EditComment', \MyFamily\Comment::findorFail( $this->comment ) );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->method() == 'PATCH')
            return ['body' => 'required'];

        return [];
    }


}
