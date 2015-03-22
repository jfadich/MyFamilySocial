<?php namespace MyFamily\Http\Requests;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\AccessControl;

class EditProfileRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize(AccessControl $uac)
    {
        return $uac->canCurrentUser( 'EditProfile', \MyFamily\User::findOrFail( $this->user ) );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthdate'       => 'sometimes|date_format:m/d/Y',
            'email'           => 'sometimes|email',
            'profile_picture' => 'sometimes|mimes:jpeg,bmp,png,gif'
        ];
    }

    public function messages()
    {
        return ['profile_picture.mimes' => 'The file provided was not an accepted image type.'];
    }

}
