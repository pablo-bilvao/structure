
	namespace App\Http\Controllers\API;

	use App\Http\Controllers\Controller;
	use App\Http\Resources\{{ ucfirst($service) }}Resource;
	use App\Contracts\{{ ucfirst($service) }}Interface;	
	@if( in_array( 'store', $routes ) )use App\Http\Requests\API\{{ ucfirst($service) }}\StoreRequest;
	@endif
@if( in_array( 'update', $routes ) )use App\Http\Requests\API\{{ ucfirst($service) }}\UpdateRequest;
	@endif

	class {{ ucfirst($service) }}Controller extends Controller
	{
		public function __construct( {{ ucfirst($service) }}Interface ${{ strtolower($service) }} ){
			$this->{{ strtolower($service) }} = ${{ strtolower($service) }};
		}
	@if( in_array( 'index', $routes ) )

	    public function index(){
	        return {{ ucfirst($service) }}Resource::collection( $this->{{ strtolower($service) }}->index() );
	    }
	@endif
	@if( in_array( 'store', $routes ) )

	    public function store( StoreRequest $request ){
	        return new {{ ucfirst($service) }}Resource( $this->{{ strtolower($service) }}->create( $request->all() ) );
	    }
	@endif
	@if( in_array( 'update', $routes ) )
	
	    public function update( UpdateRequest $request, $id ){
	        return new {{ ucfirst($service) }}Resource( $this->{{ strtolower($service) }}->update( $request->all(), $id ) );
	    }
	@endif
	
	}
