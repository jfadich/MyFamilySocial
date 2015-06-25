<?php namespace MyFamily\Services\Authorization;

use MyFamily\Exceptions\AuthorizationException;
use MyFamily\User;
use Symfony\Component\Config\Definition\Exception\Exception;

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
     * @throws AuthorizationException
     */
    function __construct($action, $requester, $subject)
    {
        $this->action = \MyFamily\Permission::where( 'name', '=', $action )->first();
        $this->requester = $requester;
        $this->subject = $subject;

        if ( $this->action === null ) {
            throw new AuthorizationException( "'$action' is not a valid permission" );
        }
    }

    /**
     * Check if requester is granted permission
     *
     * @param null $action
     * @return $this
     * @throws AuthorizationException
     */
    public function checkPermission( $action = null )
    {
        if ( $action === null )
            $action = $this->action;
        else
            $action = \MyFamily\Permission::where( 'name', '=', $action )->first();

        if ( $this->action === null ) {
            throw new AuthorizationException( "'$action' is not a valid permission" );
        }

        if ( in_array( $action->name, $this->requester->role->permissions->lists( 'name' )->toArray() ) ) {
            $this->authorized    = true;
            $this->hasPermission = true;
        } else {
            $this->hasPermission = false;
            $this->authorized    = false;
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
        if ( !$this->action->subject_bound )
            return $this;

        $owner = false;

        if ($this->subject instanceof User) {
            $owner = $this->subject->id === $this->requester->id;
        } else {
            $owner = $this->subject->owner_id === $this->requester->id;
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
        if ( !$this->action->subject_bound )
            return $this;

        if ( method_exists( $this->subject, 'authorize' ) ) {
            $request = $this->subject->authorize( $this );

            if ( !$request instanceof Request ) {
                throw new Exception( 'Model authorization must return an instance of MyFamily\Services\Authorization\Request' );
            }

            return $request;
        }

        return $this;
    }

    /**
     * Check if there are any actions that must match a permission
     *
     * @return bool
     */
    private function restrictedAction()
    {
        if ( !$this->action->subject_bound )
            return $this;

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