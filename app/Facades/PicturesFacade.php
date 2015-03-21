<?php namespace MyFamily\Facades;

use Illuminate\Support\Facades\Facade;

class PicturesFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'pictures';
    }

}