<?php namespace MyFamily\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    public function allExceptNull()
    {
        $all = parent::all();

        return array_filter( $all, function ($value) {
            return ( $value !== null && !empty( $value ) );
        } );
    }

}
