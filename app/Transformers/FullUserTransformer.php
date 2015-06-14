<?php namespace MyFamily\Transformers;

use MyFamily\User;

class FullUserTransformer extends Transformer {

    protected $roleTransformer;

    protected $availableIncludes = ['role'];

    protected $permissions = [
        'edit'      => 'EditProfileInfo',
        'authorize' => 'EditUserRole'
    ];

    function __construct(RoleTransformer $roleTransformer)
    {
        $this->roleTransformer = $roleTransformer;
    }

    public function transform(User $user)
    {
        $user = [
            'display_name' => $user->present()->display_name,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email,
            'phone_one'     => $user->phone_one,
            'phone_two'     => $user->phone_two,
            'address'       => [
                                    'street_address'    => $user->street_address,
                                    'city'              => $user->city,
                                    'state'             => $user->state,
                                    'zip-code'          => $user->zip_code
                                ],
            'website'       => $user->website,
            'birthday'     => $user->present()->birthday,
            'id'           => $user->id,
            'image'         => !is_null($user->profile_picture()->first()) ? $this->getImageArray($user->profile_picture()->first()) : null,
            'permissions'   => $this->getPermissions($user)
        ];

        return array_filter($user); // remove empty fields
    }

    public function includeRole(User $user)
    {
        $loggedIn = \JWTAuth::toUser();

        if($loggedIn->id !== $user->id)
            return null;

        $role = $user->role()->with(['permissions'])->first();

        return $this->item($role, $this->roleTransformer);
    }

}