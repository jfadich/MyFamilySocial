<?php namespace MyFamily\Http\Requests\Forum;

use MyFamily\Http\Requests\Request;
use MyFamily\Services\AccessControl;

class CreateThreadReplyRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param AccessControl $uac
	 * @return bool
	 */
	public function authorize(AccessControl $uac)
	{
		return $uac->canCurrentUser('CreateThreadReply');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'comment' => 'required'
		];
	}

}
