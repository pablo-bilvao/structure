
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Log;
use Exception;

class SynchronizeModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return    void
     */
    public function __construct( array $data ){
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return    void
     */
    public function handle()
    {
        try {

            ["RESOURCE" => $resource, "ACTION" => $action, "PARAMETERS" => $data] = $this->data;

            if ( !class_exists('\\App\\Models\\' . $resource) )
                return Log::error('Resource "'.$resource.'" not found');

            $Model = '\\App\\Models\\' . $resource;

            if ($action == "CREATE") return $Model::create($data);

            if ($action == "UPDATE") {
                $model = $Model::find($data['id']);

                if (!$model) return $Model::create($data);

                return $model->update($data);
            }
        } catch (Exception $e) {
            Log::error("ERROR SynchronizeModelJob", [$e->getMessage()]);
        }
    }

    public function failed(Exception $e)
    {
        Log::error("ERROR SynchronizeModelJob", [$e->getMessage()]);
    }
}