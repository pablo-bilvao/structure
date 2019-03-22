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
        
        if( $services ){
            foreach ($services as $key => $object) {            
                $service   = $path_services.$object['name'].'Service';
                $interface = $path_contracts.$object['name'].'Interface';
                
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
        }
        ################################################################
        $services_with_observers = array_where(config('structure.services'), function($value, $key){ return $value['observer']; });
        if( $services_with_observers ){
            foreach ($services_with_observers as $service_name => $options) {
                $service = app('structure')->transformNameService($service_name);
                $model_class    = config('structure.paths.models').$service;
                $observer_class = config('structure.paths.observers').$service.'Observer';
                $model_class::observe( $observer_class );
            }
        }
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
