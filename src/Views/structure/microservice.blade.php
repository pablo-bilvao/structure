
return [

    	'path_services' => 'App\Services\\',
    	'path_repositories' => 'App\Repositories\\',
		@if( count($services) > 0 )
'services' => [
		@foreach( $services as $service )
			'{{ strtolower($service) }}' => [
				'repository' => '{{ app('structure')->transformNameService($service) }}Repository',
				'name' => '{{ app('structure')->transformNameService($service) }}',
			],	
@endforeach
    	],
		@else

		'services' => []
		@endif

	];