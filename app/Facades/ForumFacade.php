<?php namespace MyFamily\Facades;

use Illuminate\Support\Facades\Facade;

class ForumFacade extends Facade {

protected static function getFacadeAccessor() { return 'forum'; }

}