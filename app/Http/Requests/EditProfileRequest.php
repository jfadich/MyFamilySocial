<?php namespace MyFamily\Http\Requests;

use MyFamily\Repositories\UserRepository;
use MyFamily\Http\Requests\Request;
use MyFamily\Services\AccessControl;

class EditProfileRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @param UserRepository $users
     * @return bool
     * @throws \MyFamily\Exceptions\AuthorizationException
     */
    public function authorize(AccessControl $uac, UserRepository $users)
    {
        return $uac->canCurrentUser( 'EditProfileInfo', $users->findOrFail( $this->user ) );
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
