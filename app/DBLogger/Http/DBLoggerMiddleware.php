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
        if ( !$this->shouldLog( $request ) ) {
            return $next( $request );
        }

        DB::enableQueryLog();

        return $next( $request );
    }

    public function terminate( $request, $response )
    {
        if ( !$this->shouldLog( $request ) ) {
            return;
        }

        $logger = new DBLogger();

        $logger->log( DB::getQueryLog(), $request );
    }

    private function shouldLog( $request )
    {
        if ( $request->method() == 'OPTIONS' || !env( 'DB_LOG', false ) ) {
            return false;
        }

        return true;
    }

}