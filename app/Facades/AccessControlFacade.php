<?php namespace MyFamily\Facades;

use Illuminate\Support\Facades\Facade;

class AccessControlFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'accessControl';
    }

}