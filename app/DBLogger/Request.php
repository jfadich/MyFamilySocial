<?php

namespace MyFamily\DBLogger;

use Illuminate\Database\Eloquent\Model;
use MyFamily\DBLogger\Query;

class Request extends Model
{
    public $table = 'db_logger_requests';

    public $guarded = [ 'id' ];

    public function queries()
    {
        return $this->hasMany( Query::class );
    }

    public function queryCount()
    {
        return $this->hasOne( Query::class )
            ->selectRaw( 'request_id,count(*) as queryCount' )
            ->groupBy( 'request_id' );
    }

    public function getQueryCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if ( !$this->relationLoaded( 'queryCount' ) ) {
            $this->load( 'queryCount' );
        }

        $related = $this->getRelation( 'commentsCount' );
        dd( $related );

        // then return the count directly
        return ( $related ) ? (int)$related->queryCount : 0;
    }
}
