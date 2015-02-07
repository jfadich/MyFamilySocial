<?php namespace MyFamily\Http\Requests\Forum;

use MyFamily\Http\Requests\Request;

class CreateForumThreadRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => 'required',
			'message' => 'required',
			'category' => 'required'
		];
	}

}
