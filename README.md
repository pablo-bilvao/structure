# Structure Basic Laravel 5

Structure Basic es un componente para Laravel. Nos permite crear una estrucutra básica y generar RestApis a partir de un archivo de configuración.

## Tabla de Contenidos
- <a href="#instalación">Instalación</a>
    - <a href="#composer">Composer</a>
    - <a href="#laravel">Laravel</a>
- <a href="#cómo-funciona">¿Cómo Funciona?</a>  
    - <a href="#archivo-configuración">Archivo Configuración</a>
        - <a href="#default-paths">Default Paths</a>
        - <a href="#component-options">Component Options</a>
        - <a href="#routes">Routes</a>
        - <a href="#services-ejemplo">Services (ejemplo)</a>
        - <a href="#services-estructura">Services (estructura)</a>
        - <a href="#observer--job">Observer & Job</a>
- <a href="#método-principal">Método Principal</a>

## Instalación

### Composer

Ejecutar el siguiente comando para descargar la última versión

```terminal
composer require pablito/structure
``` 
### Laravel

#### >= laravel5.5
El ServiceProvider se cargará automáticamente

#### < laravel5.5

En tu `config/app.php` agrega `Structure\Basic\StructureServiceProvider::class` al final de `providers` array:

```php
'providers' => [
    ...
    Structure\Basic\StructureServiceProvider::class,
],
```
## ¿Cómo funciona?

### Archivo Configuración

Lo primero que verás en el archivo de configuración (config/structure.php) será esto:

```php
return [  
  /* Default Paths */
  'paths' => [
      'contracts'    => 'App\Contracts\\',
      'models'       => 'App\Models\\',
      'observers'    => 'App\Observers',
      'repositories' => 'App\Repositories\\',
      'services'     => 'App\Services\\',
      'jobs'         => 'App\Jobs\\',
      'controller'   => 'App\Http\Controllers\API\\',
      'requests'     => 'App\Http\Requests\API\\',
      'resources'    => 'App\Http\Resources\\',
  ],  
  
  /* Component Options */
  'replace_all'        => false,

  /* Your services here */
  'services' => [
  ],

  /* Your routes structure here (3 levels) */
  'routes' => [
    ['prefix' => '', 'middleware' => ['cors']], // level 1
    ['prefix' => '', 'middleware' => []], // level 2
    ['prefix' => '', 'middleware' => []] // level 3
  ],

  /* Example Syntax */
  'routes_example' => [
    ['prefix' => 'level-name1', 'middleware' => ['cors']], // level 1
    ['prefix' => 'level-name2', 'middleware' => []], // level 2
    ['prefix' => 'level-name3', 'middleware' => []] // level 3
  ],

  /* Example Syntax */
  'services_example' => [
    'services_name' => [
      'fillables'        => ["param1", "param2"],
      'fieldSearcheable' => ["param1" => "like"],
      'resources'        => ['param1', 'param2', 'param3'],
      'routes'           => ['index', 'store', 'update'],
      'rules_store'      => [],
      'rules_update'     => [],
      'observer'         => FALSE
    ]
  ]
];
```
#### Default Paths

Aca tenemos la estructura de carpetas por default que utiliza el componente. Lo recomendable es mantener la misma, pero puede ser modificada. Lo que debe estar y no es opcional, son todos los path configurados.

#### Component Options

- replace_all => boolean /* Si es `true`, cuando ejecute el command principal reemplazará todos los archvos de los servicios que ya existen. Si es `false` creará solo los que no esten. */

#### Routes

En la versión actual y estable cuenta con 3 niveles (no es opcional la cantidad). Esta sección se configura cuales son los prefix y si necesitan algún middleware. Es bastante limitante lo que puede hacer esta parte. Pero puede setear el replace_all en false y crear su archivo de `api.php` personalizado.

- prefix => string
- middleware => array()

#### Services (ejemplo)

En esta sección van configurados nuestros servicios, por ejemplo: si necesito crear un Api que me devuelva un `json` con los roles de mi base de datos configuro mi servicio de la siguiente manera: 

Ejemplo:

```php 
  'services' => [
    'roles' => [
      'fillables'         => ["name", "country_name"],
      'fieldSearcheable'  => ["name" => "like", "country_name"],
      'resources'         => ['id', 'name', 'country_name'],
      'routes'            => ['index'],
      'rules_store'       => [],
      'rules_update'      => [],
      'observer'          => FALSE
    ]
  ]
```
Resultado:

