

    namespace App\Http\Requests\API\{{ ucfirst($service) }};

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Http\Exceptions\HttpResponseException;

    class StoreRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                @foreach($rules as $field => $condition)
'{{$field}}' => '{{ $condition }}',
            @endforeach];
        }

        public function failedValidation( Validator $validator ){
            throw new HttpResponseException( response()->json( ['errors' => $validator->errors(), 'status' => 400], 400, [], JSON_PRETTY_PRINT) );
        }
    }