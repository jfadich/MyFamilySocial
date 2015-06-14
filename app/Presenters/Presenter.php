<?php namespace MyFamily\Presenters;

use MyFamily\Exceptions\PresenterException;
use MyFamily\Model;

abstract class Presenter
{
    protected $entity;

    protected $actionPaths = [ ];

    /**
     * @param Model $entity
     */
    function __construct( Model $entity )
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