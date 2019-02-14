	
	namespace App\Services;

	use App\Repositories\{{ $service }}Repository;

	class {{ $service }}{

		public function __construct( {{ $service }}Repository $repository ){
			$this->repository = $repository;
		}
		
		public function index(){
	        return $this->repository->all();
	    }

		public function create( $arguments ){
			return $this->repository->create( $arguments );
		}

		public function update( $arguments, $id ){
			return $this->repository->update( $arguments, $id );
		}

	}