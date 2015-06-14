<?php namespace MyFamily\Transformers;

use MyFamily\User;

class UserTransformer extends Transformer {

    /**
     * Small user to be included for most relations
     *
     * @param User $user
     * @return array
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function transform(User $user)
    {
        return [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'id' => $user->id,
            'image' => $user->present()->profile_picture,
        ];
    }

}