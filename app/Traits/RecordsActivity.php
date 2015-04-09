<?php namespace MyFamily\Traits;

use MyFamily\Activity;

trait RecordsActivity
{
    protected $target = [];

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

        if(!is_null($this->target['type']))
        {
            $target_name = explode('\\',$this->target['type']);
            $target_name = strtolower($target_name[1]);
            $name .= '_'.$target_name;
        }

        return "{$action}_{$name}";
    }

    public function recordActivity($event)
    {
        if (method_exists( $this, 'getActivityTarget' )) {
            $this->target = $this->getActivityTarget();
        } else {
            $this->target[ 'id' ]   = null;
            $this->target[ 'type' ] = null;
        }

        $activity = [
            'owner_id'     => $this->owner_id,
            'subject_id'   => $this->id,
            'subject_type' => get_class( $this ),
            'target_id'    => $this->target[ 'id' ],
            'target_type'  => $this->target[ 'type'],
            'name'         => $this->getActivityName( $this, $event )
        ];

        if (method_exists( $this, 'getTarget' )) {
            $target                    = $this->getTarget();
            $activity[ 'target_type' ] = $target[ 'type' ];
            $activity[ 'target_id' ]   = $target[ 'id' ];
        }

        Activity::create( $activity );

    }
}