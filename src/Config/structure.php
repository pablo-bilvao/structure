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

		/* Your services here */
		'services' => [

		],

		/* Your routes structure here (3 levels) */
        'routes' => [

        ],

		/* Example Syntax */
        'routes_example' => [
            'level-name1', // level 1
            'level-name2', // level 2
            'level-name3' // level 3
        ],

		/* Example Syntax */
		'services_example' => [
			'services_name' => [
				'fillables'        => ["param1", "param2"],
				'fieldSearcheable' => ["param1" => "like"],
				'resources'        => ['param1', 'param2', 'param3'],
				'rules_store'      => '[]',
				'rules_update'     => '[]',
				'observer'		   => FALSE
			]
		]
	];