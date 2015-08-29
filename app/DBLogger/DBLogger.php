<?php

namespace MyFamily\DBLogger;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request as HtttpRequest;
use DB;

class DBLogger
{
    protected $protectedPaths = [ '/auth/login' ];

    public function clear()
    {
        DB::table( 'db_logger_queries' )->truncate();
        DB::table( 'db_logger_requests' )->truncate();
    }

    public function log( $queries, HtttpRequest $httpRequest )
    {
        if ( in_array( $httpRequest->getRequestUri(), $this->protectedPaths ) ) {
            $params = '"[protected]"';
        } else {
            $params = $this->getParameters( $httpRequest );
        }

        $request = Request::create( [
            'uri'        => $httpRequest->getRequestUri(),
            'parameters' => $params,
            'method'     => $httpRequest->method(),
            'total_time' => array_sum( array_column( $queries, 'time' ) )
        ] );

        foreach ( $queries as $log ) {
            $request->queries()->create( [
                    'params' => json_encode( $log[ 'bindings' ] ),
                    'query'  => $log[ 'query' ],
                    'time'   => $log[ 'time' ]
                ]
            );
        }
    }

    public function getParameters( $request )
    {
        $params = $request->all();

        foreach ( $params as &$param ) {
            if ( $param instanceof UploadedFile ) {
                $file                   = [ ];
                $file[ 'originalName' ] = $param->getClientOriginalName();
                $file[ 'size' ]         = $param->getSize();
                $file[ 'mime' ]         = $param->getMimeType();
                $param                  = $file;
            }
        }

        return json_encode( $params );
    }

}