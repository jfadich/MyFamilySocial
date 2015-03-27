<?php namespace MyFamily\Presenters;

use MyFamily\Exceptions\PresenterException;

abstract class Presenter
{
    protected $date_format = 'm/d/Y';

    protected $entity;

    private $actionPaths = [];

    function __construct($entity)
    {
        $this->entity = $entity;
    }


    /**
     * Generate a html link to this entity
     *
     * @param $title
     * @param string $action
     * @param array $parameters
     * @param null $attributes
     * @return string
     * @throws PresenterException
     */
    public function link($title, $action = 'show', $parameters = array(), $attributes = null)
    {
        if (method_exists( $this, 'url' )) {
            return link_to( $this->url( $action, $parameters ), $title, $attributes );
        }

        throw new PresenterException( 'Unable to generate link. URL() not set.' );
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
        } elseif (is_string( $action ) && !is_null( $path )) {
            $this->actionPaths[ $action ] = $path;
        }
    }

    /**
     * Format the updated_at date to a relative date unless older than 40 days
     *
     * @param null $format
     * @param bool $forceAbsolute
     * @return mixed
     */
    public function updated_at($format = null, $forceAbsolute = false)
    {
        $daysBeforeAbsolute = 40;
        $updated            = $this->entity->updated_at;

        if (is_null( $format )) {
            $format = $this->date_format;
        }

        if ($updated->diffInDays() < $daysBeforeAbsolute || $forceAbsolute) {
            return $updated->diffForHumans();
        }

        return $updated->format( $format );

    }

    /**
     * Present the date on the entity in the given format
     *
     * @param $date_field
     * @param null $format
     * @return mixed
     */
    protected function presentDate($date_field, $format = null)
    {
        if (is_null( $format )) {
            $format = $this->date_format;
        }

        return $this->entity->{$date_field}->format( $format );
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

        if (in_array( $property, $this->entity->getDates() ))
            return $this->presentDate($property);

        return $this->entity->{$property};
    }

    /**
     * If a property is referenced and there is no presenter method, check if the property is a date
     * if so sent it to presentDate()
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (in_array( $method, $this->entity->getDates() ))
            return $this->presentDate( $method, $arguments);
    }
}