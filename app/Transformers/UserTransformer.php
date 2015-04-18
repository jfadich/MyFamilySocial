<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\User;

class UserTransformer extends TransformerAbstract {


    public function transform(User $user)
    {
        return [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'url' => $user->present()->url(),
            'image' => !is_null($user->profile_picture()->first()) ? $user->profile_picture()->first()->present()->url('image', 'small') : null
        ];
    }

}