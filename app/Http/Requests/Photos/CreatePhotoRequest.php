<?php

namespace MyFamily\Http\Requests\Photos;

use MyFamily\Http\Requests\Request;


class CreatePhotoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize( AccessControl $uac )
    {
        return $uac->canCurrentUser( 'UploadPhotoToAlbum', \Pictures::albums()->findOrFail( $this->album_id ) );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_id' => 'required'
        ];
    }

}