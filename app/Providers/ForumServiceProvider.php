<?php namespace MyFamily\Providers;

use Illuminate\Support\ServiceProvider;
use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\TagRepository;
use MyFamily\Repositories\ThreadRepository;
use MyFamily\Services\ForumService;

class ForumServiceProvider extends ServiceProvider {

    /**
     * Overwrite any vendor / package configuration.
     *
     * This service provider is intended to provide a convenient location for you
     * to overwrite any "vendor" or package configuration that you may want to
     * modify before the application handles the incoming request / command.
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

}
