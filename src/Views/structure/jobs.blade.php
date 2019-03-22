
    namespace App\Jobs;

    use Illuminate\Bus\Queueable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;

    use Bus;
    use Log;
    use Exception;
    use \GuzzleHttp\Client as ClientHttp;
    use \GuzzleHttp\Exception\RequestException;

    class SynchronizeModelJob implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public $data;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct( array $data ){
            $this->data = $data;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle(){

            foreach ($this->data as $info) {
                try {
                    $url_api = env($info['HOST']).$info['RESOURCE'];
                    $http_client = new ClientHttp([ 'base_uri' => $url_api ]);
                    $res = $http_client->request($info['METHOD'], $url_api, [
                        /*'headers' => [
                            'Authorization' => 'Bearer '.$token
                        ],*/
                        'json' => $info['PARAMETERS']
                    ]);

                    $response = json_decode($res->getBody()->getContents(), TRUE);
                    if( !isset($response['data']) ) //condicion si falla. puede preguntar por otra cosa si es necesario
                        $this->ponerEnCola( [$info] );

                } catch (Exception $e) {
                    
                    $this->ponerEnCola([$info]);
                    
                } catch (RequestException $re){
                    
                    $this->ponerEnCola([$info]);

                }

            }

        }

        public function ponerEnCola( $data ){
            
            Bus::dispatch( new SynchronizeModelJob($data) );

        }
    }
