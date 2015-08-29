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
}
