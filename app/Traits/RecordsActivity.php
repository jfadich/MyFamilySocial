<?php namespace MyFamily\Traits;

use MyFamily\Activity;

trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event( function ($model) use ($event) {
                $model->recordActivity( $event );
            } );
        }
    }

    protected static function getModelEvents()
    {
        if (isset( static::$recordEvents )) {
            return static::$recordEvents;
        }

        return ['created'];
    }

    protected function getActivityName($model, $action)
    {
        $name = strtolower( ( new \ReflectionClass( $model ) )->getShortName() );

        return "{$action}_{$name}";
    }

    public function recordActivity($event)
    {
        Activity::create( [
            'owner_id'     => $this->owner_id,
            'subject_id'   => $this->id,
            'subject_type' => get_class( $this ),
            'name'         => $this->getActivityName( $this, $event )
        ] );
    }
}