
    namespace App\Observers;

    use App\Models\{{ ucfirst($service) }};
    use \Carbon\Carbon;
    use App\Jobs\SynchronizeModelJob;
    use Bus;

    class {{ ucfirst($service) }}Observer{
        
        public function created({{ ucfirst($service) }} ${{ strtolower($service) }}){
           
            $data = [
                [
                    'HOST'       => 'HOST_EXTERNAL_SERVICE_API', //Tiene que estar en .env
                    'METHOD'     => 'POST',
                    'RESOURCE'   => '/api/prefix1/prefix2/prefix3/{{ strtolower(str_plural($service)) }}', //ejemplo de la url del servicio
                    'PARAMETERS' => ${{ strtolower($service) }}->toArray()
                ]
            ];

            Bus::dispatch( new SynchronizeModelJob($data) );

        }

        public function updated({{ ucfirst($service) }} ${{ strtolower($service) }}){
            
            $data = [
                [
                    'HOST'       => 'HOST_EXTERNAL_SERVICE_API', //Tiene que estar en .env
                    'METHOD'     => 'PUT',
                    'RESOURCE'   => '/api/prefix1/prefix2/prefix3/{{ strtolower(str_plural($service)) }}/'.${{ strtolower($service) }}->id, //ejemplo de la url del servicio
                    'PARAMETERS' => ${{ strtolower($service) }}->toArray()
                ]
            ];

            Bus::dispatch( new SynchronizeModelJob($data) );

        }

    }

?>