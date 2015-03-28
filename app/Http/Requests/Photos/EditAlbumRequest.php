<?php namespace MyFamily\Http\Requests\Photos;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\Authorization\AccessControl;

class EditAlbumRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize(AccessControl $uac)
    {
        return $uac->canCurrentUser( 'EditPhotoAlbum', $this->album );
    }

    /**
     * Get the validation rules that apply to the request.
     * If displaying edit form, nothing is required.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method == "GET") {
            return [];
        } // Return no rules for forum view request

        return [
            'name' => 'required',
        ];
    }

}
