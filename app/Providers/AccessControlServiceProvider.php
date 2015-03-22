<?php namespace MyFamily\Providers;

use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\ThreadRepository;
use MyFamily\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;
use MyFamily\Services\AccessControl;
use MyFamily\Services\ForumService;
use Forum;

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
