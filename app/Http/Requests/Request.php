<?php namespace MyFamily\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    public function allExceptNull($columns = null)
    {
        $all = parent::except( $columns );

        return array_filter( $all );

    }
}
