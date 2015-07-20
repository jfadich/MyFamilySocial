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

        app()->router->bind( 'photo', function ($id) {
            return Pictures::photos()->findPhoto( $id );
        } );

        \MyFamily\Photo::saved( function ( $photo ) {
            if ( $photo->imageable_type === \MyFamily\User::class && $photo->imageable->profile_picture != $photo->id ) {
                $photo->imageable->updateProfilePicture( $photo );
            }
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
            return app( PicturesService::class );
        } );
    }

}
