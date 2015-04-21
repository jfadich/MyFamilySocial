<?php namespace MyFamily\Http\Requests\Forum;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\Authorization\AccessControl;

class EditThreadRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AccessControl $uac
     * @return bool
     */
    public function authorize(AccessControl $uac)
    {

        return $uac->canCurrentUser( 'ModifyForumThread', \Forum::threads()->getThread($this->thread) );
    }

    /**
     * Get the validation rules that apply to the request.
     * If displaying edit form, nothing is required.
     *
     * @return array
     */
    public function rules()
    {
            return [];
    }

    public function wantsJson()
    {
        return true;
    }
}
