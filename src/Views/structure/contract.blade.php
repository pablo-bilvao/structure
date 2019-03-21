    
    namespace App\Contracts;
    
    interface {{ $service }}Interface{

        @if( in_array( 'index', $routes ) )public function index();@endif
        
        @if( in_array( 'store', $routes ) )public function create(array $arguments);@endif
        
        @if( in_array( 'update', $routes ) )public function update(array $params, string $id);@endif

    }