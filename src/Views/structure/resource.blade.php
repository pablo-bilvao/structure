
    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\Resource;

    class {{ ucfirst($service) }}Resource extends Resource
    {
        
        public function toArray($request)
        {            
            @if( !empty($resources) )
            
            return [
                @foreach( $resources as $resource )
'{{ $resource }}' => $this->{{ $resource }},
                @endforeach
];
        }
            @else
            
            return $this->resource;            
        
        }
            @endif

        public function withResponse($request, $response)
        {
            if ($request->has('callback')) {
                $response->withCallback($request->callback);
            }
        }
        
    }
