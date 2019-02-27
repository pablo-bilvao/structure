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
        $path_services     = config('microservices.paths.services');
        $path_contracts    = config('microservices.paths.contracts');
        $path_repositories = config('microservices.paths.repositories');
        $services          = config('microservices.services');
        
        foreach ($services as $key => $object) {            
            $service   = $path_services.$object['name'].'Service';
            $interface = $path_contracts.$object['name'].'Interface';
            $key       = strtolower( app('structure')->transformNameService($key) );
            
            if( $object['repository'] ){
                $repository = $path_repositories.$object['repository'];
                $this->app->bind( $interface, function($app) use ($service, $repository){
                    return new $service( app($repository) );
                });                
            }
            else{
                $this->app->bind( $interface, $service );
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
