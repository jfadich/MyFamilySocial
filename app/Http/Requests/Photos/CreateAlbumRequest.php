<?php namespace MyFamily\Http\Requests\Photos;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\Authorization\AccessControl;

class CreateAlbumRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize(AccessControl $uac)
    {
        return $uac->canCurrentUser( 'CreatePhotoAlbum' );
    }

    /**
     * Get the validation rules that apply to the request.
     * If displaying edit form, nothing is required.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:albums,name',
        ];
    }

}
