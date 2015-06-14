<?php namespace MyFamily\Presenters;

use MyFamily\Exceptions\PresenterException;

abstract class Presenter
{
    protected $entity;

    private $actionPaths = [];

    function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param string $action
     * @param null $parameters
     * @return string
     * @throws PresenterException
     */
    protected function generateUrl($action = 'show', $parameters = null)
    {
        if (isset( $this->actionPaths )) {
            if (!is_string( $action )) {
                throw new PresenterException( 'Unable to generate url. Invalid action requested; String expected.' );
            }

            if (array_key_exists( $action, $this->actionPaths )) {
                return action( $this->actionPaths[ $action ], $parameters );
            }

        } else {
            throw new PresenterException( 'Unable to generate url. Action paths not set for model presenter.' );
        }
    }

    /**
     * Set the controller routes and action names to be used to generate URLs
     *
     * @param $action
     * @param null $path
     */
    protected function setActionPaths($action, $path = null)
    {
        if (is_array( $action )) {
            $this->actionPaths = array_merge( $this->actionPaths, $action );
        } elseif ( is_string( $action ) && $path !== null ) {
            $this->actionPaths[ $action ] = $path;
        }
    }

    /**
     * When a property is referenced search for the associated method on the presenter
     * If it doesn't exist defer to the model
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists( $this, $property ))
            return $this->{$property}();

        return $this->entity->{$property};
    }
}