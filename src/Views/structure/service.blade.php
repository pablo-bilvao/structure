	
	namespace App\Services;
	
	use App\Contracts\{{ $service }}Interface;
	use App\Repositories\{{ $service }}Repository;
	use Illuminate\Http\Exceptions\HttpResponseException;

	class {{ $service }}Service implements {{ $service }}Interface{

		public function __construct( {{ $service }}Repository $repository ){
			$this->repository = $repository;
		}
	@if( in_array( 'index', $routes ) )	
		public function index(){
			if( \CircuitBreaker::isAvailable( '{{ $service }}Service::index' ) ){
	        	try{
	        		return $this->repository->all();
	        	}catch(Exception $e){
	        		\CircuitBreaker::reportFailure( '{{ $service }}Service::index' );
	        		// Aca debería haber una alerta para notificar que no anda.

					throw new HttpResponseException( response()->json( ['errors' => ['Service not available'], 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
	        	}
			}
			
			throw new HttpResponseException( response()->json( ['errors' => ['Service not available'], 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
	    }
	@endif
	@if( in_array( 'store', $routes ) )	
		public function create( array $arguments ){			
			if( \CircuitBreaker::isAvailable( '{{ $service }}Service::create' ) ){
	        	try{
	        		return $this->repository->create( $arguments );
	        	}catch(Exception $e){
	        		\CircuitBreaker::reportFailure( '{{ $service }}Service::create' );
	        		// Aca debería haber una alerta para notificar que no anda.

					throw new HttpResponseException( response()->json( ['errors' => ['Service not available'], 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
	        	}
			}
			
			throw new HttpResponseException( response()->json( ['errors' => ['Service not available'], 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
		}
	@endif
	@if( in_array( 'update', $routes ) )	
		public function update( array $arguments, string $id ){
			if( \CircuitBreaker::isAvailable( '{{ $service }}Service::update' ) ){
	        	try{
	        		return $this->repository->update( $arguments, $id );
	        	}catch(Exception $e){
	        		\CircuitBreaker::reportFailure( '{{ $service }}Service::update' );
	        		// Aca debería haber una alerta para notificar que no anda.

					throw new HttpResponseException( response()->json( ['errors' => ['Service not available'], 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
	        	}
			}
			
			throw new HttpResponseException( response()->json( ['errors' => ['Service not available'], 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
		}
	@endif
	
	}