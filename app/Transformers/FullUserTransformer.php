<?php namespace MyFamily\Transformers;

use MyFamily\User;

class FullUserTransformer extends Transformer {

    protected $roleTransformer;

    protected $availableIncludes = ['role'];

    protected $permissions = [
        'edit'      => 'EditProfileInfo',
        'authorize' => 'EditUserRole'
    ];

    /**
     * @param RoleTransformer $roleTransformer
     */
    function __construct(RoleTransformer $roleTransformer)
    {
        $this->roleTransformer = $roleTransformer;
    }

    /**
     * @param User $user
     * @return array
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function transform(User $user)
    {
        $user = [
            'display_name' => $user->present()->display_name,
            'first_name'   => $user->present()->first_name,
            'last_name'    => $user->present()->last_name,
            'email'        => $user->present()->email,
            'phone_one'    => $user->present()->phone_one,
            'phone_two'    => $user->present()->phone_two,
            'address'      => $user->present()->address,
            'website'      => $user->present()->website,
            'birthday'     => $user->present()->birthday,
            'id'           => $user->id,
            'image'        => $user->present()->profile_picture,
            'permissions'  => $this->getPermissions( $user )
        ];

        return array_filter($user); // remove empty fields
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Item
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function includeRole(User $user)
    {
        $role = $user->present()->role();

        if ( $role === null ) {
            return $role;
        }

        return $this->item($role, $this->roleTransformer);
    }

}