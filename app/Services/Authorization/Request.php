<?php namespace MyFamily\Services\Authorization;

use MyFamily\User;

class Request
{
    private $action = '';
    private $subject = null;
    private $requester = null;
    private $authorized = false;
    private $hasPermission = false;

    function __construct($action, $requester, $subject)
    {
        $this->action    = $action;
        $this->requester = $requester;
        $this->subject   = $subject;
    }

    public function checkPermission()
    {
        if ($this->requester->role->permissions()->where( 'name', '=', $this->action )->count() > 0) {
            $this->authorized    = true;
            $this->hasPermission = true;
        }

        return $this;
    }

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
        }

        return $this;
    }

    public function authorizeSubject()
    {
        if (method_exists( $this->subject, 'authorize' )) {
            return $this->subject->authorize( $this );
        }

        return $this;
    }

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