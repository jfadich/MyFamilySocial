<?php

namespace MyFamily\Http\Controllers;

use MyFamily\Transformers\RoleTransformer;
use Illuminate\Http\Request;
use MyFamily\Http\Requests;
use League\Fractal\Manager;
use MyFamily\Role;

class RolesController extends ApiController
{
    function __construct( RoleTransformer $roleTransformer, Manager $fractal, Request $request )
    {
        parent::__construct( $fractal, $request );
        $this->roleTransformer = $roleTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @internal param RoleTransformer $roleTransformer
     */
    public function index()
    {
        return $this->respondWithCollection( Role::all(), $this->roleTransformer );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show( $id )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update( $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy( $id )
    {
        //
    }
}
