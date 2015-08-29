<?php

namespace MyFamily\DBLogger;

use Illuminate\Database\Eloquent\Model;
use MyFamily\DBLogger\Request;

class Query extends Model
{
    public $table = 'db_logger_queries';

    public $guarded = [ 'id' ];

    public function request()
    {
        return $this->belongsTo( Request::class );
    }
}
