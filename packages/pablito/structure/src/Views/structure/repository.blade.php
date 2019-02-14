
	namespace App\Repositories;

	use Prettus\Repository\Eloquent\BaseRepository;

	class {{ ucfirst($service) }}Repository extends BaseRepository
	{
	    @if( $fieldSearcheable )
protected $fieldSearchable = [
			@foreach($fieldSearcheable as $field => $condition)
'{{$field}}' => '{{ $condition }}',
			@endforeach
];
		@endif

		public function model()
	    {
	        return "App\Models\{{ ucfirst($service) }}";
	    }
	}