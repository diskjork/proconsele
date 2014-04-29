<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'YVN Contable',
	
   /*----------------------------------------------------------------------------------*/
	'language'=>'es', // lenguaje en el que queremos que muestre las cosas
    'sourceLanguage'=>'en', //  lenguaje por default de los archivos
	'charset'=>'utf-8',
	'timeZone' => 'America/Argentina/Mendoza',
	/*---------*/
	
	'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
		'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary    
	),	

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.helpers.TbHtml',
    	'ext.giix.components.*', 
		'ext.editable.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			'generatorPaths' => array(
				'bootstrap.gii',
				'ext.giix.generators', 
				),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
	
		),
		/*Modulo para manejor de autorizacion de acceso a los usuarios*/
		'auth'=> array(
			  'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
			  'userClass' => 'User', // the name of the user model class.
			  'userIdColumn' => 'iduser', // the name of the user id column.
			  'userNameColumn' => 'username', // the name of the user name column.
			  'defaultLayout' => 'application.views.layouts.column3', // the layout used by the module.
			  'viewDir' => null, // the path to view files to use with this module.
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'auth.components.AuthWebUser',
      		'admins' => array('admin', 'administrador'), // users with full access
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
	
		/*Autorizaciones de usuarios*/
		'authManager' => array(
			'class'=>'auth.components.CachedDbAuthManager',
  			'cachingDuration'=>3600,
			'connectionID' => 'db',
     	   	'behaviors' => array(
	    	   	'auth' => array(
	        	'class' => 'auth.components.AuthBehavior',
	        	),
	      	),
	    ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yvncontable',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
		'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);