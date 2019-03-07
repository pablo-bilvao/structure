
return [
		'paths' => [
	    	'services'     => 'App\Services\\',
	    	'repositories' => 'App\Repositories\\',
			'contracts'    => 'App\Contracts\\'
		],
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