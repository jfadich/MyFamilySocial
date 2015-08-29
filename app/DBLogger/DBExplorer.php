<?php

namespace MyFamily\DBLogger;

class DBExplorer
{
    public function listRequests()
    {
        return Request::with( 'queries' )->all();
    }

    public function listQueries()
    {
        return Queries::with( 'request' )->all();
    }

    public function listRequestsByQueryCount()
    {
        //return Request::
    }
}