<?php

namespace MyFamily\DBLogger\Http;

use Illuminate\Http\Request;
use MyFamily\Http\Controllers\ApiController;

use MyFamily\DBLogger\DBExplorer;
use MyFamily\DBLogger\DBLogger;
use MyFamily\Http\Requests;

class DatabaseLogController extends ApiController
{
    protected $logger;

    public function __construct( DBExplorer $logger, DBLogger $scribe )
    {
        $this->scribe = $scribe;
        $this->logger = $logger;
    }

    public function getIndex()
    {
        $dataset = $this->logger->getMetaInfo();
        $requests = $this->logger->listURIs( 200 )->toArray()['data'];
        $queries = $this->logger->listQueries( 200 )->toArray()['data'];
        return view('admin.dashboard', [
            'meta' => $dataset['data'],
            'requests'  => $requests,
            'queries'   => $queries
        ]);
    }

    public function getRequest( $id )
    {
        if ( !is_numeric( $id ) ) {
            return $this->respondBadRequest( 'ID not provided' );
        }

        return $this->respondWithArray( [ 'data' => $this->logger->getRequest( $id, true )->toArray() ] );
    }

    public function getUri(/*,...*/ )
    {
        $uri = '/' . implode( '/', func_get_args() );
        $requests = $this->logger->getRequestByUri( $uri, $_GET )->toArray();
        return view('admin.request', ['requests' => $requests] );
    }

    public function getSlowUris()
    {
        return $this->respondWithArray( $this->logger->listURIs( 200 )->toArray() );
    }

    public function getSlowQueries()
    {
        return $this->respondWithArray( $this->logger->slowQueries()->toArray() );
    }

    public function getRequestByQueryCount()
    {
        return $this->respondWithArray( $this->logger->requestByQueryCount()->toArray() );
    }

    public function getRequestsOverTime()
    {
        return $this->respondWithArray( $this->logger->averageRequestLengthOverTime()->toArray() );
    }

    public function getCommonQueries()
    {
        return $this->respondWithArray( $this->logger->listQueries( 200 )->toArray() );
    }

    public function getMeta()
    {
        return $this->respondWithArray( $this->logger->getMetaInfo() );
    }

    public function deleteClear( DBLogger $log )
    {
        $log->clear();
    }
}
