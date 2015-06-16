<?php

namespace MyFamily\Http\Middleware;

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

        $response = $next( $request );

        $queries = 0;
        $time    = 0;
        foreach ( DB::getQueryLog() as $log ) {
            Log::debug( $log[ 'query' ], [ 'bindings' => $log[ 'bindings' ], 'time' => $log[ 'time' ] ] );
            $queries++;
            $time += $log[ 'time' ];
        }

        Log::debug( 'Request Total: ' . $queries . ' queries and took ' . $time . ' milliseconds' );

        return $response;
    }
}
