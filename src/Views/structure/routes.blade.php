	Route::group(['prefix' => '{{ $routes[0]['prefix'] }}'@if($routes[0]['middleware']), 'middleware' => [@foreach($routes[0]['middleware'] as $key => $middleware)'{{$middleware}}'@if(count($routes[0]['middleware']) - 1 != $key),@endif @endforeach]@endif], function(){

		Route::group(['prefix' => '{{ $routes[1]['prefix'] }}'@if($routes[1]['middleware']), 'middleware' => [@foreach($routes[1]['middleware'] as $key => $middleware)'{{$middleware}}'@if(count($routes[1]['middleware']) - 1 != $key),@endif @endforeach]@endif], function(){

			Route::namespace('API')->group(function(){

				Route::group(['prefix' => '{{ $routes[2]['prefix'] }}'@if($routes[2]['middleware']), 'middleware' => [@foreach($routes[2]['middleware'] as $key => $middleware)'{{$middleware}}'@if(count($routes[2]['middleware']) - 1 != $key),@endif @endforeach]@endif], function(){

					@foreach($services as $key => $service)
Route::apiResource('{{$service}}', '{{ app('structure')->transformNameService($service) }}Controller', [ 'only' => [@foreach($services_routes[$key] as $key2 => $method)'{{$method}}'@if( count($services_routes[$key]) -1 != $key2),@endif @endforeach] ]);
					@endforeach
				
				});

			});

		});

	});