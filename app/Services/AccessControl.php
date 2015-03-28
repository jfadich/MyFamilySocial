<?php namespace MyFamily\Services;

use MyFamily\Exceptions\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use MyFamily\Repositories\PermissionRepository;
use MyFamily\User;

class AccessControl {

    protected $current_user;

    /**
     * Check a requested action against the permissions granted by the current users role
     * Check for ownership if an entity is given
     *
     * @param $action
     * @param Model|null $subject
     * @return bool
     * @throws AuthorizationException
     */
    public function canCurrentUser($action, Model $subject = null)
    {
        $authorised = false;
        $this->current_user = \Auth::user();

        if($subject != null)
        {
            /*
             * Check to see if access to the requested action is dictated by ownership or role.
             */
            if (method_exists( 'restrictedActions', $subject )) {
                if (!in_array( $action, $subject->restrictedActions() )) {
                    $authorised = $this->checkOwnership( $this->current_user, $subject );
                }
            } else
                $authorised = $this->checkOwnership( $this->current_user, $subject );

            if (method_exists( $subject, 'authorize' )) {
                if ($subject->authorize( $this->current_user, $action ))
                    $authorised = true;
            }

        }

        if ($this->checkPermissions( $this->current_user, $action ))
            $authorised = true;

        return $authorised;
    }

    /**
     * @param $user
     * @param $subject
     * @return bool
     * @throws AuthorizationException
     */
    private function checkOwnership($user, $subject)
    {
        $owner = false;

        if ($subject instanceof User) {
            $owner = $subject->id === $user->id;
        } elseif ($subject->owner_id === $user->id) {
            $owner = true;
        }

        return $owner;
    }

    /**
     * @param $user
     * @param $action
     * @return bool
     */
    private function checkPermissions($user, $action)
    {
        return ( $user->role->permissions()->where( 'name', '=', $action )->count() > 0 );
    }
}