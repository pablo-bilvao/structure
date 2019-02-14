
return [

    	'path_services' => 'App\Services\\',
    	'path_repositories' => 'App\Repositories\\',
		@if( count($services) > 0 )
    	'services' => [
		@foreach( $services as $service )
	'{{ strtolower($service) }}' => [
				'repository' => '{{ ucfirst(str_singular($service)) }}Repository',
				'name' => '{{ ucfirst(str_singular($service)) }}',
			],
@endforeach
    	],
		@else

		'services' => []
		@endif

	];