
	return [
		
		/* Default Paths */
		'paths' => [
			'contracts'    => 'App\Contracts\\',
			'models'	   => 'App\Models\\',
			'observers'    => 'App\Observers',
			'repositories' => 'App\Repositories\\',
			'services'     => 'App\Services\\',
			'controller'   => 'App\Http\Controllers\API\\',
			'requests'     => 'App\Http\Requests\API\\',
			'resources'    => 'App\Http\Resources\\',
		],
		
		/* Component Options */
		'replace_all' => FALSE,

		/* Your routes structure here (3 levels) */
        'routes' => [
        	['prefix' => '', 'middleware' => ['cors']], // level 1
            ['prefix' => '', 'middleware' => []], // level 2
            ['prefix' => '', 'middleware' => []] // level 3
        ],
		
		/* Your services here */
		'services' => [

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