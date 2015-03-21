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
        //return $uac->canCurrentUser('EditProfile', user );
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['birthdat' => 'date'];
    }

}
