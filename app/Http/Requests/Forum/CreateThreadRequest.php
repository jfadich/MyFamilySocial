<?php namespace MyFamily\Http\Requests\Forum;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\Authorization\AccessControl;

class CreateThreadRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param AccessControl $uac
	 * @return bool
	 */
	public function authorize(AccessControl $uac)
	{
		return $uac->canCurrentUser('CreateForumThread');
	}

	/**
	 * Get the validation rules that apply to the request.
     * If displaying create form, nothing is required.
	 *
	 * @return array
	 */
	public function rules()
	{

		if($this->method == "GET")
			return []; // Return no rules for forum view request

		return [
			'title' => 'required|unique:forum_threads,title',
			'body' => 'required',
			'category' => 'required'
		];
	}

}
