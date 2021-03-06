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
            'display_name' => $user->present()->display_name,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'id' => $user->id,
            'type' => 'user',
            'image' => $user->present()->profile_picture,
        ];
    }

}