<?php namespace MyFamily\Providers;

use Illuminate\Support\ServiceProvider;
use MyFamily\Repositories\PhotoRepository;
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

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( 'pictures', function () {
            return new PicturesService( new PhotoRepository );
        } );
    }

}
