	Route::group(['prefix' => '{{ $routes[0] }}', 'middleware' => 'cors'], function(){

		Route::group(['prefix' => '{{ $routes[1] }}'], function(){

			Route::namespace('API')->group(function(){

				Route::group(['prefix' => '{{ $routes[2] }}'], function(){

					@foreach($services as $key => $service)
Route::apiResource('{{$service}}', '{{ app('structure')->transformNameService($service) }}Controller', [ 'only' => [@foreach($services_routes[$key] as $key2 => $method)'{{$method}}'@if( count($services_routes[$key]) -1 != $key2),@endif @endforeach] ]);
					@endforeach
				
				});

			});

		});

	});