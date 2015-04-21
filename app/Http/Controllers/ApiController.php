<?php namespace MyFamily\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use JWTAuth;
use MyFamily\Traits\RespondsWithJson;

abstract class ApiController extends BaseController {

    use RespondsWithJson;

    private $fractal;

    protected $availableIncludes = [];

    protected $eagerLoad = [];

    function __construct(Manager $fractal, Request $request)
    {
        $this->middleware('auth');

        $this->fractal = $fractal;

        if(!empty($this->availableIncludes) && $request->has('with'))
        {
            $this->eagerLoad = $this->validateIncludes($request->get('with'));
        }

        $this->fractal->parseIncludes( $this->eagerLoad );
    }

    private function validateIncludes($includes)
    {
        return array_keys(array_intersect($this->availableIncludes, explode(',',$includes)));
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

    protected function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection->all(), $callback);

        if($collection instanceof LengthAwarePaginator)
            $resource->setPaginator(new IlluminatePaginatorAdapter($collection));

        $data = $this->fractal->createData($resource);

        return $this->respondWithArray($data->toArray());
    }

}
