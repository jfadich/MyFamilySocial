<?php namespace MyFamily\Traits;

use MyFamily\JsonSettings as Settings;
use Exception;

trait JsonSettings
{
    protected $settingsInstance = null;

    public function settings( $key = null, $default = null )
    {
        if ( $this->json_field === null ) {
            throw new Exception( 'json_field is not set.' );
        }

        if ( $this->settingsInstance === null ) {
            $this->settingsInstance = new Settings( $this, $this->json_field );
        }

        if ( $key !== null ) {
            return $this->settingsInstance->get( $key, $default );
        }

        return $this->settingsInstance;
    }

}