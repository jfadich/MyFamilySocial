<?php

namespace MyFamily\DBLogger;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request as HttpRequest;
use DB;

class DBLogger
{
    protected $protectedPaths = [ '/auth/login' ];

    public function clear()
    {
        DB::table( 'db_logger_requests' )->truncate();
        DB::table( 'db_logger_queries' )->truncate();
    }

    public function log( $queries, HttpRequest $httpRequest )
    {
        if ( strpos( $httpRequest->getRequestUri(), '/debug/db' ) !== false ) {
            return;
        }

        $uri = explode( '?', $httpRequest->getRequestUri() )[ 0 ];

        if ( in_array( $uri, $this->protectedPaths ) ) {
            $params = '"[protected]"';
        } else {
            $params = $this->getParameters( $httpRequest );
        }

        $request = Request::create( [
            'uri' => $uri,
            'parameters' => $params,
            'method'     => $httpRequest->method(),
            'sql_time'   => array_sum( array_column( $queries, 'time' ) ),
            'request_time' => ( microtime( true ) - LARAVEL_START)
        ] );
;
        foreach ( $queries as $log ) {
            if ( strpos( $log[ 'query' ], 'db_logger_requests' ) !== false || strpos( $log[ 'query' ],
                    'db_logger_queries' ) !== false
            ) {
                continue;
            }

            $data[] = [
                    'params' => json_encode( $log[ 'bindings' ] ),
                    'query'  => $log[ 'query' ],
                    'time'   => $log[ 'time' ],
                    'request_id' => $request->id,
                    'created_at' => date( "Y-m-d H:i:s" ),
                    'updated_at' => date( "Y-m-d H:i:s" )
            ];
        }

        Query::insert( $data);
    }

    public function getParameters( )
    {
        return json_encode( $_GET );
    }

    private function getApplicationHash()
    {
        return $this->hashDirectory( app_path() ) . '.' . $this->hashDirectory( database_path( 'migrations' ) );
    }

    /**
     * Generate an MD5 hash string from the contents of a directory.
     *
     * @param string $directory
     * @return boolean|string
     */
    private function hashDirectory( $directory )
    {
        if ( !is_dir( $directory ) ) {
            return false;
        }

        $files = array();
        $dir   = dir( $directory );

        while ( false !== ( $file = $dir->read() ) ) {
            if ( $file != '.' and $file != '..' ) {
                if ( is_dir( $directory . '/' . $file ) ) {
                    $files[] = hashDirectory( $directory . '/' . $file );
                } else {
                    $files[] = md5_file( $directory . '/' . $file );
                }
            }
        }

        $dir->close();

        return md5( implode( '', $files ) );
    }

}