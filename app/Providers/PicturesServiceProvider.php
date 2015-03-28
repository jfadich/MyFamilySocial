<?php namespace MyFamily\Providers;

use Illuminate\Support\ServiceProvider;
use MyFamily\Repositories\AlbumRepository;
use MyFamily\Repositories\PhotoRepository;
use MyFamily\Repositories\TagRepository;
use MyFamily\Services\PicturesService;
use Pictures;

class PicturesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bind parameters for route-model binding
        app()->router->bind( 'album', function ($slug) {
            return Pictures::albums()->getAlbum( $slug, true );
        } );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( 'pictures', function () {
            return new PicturesService( new PhotoRepository, new AlbumRepository( new TagRepository() ) );
        } );
    }

}
