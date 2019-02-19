	
	namespace App\Services;

	use App\Repositories\{{ $service }}Repository;

	class {{ $service }}{

		public function __construct( {{ $service }}Repository $repository ){
			$this->repository = $repository;
		}
	@if( in_array( 'index', $routes ) )	
		public function index(){
	        return $this->repository->all();
	    }
	@endif
	@if( in_array( 'store', $routes ) )	
		public function create( $arguments ){
			return $this->repository->create( $arguments );
		}
	@endif
	@if( in_array( 'update', $routes ) )	
		public function update( $arguments, $id ){
			return $this->repository->update( $arguments, $id );
		}
	@endif
	
	}