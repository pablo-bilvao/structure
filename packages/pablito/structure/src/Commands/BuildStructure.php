<?php

namespace Structure\Basic\Commands;

use Illuminate\Console\Command;

class BuildStructure extends Command{

    protected $signature = 'build:structure';    
    protected $description = 'Build Project Structure';

    public function __construct(){
        parent::__construct();
    }
    
    public function handle(){
        app('structure')->checkExistsDirectories();

        $services_to_build = config('structure.services');
        
        foreach ($services_to_build as $service => $info ) {
            $myService = ucfirst( str_singular($service) );
            
            /* Controller */
            $controller = $myService.'Controller';
            if( !file_exists( app('structure')->path_controller.$controller.'.php' ) ){
                $handler = fopen( app('structure')->path_controller.$controller.'.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::controller', ['service' => $myService] )->render() );
                fclose( $handler );            
            }

            /* Requests */
            if( !is_dir( app('structure')->path_requests.$myService ) )
                app('structure')->buildDirectory( app('structure')->path_requests.$myService );

            if( !file_exists( app('structure')->path_requests.$myService.'/StoreRequest.php' ) ){
                $handler = fopen( app('structure')->path_requests.$myService.'/StoreRequest.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::store_request', ['service' => $myService, 'rules' => $info['rules_store']] )->render() );
                fclose( $handler );
            }

            if( !file_exists( app('structure')->path_requests.$myService.'/UpdateRequest.php' ) ){
                $handler = fopen( app('structure')->path_requests.$myService.'/UpdateRequest.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::update_request', ['service' => $myService, 'rules' => $info['rules_store']] )->render() );
                fclose( $handler );
            }

            /* Resources */
            $resource = $myService.'Resource';
            if( !file_exists( app('structure')->path_resources.$resource.'.php' ) ){
                $handler = fopen( app('structure')->path_resources.$resource.'.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::resource', ['service' => $myService, 'resources' => $info['resources'] ] )->render() );
                fclose( $handler );            
            }

            /* Models */
            $model = $myService;
            if( !file_exists( app('structure')->path_models.$model.'.php' ) ){
                $handler = fopen( app('structure')->path_models.$model.'.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::model', ['service' => $myService, 'fillables' => $info['fillables'] ] )->render() );
                fclose( $handler );            
            }

            /* Observers */
            if( $info['observer'] ){                
                $observer = $myService.'Observer';
                if( !file_exists( app('structure')->path_observers.$observer.'.php' ) ){
                    $handler = fopen( app('structure')->path_observers.$observer.'.php', 'w+' );
                    fwrite( $handler, "<?php \n\n\t" );
                    fwrite( $handler, view( 'structureview::observer', ['service' => $myService] )->render() );
                    fclose( $handler );            
                }
            }

            /* Repositories */            
            $repository = $myService.'Repository';
            if( !file_exists( app('structure')->path_repositories.$repository.'.php' ) ){
                $handler = fopen( app('structure')->path_repositories.$repository.'.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::repository', ['service' => $myService, 'fieldSearcheable' => $info['fieldSearcheable']] )->render() );
                fclose( $handler );            
            }

            /* Services */
            $service = $myService;
            if( !file_exists( app('structure')->path_services.$service.'.php' ) ){
                $handler = fopen( app('structure')->path_services.$service.'.php', 'w+' );
                fwrite( $handler, "<?php \n\n\t" );
                fwrite( $handler, view( 'structureview::service', ['service' => $myService] )->render() );
                fclose( $handler );            
            }
        }
        
        $handler = fopen( config_path('microservices.php'), 'w+' );
        fwrite( $handler, "<?php \n\n\t" );
        fwrite( $handler, view( 'structureview::microservice', ['services' => array_keys($services_to_build)] )->render() );
        fclose( $handler );
    }
}
