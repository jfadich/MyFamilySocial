<?php namespace MyFamily;

class JsonSettings
{
    protected $model;

    protected $settings = [ ];

    public function __construct( Model &$model, $field )
    {
        if ( !property_exists( $model, 'json_field' ) ) {
            throw new Exception( 'json_field is not set.' );
        }

        $this->field    = $field;
        $this->settings = $model->{$field};
        $this->model    = $model;
    }

    public function merge( array $attributes )
    {
        $this->settings = arrage_merge(
            $this->settings,
            array_only( $attributes, array_keys( $this->settings ) )
        );

        $this->persist();
    }

    public function get( $key, $default = null )
    {
        return array_get( $this->settings, $key, $default );
    }

    public function set( $key, $value )
    {
        $this->settings[ $key ] = $value;

        $this->persist();
    }

    public function has( $key )
    {
        return array_key_exists( $key, $this->settings );
    }

    public function all()
    {
        return $this->settings;
    }

    protected function persist()
    {
        $this->model->update( [ $this->field => $this->settings ] );
    }

}