Puede usarlo de dos maneras:
- Con Request: `http://structure.local/api/prefix1/prefix2/prefix3/roles` 
```json
{
  "data": [
    {
      "id": "1",
      "name": "Admin",
      "country_name": "Argentina"
    },
    {
      "id": "2",
      "name": "Supervisor",
      "country_name": "Chile"
    }
  ]
}
```
Para saber como filtrar que campos necesito traer o filtrar por algún name en particular ver las opciones en:
<a href="https://github.com/andersao/l5-repository#example-the-criteria">Example Repositories</a>

- Si lo queres utilizar desde algún lugar de tu código, tendrás que declarar el uso de la interfaz de tu servicio en la clase donde lo vas a utilizar. Veamos un ejemplo:
```php
    namespace App\Http\Controllers\API;
    use App\Http\Controllers\Controller;
    use App\Http\Resources\RoleResource;
    use App\Contracts\RoleInterface;  
    
    class RoleController extends Controller
    {
        public function __construct( RoleInterface $role ){
            $this->role = $role;
        }

        public function index(){
            return RoleResource::collection( $this->role->index() );
        }
    }
```

ACLARACION:
El nombre de la interfaz pasará de esto: `nombre_servicio_en_ingles_plural` (nombre del servicio en el archivo de configuración) a esto `NombreServicioEnInglesSingularInterface`.

#### Services (estructura)
```php
'services' => [
    'service_name' => [
      'fillables'        => ["param1", "param2"],
      'fieldSearcheable' => ["param1" => "like"],
      'resources'        => ['param1', 'param2', 'param3'],
      'routes'           => ['index', 'store', 'update'],
      'rules_store'      => [],
      'rules_update'     => [],
      'observer'         => FALSE
    ]
  ]
```
- `service_name`: nombre de tu servicio (o de la tabla en base de datos) preferiblemente en ingles y plural
- `fillable`: los atributos de la tabla en cuestión
- `fieldSearcheable`: los atributos que quieren incluir en filtros. Sigue esta regla `"atributo" => "condition"`, vea que si no especifíca el `condition` tomará por default `"="`
- `resources`: los atributos que necesitan que se devuelva en el json de respuesta. Si deja el array vacío devolverá todos los atributos de la tabla y podra filtrarlos utilizando el parámetro `filter` en su petición `GET`
- `routes`: en la versión actual se puede declarar 3 opciones, `index` para los GET, `store` para los POST y `update` para los PUT. A partir de estas opciones se crearán los métodos disponibles y las rutas. 
Ej de uso: `app('role')->update($atributos, $id);` No es necesario que específiqe las 3, puede solo necesitar una sola.
- `rules_store`: En caso de usar `store` puede específicar las reglas de validación teniendo en cuenta la documentación de <a target="_blank" href="https://laravel.com/docs/5.7/validation#form-request-validation">Laravel</a>
- `rules_update`: En caso de usar `update` puede específicar las reglas de validación teniendo en cuenta la documentación de <a target="_blank" href="https://laravel.com/docs/5.7/validation#form-request-validation">Laravel</a>
- `observer`: recibe un boolean, si es `true` le creará una clase en la carpeta de `observers`. Tenga en cuenta la documentación de <a target="_blank" href="https://laravel.com/docs/5.7/eloquent#observers">Laravel</a>

#### Observer & Job

Cuando en nuestro service configuramos el `observer => true` nos creará la clase Observer con el nombre de nuestro servicio en el path configurado. No es necesario registrar el observer, lo tomará automáticamente.
Si bien, los observers se pueden utilizar para diferentes funcionalidades, en el packages está pensado principalmente para la sincronización de datos a través de colas de procesos. No quita que lo puedas utilizar para realizar otra cosa.

Para poder utilizarlo, primero tenes que configurar algún driver para queues. Tenga en cuenta la documentación de <a target="_blank" href="https://laravel.com/docs/5.7/queues">Laravel</a>

Una vez configurado, lo único que hay que configurar para utilizar la sincronización es configurar los datos del api que va a consumir para sincronizar (o las apis). 
La clase observer ya tendrá lo necesario para hacerlo.

## Método Principal

Una vez configurado el archivo, o cada vez que lo modifiquemos tendremos que correr un comando de ArtisanCLI para indicarle a nuestra aplicación que hay nuevos o modificaciones en nuestros servicios básicos.

Command:
```shell
php artisan build:structure
```

