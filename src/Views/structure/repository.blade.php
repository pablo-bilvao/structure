
	namespace App\Repositories;

	use Prettus\Repository\Eloquent\BaseRepository;
	use Prettus\Repository\Criteria\RequestCriteria;

	class {{ ucfirst($service) }}Repository extends BaseRepository
	{
	    @if( $fieldSearcheable )
protected $fieldSearchable = [
			@foreach($fieldSearcheable as $field => $condition)
@if(is_string($field))'{{$field}}' => '{{ $condition }}'@else'{{$condition}}'@endif,
			@endforeach
];
		@endif
		
		public function boot(){
			$this->pushCriteria( new RequestCriteria( request() ) );
		}

		public function model()
	    {
	        return "App\Models\{{ ucfirst($service) }}";
	    }
	}