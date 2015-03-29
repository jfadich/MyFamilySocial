<?php namespace MyFamily\Http\Requests\Photos;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\Authorization\AccessControl;

class CreatePhotoCommentRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize(AccessControl $uac)
    {
        return $uac->canCurrentUser( 'CreatePhotoComment' );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required'
        ];
    }

}
