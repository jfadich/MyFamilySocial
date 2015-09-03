<?php namespace MyFamily\Transformers;

use League\Fractal\ParamBag;
use MyFamily\Repositories\ActivityRepository;
use MyFamily\User;

class FullUserTransformer extends Transformer {

    protected $roleTransformer;

    protected $availableIncludes = [ 'role', 'profile_pictures', 'albums', 'activity' ];

    protected $permissions = [
        'edit'      => 'EditProfileInfo',
        'authorize' => 'EditUserRole'
    ];
    /**
     * @var PhotoTransformer
     */
    private $photoTransformer;
    /**
     * @var AlbumTransformer
     */
    private $albumTransformer;
    /**
     * @var ActivityTransformer
     */
    private $activityTransformer;
    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    /**
     * @param RoleTransformer $roleTransformer
     * @param PhotoTransformer $photoTransformer
     * @param AlbumTransformer $albumTransformer
     * @param ActivityTransformer $activityTransformer
     * @param ActivityRepository $activityRepository
     */
    function __construct(
        RoleTransformer $roleTransformer,
        PhotoTransformer $photoTransformer,
        AlbumTransformer $albumTransformer,
        ActivityTransformer $activityTransformer,
        ActivityRepository $activityRepository
    )
    {
        $this->roleTransformer = $roleTransformer;
        $this->photoTransformer = $photoTransformer;
        $this->albumTransformer = $albumTransformer;
        $this->activityTransformer = $activityTransformer;
        $this->activityRepository = $activityRepository;
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
            'birthdate' => $user->present()->birthday( true ),
            'id'           => $user->id,
            'image'        => $user->present()->profile_picture,
            'permissions' => $this->getPermissions( $user ),
            'type'        => 'user'
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

    public function includeProfilePictures( User $user, ParamBag $params = null )
    {
        $picutres = \Pictures::photos()->getBy( $user, $params[ 'limit' ], $params[ 'order' ] );

        return $this->collection( $picutres, $this->photoTransformer );
    }

    public function includeAlbums( User $user, ParamBag $params = null )
    {
        $picutres = \Pictures::albums()->getUserAlbums( $user, $params[ 'limit' ], $params[ 'order' ] );

        return $this->collection( $picutres, $this->albumTransformer );
    }

    public function includeActivity( User $user, ParamBag $params = null )
    {
        $activity = $this->activityRepository->getUserFeed( $user, $params );

        return $this->collection( $activity, $this->activityTransformer );
    }

}