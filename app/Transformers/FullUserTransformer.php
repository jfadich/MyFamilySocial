<?php namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\User;

class FullUserTransformer extends TransformerAbstract {

    public function transform(User $user)
    {
        $user = [
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email,
            'email'         => $user->email,
            'phone_one'     => $user->phone_one,
            'phone_twp'     => $user->phone_two,
            'address'       => [
                                    'street_address'    => $user->street_address,
                                    'city'              => $user->city,
                                    'state'             => $user->state,
                                    'zip-code'          => $user->zip_code
                                ],
            'website'       => $user->website,
            'birthday'      => !is_null($user->birthdate) ? $user->birthdate->timestamp : null ,
            'url'           => $user->present()->url(),
            'image'         => !is_null($user->profile_picture()->first()) ? $user->profile_picture()->first()->present()->url('image', 'small') : null
        ];

        return array_filter($user); // remove empty fields
    }

}