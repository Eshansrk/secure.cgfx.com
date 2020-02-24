<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */



    
    protected $namespace = 'App\Http\Controllers';
    protected $frontEndNamespace = 'App\Http\Controllers\FrontEnd';
    protected $backEndNamespace = 'App\Http\Controllers\BackEnd';
    protected $APINamaespace = 'App\Http\Controllers\API';
    
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        // config(['app.url' => config('app.url').'/'.app()->getLocale()]);

        // dd(config('app.url'));
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        // custom route functions for all the routes in front end
        $this->mapFrontEndRoutes();

        // custom route functions for all the routes in Back end
        $this->mapBackEndRoutes();

        $this->mapApiRoutes();

        // $this->setAppLocale();
    }

    /**
     * Define the "Front End" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapFrontEndRoutes()
    {

        $rootFolder = app()->getLocale();
        
        Route::group([
            'middleware' => 'frontEnd',
            'namespace' => $this->frontEndNamespace,
            ], function ($router) {
                require base_path('routes/frontEnd.php');
            });
    }

    /**
     * Define the "Back End" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapBackEndRoutes()
    {
        $rootFolder = app()->getLocale(); 

        Route::group([
            'middleware' => 'frontEnd',
            'namespace' => $this->backEndNamespace.'\\'.$rootFolder,
            ], function ($router) {
                require base_path('routes/backEnd.php');
            });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
            ], function ($router) {
                require base_path('routes/web.php');
            });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->APINamaespace,
            'prefix' => 'api',
            ], function ($router) {
                require base_path('routes/api.php');
            });
    }

}
