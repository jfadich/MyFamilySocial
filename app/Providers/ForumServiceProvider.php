<?php namespace MyFamily\Providers;

use MyFamily\Repositories\ForumCategoryRepository;
use MyFamily\Repositories\ThreadRepository;
use MyFamily\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;
use MyFamily\Services\ForumService;
use Forum;

class ForumServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \MyFamily\Comment::saved( function ( $comment ) {
            if ( $comment->commentable_type === \MyFamily\ForumThread::class ) {
                $comment->commentable->last_reply = time();
                $comment->commentable->save();
            }
        } );
    }

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

}
