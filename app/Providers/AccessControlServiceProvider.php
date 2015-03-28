<?php namespace MyFamily\Providers;

use Illuminate\Support\ServiceProvider;
use MyFamily\Services\Authorization\AccessControl;

class AccessControlServiceProvider extends ServiceProvider
{

    /**
     * Register the forum service and compose the views
     *
     * This service provider constructs the ForumService object.
     * It also prepares data for use in the forum views.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( 'accessControl', function () {
            return new AccessControl;
        } );
    }

}
