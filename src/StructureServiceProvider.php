<?php

namespace Structure\Basic;

use Illuminate\Support\ServiceProvider;

class StructureServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        
        // $this->publishes([
        //     __DIR__.'/Config/structure.php' => config_path('structure.php'),
        // ]);

        $this->loadViewsFrom(__DIR__.'/Views/structure', 'structureview');
        $this->commands('Structure\Basic\Commands\BuildStructure');
        $this->app->register('Structure\Basic\Provider\AppServiceProvider');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        
    }
}
