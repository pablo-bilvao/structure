<?php

namespace Structure\Basic\Provider;

use Illuminate\Support\ServiceProvider;
use Structure\Basic\Services\Structure;

class AppServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        
        $this->app->singleton('structure', function($app){
            return new Structure;
        });

        app('structure')->createMicroserviceConfigFile();
        
        ######################### SERVICES ############################
        $path_services     = config('microservices.path_services');
        $path_repositories = config('microservices.path_repositories');
        $services          = config('microservices.services');
        
        foreach ($services as $key => $object) {            
            $service = $path_services.$object['name'];
            $key     = strtolower( app('structure')->transformNameService($key) );
            
            if( $object['repository'] ){
                $repository = $path_repositories.$object['repository'];
                $this->app->singleton($key, function($app) use($service, $repository){
                    return new $service( app($repository) );
                });
            }
            else{
                $this->app->singleton($key, function($app) use($service){
                    return new $service;
                });
            }

        }
        ################################################################
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        //
    }
}
