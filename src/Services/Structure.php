<?php

	namespace Structure\Basic\Services;

	class Structure{

		public function __construct(){
			$this->createStructureConfigFile();
		}

		public function checkExistsDirectories(){
			$paths_configs = config('structure.paths');
			$this->paths   = [];

			foreach ($paths_configs as $path_name => $path_value) {
				$this->paths[ $path_name ] = app_path(str_replace('\\', '/', str_replace('App\\', '', $path_value)));

				if( !is_dir($this->paths[ $path_name ]) )
					$this->buildDirectory( $this->paths[ $path_name ] );
			}
			
		}

		public function buildDirectory( $pathname ){
			mkdir($pathname, 0775, true);
		}

		public function createStructureConfigFile(){
			if( !file_exists( config_path('structure.php') ) ){
				$handler = fopen( config_path('structure.php'), 'w+' );
		        fwrite( $handler, "<?php \n\n\t" );
		        fwrite( $handler, view( 'structureview::structure' )->render() );
		        fclose( $handler );
			}
		}

		public function createMicroserviceConfigFile(){
			if( !file_exists( config_path('microservices.php') ) ){
				$handler = fopen( config_path('microservices.php'), 'w+' );
		        fwrite( $handler, "<?php \n\n\t" );
		        fwrite( $handler, view( 'structureview::microservice', ['services' => [], 'paths' => $this->paths ] )->render() );
		        fclose( $handler );				
			}
		}

		public function transformNameService( $name_service ){
			$myService = studly_case( str_singular($name_service) );
            
            return $myService;
		}
	}