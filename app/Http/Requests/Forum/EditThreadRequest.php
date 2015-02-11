<?php namespace MyFamily\Http\Requests\Forum;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\AccessControl;

class EditThreadRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize(AccessControl $uac)
    {
        return $uac->canCurrentUser('EditForumThread', $this->thread );
    }

    /**
     * Get the validation rules that apply to the request.
     * If displaying form, nothing is required.
     *
     * @return array
     */
    public function rules()
    {
        if($this->method == "GET")
            return [];

        return [
            'body' => 'required'
        ];
    }

}
