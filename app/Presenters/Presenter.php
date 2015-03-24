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

    public function link($title, $action = 'show', $attributes = null)
    {
        $parameters = '';
        if (!is_null( $attributes )) {
            $attributes = $this->getAttributeString( $attributes );
        }

        if (is_array( $action )) {
            $parameters = $action[ 'parameters' ];
            $action     = $action[ 'action' ];
        }
        if (method_exists( $this, 'url' )) {
            return "<a href=\"{$this->url($action, $parameters)}\"{$attributes}>{$title}</a>";
        }

        throw new PresenterException( 'Unable to generate link. URL() not set.' );
    }

    protected function generateUrl($action = 'show', $parameters = null)
    {
        if (isset( $this->actionPaths )) {
            if (array_key_exists( $action, $this->actionPaths )) {
                return action( $this->actionPaths[ $action ], $parameters );
            }
        } else {
            throw new PresenterException( 'Unable to generate url. Action paths not set for model presenter.' );
        }

        throw new PresenterException( 'Unable to generate url. Invalid action request given.' );

    }

    protected function setActionPaths($action, $path = null)
    {
        if (is_array( $action )) {
            $this->actionPaths = array_merge( $this->actionPaths, $action );
        } elseif (is_string( $action ) && !is_null( $path )) {
            $this->actionPaths[ $action ] = $path;
        }
    }

    protected function presentDate($date_field, $format = null)
    {
        if (is_null( $format )) {
            $format = $this->date_format;
        }

        return $this->entity->{$date_field}->format( $format );

        throw new PresenterException( "Unable to format date {$date_field}" );
    }

    protected function getAttributeString($attributes)
    {
        $attribute_string = ' ';

        if (is_array( $attributes )) {
            foreach ($attributes as $key => $value) {
                $attribute_string .= $key . '="' . $value . '" ';
            }
        } else {
            throw new PresenterException( "Expected attribute array {gettype($attributes)}" );
        }

        return $attribute_string;
    }
    public function __get($property)
    {
        if (method_exists( $this, $property ))
            return $this->{$property}();

        if (in_array( $property, $this->entity->getDates() ))
            return $this->presentDate($property);

        return $this->entity->{$property};
    }

    public function __call($method, $arguments)
    {
        if (in_array( $method, $this->entity->getDates() ))
            return $this->presentDate( $method, $arguments);
    }
}