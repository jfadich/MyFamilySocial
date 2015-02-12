<?php namespace MyFamily\Providers;

use Illuminate\Support\ServiceProvider;
use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\TagRepository;
use MyFamily\Repositories\ThreadRepository;
use MyFamily\Services\ForumService;

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
        view()->composer('forum._forumnav', function($view)
        {
            $view->with('categories', \Forum::categories()->getCategories());
        });
        view()->composer('forum._threadForm', function($view)
        {
            $view->with('categories', \Forum::categories()->getCategories());
        });
    }

}
