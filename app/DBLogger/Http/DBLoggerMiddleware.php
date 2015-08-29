<?php

namespace MyFamily\DBLogger\Http;

use DB;
use Closure;
use MyFamily\DBLogger\DBLogger;

class DBLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        if ( !env( 'DB_LOG', false ) ) {
            //    return $next( $request );
        }

        DB::enableQueryLog();

        return $next( $request );
    }

    public function terminate( $request, $response )
    {
        $logger = new DBLogger(); // TODO

        $logger->log( DB::getQueryLog(), $request );
    }
}