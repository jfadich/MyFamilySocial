<?php namespace MyFamily\Services\Authorization;

use MyFamily\User;

class Request
{
    private $action = '';
    private $subject = null;
    private $requester = null;
    private $authorized = false;
    private $hasPermission = false;

    /**
     * @param $action
     * @param $requester
     * @param $subject
     */
    function __construct($action, $requester, $subject)
    {
        $this->action    = $action;
        $this->requester = $requester;
        $this->subject = $subject;
    }

    /**
     * Check if requester is granted permission
     *
     * @param null $action
     * @return $this
     */
    public function checkPermission( $action = null )
    {
        $action = $action !== null ?: $this->action;

        if ( in_array( $action, $this->requester->role->permissions->lists( 'name' )->toArray() ) ) {
            $this->authorized    = true;
            $this->hasPermission = true;
        }

        return $this;
    }

    /**
     * Check if the requester owns the subject and the action is not restricted to admins.
     * If the subject is a user check if it matches the requester.
     *
     * @return $this
     */
    public function checkOwnership()
    {
        $owner = false;

        if ($this->subject instanceof User) {
            $owner = $this->subject->id === $this->requester->id;
        } elseif ($this->subject->owner_id === $this->requester->id) {
            $owner = true;
        }

        if ($owner && !$this->restrictedAction()) {
            $this->authorized = true;
        } elseif ( $this->restrictedAction() ) {
            $this->authorized = false;
        }

        return $this;
    }

    /**
     * Give the subject a say in authorization
     *
     * @return $this
     */
    public function authorizeSubject()
    {
        if ( method_exists( $this->subject, 'authorize' ) )
            return $this->subject->authorize( $this );

        return $this;
    }

    /**
     * Check if there are any actions that must match a permission
     *
     * @return bool
     */
    private function restrictedAction()
    {
        if (method_exists( $this->subject, 'restrictedActions' )) {
            if (in_array( $this->action, $this->subject->restrictedActions() )) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return null
     */
    public function getRequester()
    {
        return $this->requester;
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

    /**
     * @return boolean
     */
    public function hasPermission()
    {
        return $this->hasPermission;
    }

    /**
     * @param boolean $authorized
     */
    public function setAuthorized($authorized)
    {
        if (is_bool( $authorized )) {
            $this->authorized = $authorized;
        }
    }
}