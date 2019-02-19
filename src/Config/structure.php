<?php

	return [
		
		/* Default Paths */
		'path_controller' 	=> 'App\Http\Controllers\API\\',
		'path_requests'   	=> 'App\Http\Requests\API\\',
		'path_resources'  	=> 'App\Http\Resources\\',
		'path_models'	  	=> 'App\Models\\',
		'path_observers'  	=> 'App\Observers',
		'path_repositories' => 'App\Repositories\\',
		'path_services'     => 'App\Services\\',
		'replace_all'       => true,

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