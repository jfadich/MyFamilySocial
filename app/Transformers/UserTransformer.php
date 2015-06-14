<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\User;

class UserTransformer extends Transformer {


    public function transform(User $user)
    {
        return [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'id' => $user->id,
            'image' => !is_null($user->profile_picture()->first()) ? $this->getImageArray($user->profile_picture()->first()) : null
        ];
    }

}