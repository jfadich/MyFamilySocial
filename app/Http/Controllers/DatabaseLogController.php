<?php

namespace MyFamily\Http\Controllers;

use Illuminate\Http\Request;

use MyFamily\DBLogger\DBExplorer;
use MyFamily\DBLogger\DBLogger;
use MyFamily\Http\Requests;

class DatabaseLogController extends ApiController
{
    protected $logger;

    public function __construct( DBExplorer $logger )
    {
        $this->logger = $logger;
    }

    public function getSlowUris()
    {
        return $this->respondWithArray( $this->logger->slowUris()->toArray() );
    }

    public function getRequestByQueryCount()
    {
        return $this->respondWithArray( $this->logger->requestByQueryCount()->toArray() );
    }

    public function getRequestsOverTime()
    {
        return $this->respondWithArray( $this->logger->averageRequestLengthOverTime()->toArray() );
    }

    public function deleteClear( DBLogger $log )
    {
        $log->clear();
    }
}
