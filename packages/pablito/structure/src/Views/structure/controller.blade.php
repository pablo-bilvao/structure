
	namespace App\Http\Controllers\API;

	use App\Http\Controllers\Controller;
	use App\Http\Requests\API\{{ ucfirst($service) }}\StoreRequest;
	use App\Http\Requests\API\{{ ucfirst($service) }}\UpdateRequest;
	use App\Http\Resources\{{ ucfirst($service) }}Resource;

	class {{ ucfirst($service) }}Controller extends Controller
	{
	    public function index(){
	        return {{ ucfirst($service) }}Resource::collection( app('{{ strtolower($service) }}')->index() );
	    }

	    public function store( StoreRequest $request ){
	        return new {{ ucfirst($service) }}Resource( app('{{ strtolower($service) }}')->create( $request->all() ) );
	    }

	    public function update( UpdateRequest $request, $id ){
	        return new {{ ucfirst($service) }}Resource( app('{{ strtolower($service) }}')->update( $request->all(), $id ) );
	    }
	}
