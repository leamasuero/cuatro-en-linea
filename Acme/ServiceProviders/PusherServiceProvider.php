<?php namespace Acme\ServiceProviders;

use Pusher;
//use Config;
use Illuminate\Support\ServiceProvider;

class PusherServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Pusher', function($app)
        {
//            dd(getenv('API_ID'));
//            return new Pusher(Config::get('pusher.key'),Config::get('pusher.secret'),Config::get('pusher.api_id'));
            return new Pusher(getenv('KEY'),  getenv('SECRET'),  getenv('APP_ID'));
            
//            new Pusher($app_key, $app_secret, $app_id);
        });
    }

}