<?php namespace MyFamily\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

abstract class ApiController extends BaseController {

    protected $statusCode = 200;

    private $fractal;

    protected $availableIncludes = [];

    protected $eagerLoad = [];

    function __construct(Manager $fractal, Request $request)
    {
        $this->fractal = $fractal;

        if(isset($this->availableIncludes) && $request->has('with'))
        {
            $this->eagerLoad = $this->validateIncludes($request->get('with'));
        }

        $this->fractal->parseIncludes( $this->eagerLoad );
    }

    private function validateIncludes($includes)
    {
        return array_keys(array_intersect($this->availableIncludes, explode(',',$includes)));
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function respond($data, $headers = [])
    {
        return response($data, $this->getStatusCode(), $headers);
    }

    protected function respondWithItem($item, $callback, $meta = [])
    {
        $resource = new Item($item, $callback);

        if(!empty($meta))
        {
            foreach($meta as $k => $v)
            {
                $resource->setMetaValue($k, $v);
            }
        }

        $data = $this->fractal->createData($resource);

        return $this->respondWithArray($data->toArray());
    }

    protected function respondWithCollection(LengthAwarePaginator $collection, $callback)
    {
        $resource = new Collection($collection->all(), $callback);
        $resource->setPaginator(new IlluminatePaginatorAdapter($collection));

        $data = $this->fractal->createData($resource);

        return $this->respondWithArray($data->toArray());
    }

    protected function respondWithArray(array $array, array $headers = [])
    {
           return response()->json($array, $this->getStatusCode(), $headers);
    }

    protected function respondWithError($message)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for erroring on a 200...",
                E_USER_WARNING
            );
        }

        return $this->respond([
            'error' => [
                'message' => $message,
                'http_code' => $this->getStatusCode(),
            ]
        ]);
    }

    protected function respondNotFound($message = 'Resource not found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

}
