<?php namespace MyFamily\Services\Authorization;

use MyFamily\Exceptions\AuthorizationException;
use Illuminate\Database\Eloquent\Model;

class AccessControl
{
    public function __construct()
    {
        $this->currentUser = \JWTAuth::toUser();
    }
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
        $request = new Request( $action, $this->currentUser, $subject );

        $request->checkPermission();

        if ( $subject !== null ) {
            $request = $request->authorizeSubject()->checkOwnership();
        }

        return $request->isAuthorized();
    }
}

