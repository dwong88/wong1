<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Template Php',
	//WT: Setting theme. ada di folder "project/theme"
	'theme'=>'blueribbon',
	// WT: Untuk setting bahasa pada saat validasi form.
	//'timeZone'=>'Asia/Bangkok',
	// preloading 'log' component
	'preload'=>array('log'),
	'defaultController'=>'site/home',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'core',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'widgetFactory'=>array(
			'widgets'=>array(
				'JuiDatePicker'=>array(
					'options'=>array(
						'appendText'=>'(dd/mm/yyyy)',
						'changeMonth'=>true,
						'changeYear'=>true,
						'dateFormat'=>'dd/mm/yy', //Please also change params setting at the bottom of this page.
						'yearRange'=>'1930:2016',
					),
					'htmlOptions'=>array(
						//'readonly'=>'true',
					),
				)
			)
		),
		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=dbghours',
			'emulatePrepare' => true,
			'username' => 'kontraks_usr',
			'password' => 'kontrak123',
			'charset' => 'utf8',
		),
		'browser'=>array(
			'class'=>'application.extensions.browser.CBrowserComponent'
		),
		'format'=>array(
			//'class'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../components/kmgext/Formatter',
			'class'=>'application.components.Formatter',
		),
		'datetime'=>array(
			'class'=>'application.components.DateTimeParser',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		/*
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),
		*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'wiyanto@karltigo.com',
		'datepick_1st'=>'dd',
		'datepick_2nd'=>'mm',
		'datepick_3rd'=>'yy',
		'datepick_separator'=>'/',
		'datepick_phpDateFormat'=>'d/m/Y', //php date format pada saat mau menampilkan ke textbox dari mysql.
	),
);
