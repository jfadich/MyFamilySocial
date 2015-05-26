<?php namespace MyFamily\Http\Requests;

use MyFamily\Services\Authorization\AccessControl;

class DeleteCommentRequest extends Request
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
        return $uac->canCurrentUser( 'DeleteComment', \MyFamily\Comment::findorFail( $this->comment ) );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }


}
