<?php

	namespace Structure\Basic\Services;

	class Structure{

		public function checkExistsDirectories(){
			$this->path_controller = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_controller'))));
			$this->path_requests = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_requests'))));
			$this->path_resources = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_resources'))));
			$this->path_models = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_models'))));
			$this->path_observers = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_observers'))));
			$this->path_repositories = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_repositories'))));
			$this->path_services = app_path(str_replace('\\', '/', str_replace('App\\', '', config('structure.path_services'))));

			if( !is_dir($this->path_controller) )
				$this->buildDirectory( $this->path_controller );
			if( !is_dir($this->path_requests) )
				$this->buildDirectory( $this->path_requests );
			if( !is_dir($this->path_resources) )
				$this->buildDirectory( $this->path_resources );
			if( !is_dir($this->path_models) )
				$this->buildDirectory( $this->path_models );
			if( !is_dir($this->path_observers) )
				$this->buildDirectory( $this->path_observers );
			if( !is_dir($this->path_repositories) )
				$this->buildDirectory( $this->path_repositories );
			if( !is_dir($this->path_services) )
				$this->buildDirectory( $this->path_services );
		}

		public function buildDirectory( $pathname ){
			mkdir($pathname, 0775, true);
		}

		public function createMicroserviceConfigFile(){
			if( !file_exists( config_path('microservices.php') ) ){
				$handler = fopen( config_path('microservices.php'), 'w+' );
		        fwrite( $handler, "<?php \n\n\t" );
		        fwrite( $handler, view( 'structureview::microservice', ['services' => [] ] )->render() );
		        fclose( $handler );				
			}
		}

		public function transformNameService( $name_service ){
			$myService = studly_case( str_singular($name_service) );
            
            return $myService;
		}
	}