<?php

namespace MyFamily\DBLogger;

use DB;

class DBExplorer
{
    public function listQueries( $count = null )
    {
        return Query::selectRaw( 'query,count(*) as query_count,round(avg(time) * 1000) as average_microseconds' )
            ->groupBy( 'query' )
            ->orderBy( 'query_count', 'desc' )
            ->paginate( $count );
    }

    public function listURIs( $count = null )
    {
        return Request::selectRaw( 'uri,method,round(avg(sql_time)) as average_milliseconds,count(*) as total_requests' )
            ->groupBy( 'method' )
            ->groupBy( 'uri' )
            ->orderBy( 'average_milliseconds', 'desc' )
            ->paginate( $count );
    }

    public function getRequest( $id, $withQueries = false )
    {
        if ( $withQueries ) {
            $request = Request::with( [ 'queries' ] );
        } else {
            $request = Request;
        }

        $request->groupBy( 'parameters' )->find( $id );

        if ( !$request ) {
            return false;
        }

        $request->request_time = round( $request->request_time, 2 );

        return $request;
    }

    public function getRequestByUri( $uri, $parameters = null )
    {
        $request = Request::with( [ 'queries' ] )->selectRaw( "uri,parameters,ROUND(AVG(sql_time),2) as average_sql_time, COUNT('*') as request_total" );
        if ( is_array( $parameters ) && !empty( $parameters ) ) {
            $request->where( 'parameters', $parameters );
        }

        return $request->groupBy( 'parameters' )->where( 'uri', '=', $uri )->get();;
    }

    public function getMetaInfo()
    {
        $data = [ ];

        $data = Request::selectRaw( 'count(*) as request_count,round(avg(request_time),2) as average_request_time,round(avg(sql_time),2) as average_sql_time' )
            ->first()->toArray();

        $data[ 'query_count' ] = Query::count();
        //$data['request_count'] = DB::table('db_logger_requests')->count();
        //$data['average_request_time'] = round(DB::table('db_logger_requests')->avg('request_time'), 2);
        //$data['average_sql_time'] = round(DB::table('db_logger_requests')->avg('sql_time'), 2);
        return [ 'data' => $data ];
    }

    /**
     * Requests grouped by method/uri and sorted by the average execution time across all queries
     *
     * @return mixed
     */
    public function slowUris()
    {
        return Request::select( DB::raw( 'uri,method,avg(total_time) as average_time,count(*) as total_requests' ) )
            ->groupBy( 'method' )
            ->groupBy( 'uri' )
            ->orderBy( 'average_time', 'desc' )
            ->paginate(200);
    }

    public function slowQueries()
    {
        return Query::select( DB::raw( 'query, avg(time) as average_time,count(*) as total_queries' ) )
            ->groupby( 'query' )
            ->orderBy( 'average_time', 'desc' )
            ->paginate(200);
    }

    /**
     *
     *
     * @return mixed
     */
    public function averageRequestLengthOverTime()
    {
        return Request::select( DB::raw( 'created_at as date,avg(total_time) as average_time,count(*) as total_requests' ) )
            ->latest()
            ->groupBy( DB::raw( 'date(created_at)' ) )
            ->paginate(200);
    }

    public function requestByQueryCount()
    {
        return Query::select( DB::raw( 'r.uri,r.parameters,r.method,r.total_time,count(request_id) as q_count' ) )
            ->groupBy( 'request_id' )
            ->join( 'db_logger_requests as r', 'request_id', '=', 'r.id' )
            ->orderBy( 'total_time', 'desc' )
            ->paginate(200);
    }
}