
    namespace App\Observers;

    use App\Models\{{ ucfirst($service) }};
    use \Carbon\Carbon;

    class {{ ucfirst($service) }}Observer{
        
        public function created({{ ucfirst($service) }} ${{ strtolower($service) }}){
            
            /* 
                Notificar al servicio que corresponda. Podría generar un dispatch en una cola de Rabbits 
            */

        }

        public function updated({{ ucfirst($service) }} ${{ strtolower($service) }}){
            
            /* 
                Notificar al servicio que corresponda. Podría generar un dispatch en una cola de Rabbits 
            */

        }

    }

?>