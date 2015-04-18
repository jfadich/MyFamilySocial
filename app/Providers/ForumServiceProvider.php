<?php namespace MyFamily\Providers;

use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\ThreadRepository;
use MyFamily\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;
use MyFamily\Services\ForumService;
use Forum;

class ForumServiceProvider extends ServiceProvider {

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
        $this->app->bind('forum', function()
        {
            return new ForumService(new ThreadRepository(new TagRepository()),new ForumCategoryRepository);
        });
    }

    public function boot()
    {
        // Bind parameters for route-model binding
        app()->router->bind( 'thread', function ($slug) {
            return Forum::threads()->getThread( $slug );
        } );

        app()->router->bind( 'category', function ($slug) {
            return Forum::categories()->getCategory( $slug );
        } );
    }

}
