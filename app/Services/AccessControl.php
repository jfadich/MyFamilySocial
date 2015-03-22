<?php namespace MyFamily\Services;

use MyFamily\Exceptions\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use MyFamily\User;

class AccessControl {

    /**
     * Check a requested action against the permissions granted by the current users role
     * Check for ownership if an entity is given
     *
     * @param $action
     * @param null $subject
     * @return bool
     * @throws AuthorizationException
     */
    public function canCurrentUser($action, $subject = null)
    {
        $authorised = false;

        if($subject != null)
        {
            if( ! $subject instanceof Model)
                throw new AuthorizationException('The provided entity is not valid.');

            if ($subject instanceof User)
                $authorised = $subject->id === \Auth::id();

            elseif (\Auth::user()->id == $subject->owner_id)
                $authorised = true;
        }

        if(in_array($action, \Auth::user()->role->permissions()->lists('name')))
            $authorised = true;

        return $authorised;
    }
}