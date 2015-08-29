<?php

namespace MyFamily\DBLogger;

use DB;

class DBExplorer
{
    /**
     * Requests grouped by method/uri and sorted by the average execution time across all queries
     *
     * @return mixed
     */
    public function slowUris()
    {
        return Request::select( DB::raw( 'uri,method,avg(total_time) as average_time' ) )
            ->groupBy( 'method' )
            ->groupBy( 'uri' )
            ->orderBy( 'average_time', 'desc' )
            ->get();
    }

    /**
     *
     *
     * @return mixed
     */
    public function averageRequestLengthOverTime()
    {
        return Request::select( DB::raw( 'created_at as date,avg(total_time) as avg_time' ) )
            ->latest()
            ->groupBy( DB::raw( 'date(created_at)' ) )->get();
    }

    public function requestByQueryCount()
    {
        return Query::select( DB::raw( 'r.uri,r.parameters,r.method,r.total_time,count(request_id) as q_count' ) )
            ->groupBy( 'request_id' )
            ->join( 'db_logger_requests as r', 'request_id', '=', 'r.id' )
            ->orderBy( 'total_time', 'desc' )
            ->get();
    }
}