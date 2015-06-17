<?php

namespace MyFamily\Http\Middleware;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Closure;
use DB;
use Log;

class LogDatabaseQueries
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
            return $next( $request );
        }

        DB::enableQueryLog();

        // Use separate log file for database queries
        Log::getMonolog()->pushHandler( new StreamHandler( storage_path( 'logs/db.log' ), Logger::DEBUG, false ) );

        $response = $next( $request );

        foreach ( DB::getQueryLog() as $log ) {
            Log::debug( $log[ 'query' ], [ 'bindings' => $log[ 'bindings' ], 'time' => $log[ 'time' ] ] );
        }

        return $response;
    }
}
