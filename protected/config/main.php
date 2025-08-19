<?php
return array(
  'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
  'name' => 'Store',
  'defaultController' => 'site/login',

  'timeZone' => 'Asia/Jakarta',

  // preloading 'log' component
  'preload' => array('log'),

  'aliases' => array(
    'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), //bootstrap
    'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), //YiiWheels
  ),

  // autoloading model and component classes
  'import' => array(
    'application.models.*',
    'application.components.*',
    //bootstrap
    'bootstrap.behaviors.*',
    'bootstrap.helpers.*',
    'bootstrap.widgets.*',
    'bootstrap.helpers.TbHtml',
  ),

  'modules' => array(
    // uncomment the following to enable the Gii tool
    'gii' => array(
      'class' => 'system.gii.GiiModule',
      'password' => '1234Lima',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters' => array('127.0.0.1', '::1', '192.168.1.188'),
    ),

  ),

  // application components
  'components' => array(
    'formatter' => array(
      'class' => 'application.components.Formatter',
      'dateFormat' => 'd-M-Y',
    ),

    'formatRupiah' => array(
      'class' => 'application.components.Helper',
    ),
    'session' => array(
      'timeout' => 180000,
      'cookieParams' => array(
        'lifetime' => 180000,
      ),
    ),
    'user' => array(
      // enable cookie-based authentication
      'allowAutoLogin' => true,
    ),

    //bootstrap
    'bootstrap' => array(
      'class' => 'bootstrap.components.TbApi'
    ),

    //YiiWheels
    'yiiwheels' => array(
      'class' => 'yiiwheels.YiiWheels',
    ),

    // 'phpExcel' => array(
    // 	'class' => 'ext.phpexcel.XPHPExcel',
    // ),

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

    // database settings are configured in database.php
    'db' => require(dirname(__FILE__) . '/database.php'),

    'errorHandler' => array(
      // use 'site/error' action to display errors
      'errorAction' => 'site/error',
      //'errorAction'=>YII_DEBUG ? null : 'site/error',
    ),

    'log' => array(
      'class' => 'CLogRouter',
      'routes' => array(
        array(
          'class' => 'CFileLogRoute',
          'levels' => 'error, warning',
        ),
        // uncomment the following to show log messages on web pages
        /*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
      ),
    ),

    'theme' => 'AdminLTE',

  ),

  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params' => array(
    'adminEmail'  => 'rootosolution@gmail.com', // for use  Yii::app()->params['adminEmail']
    'adminPass'    => 'Password12tiga',
    'adminHost'    => 'smtp.gmail.com',
    //'adminEmail'	=> 'info@rgindonesia.com',// for use  Yii::app()->params['adminEmail']
    //'adminPass'	=> 'inforgi123',
    //'adminHost'	=> 'mail.rgindonesia.com',
    'kode'      => '1',
    'noimage'    => 'images/system/noimage.png',
    'webName'    => 'pendidikan.com',
    'webUrl'    => 'https://pendidikan.com',

    'paramGudangBesar'     => 'GUDANG BESAR',
    'paramGudangKecil'     => 'GUDANG KECIL',
    'paramGudangPenerimaan' => 'GUDANG PENERIMAAN',
    'paramGudangRetur'    => 'GUDANG RETUR',
    'paramGudangRefund'    => 'GUDANG REFUND',
    'paramGudangTitip'    => 'GUDANG TITIP',
    'paramBagianChecker'  => 'CHECKER',

    'FLASH_ADD_SUCCESS' => 'Data berhasil disimpan',
    'FLASH_ADD_FAILED' => 'Data gagal disimpan',
    'FLASH_UPDATE_SUCCESS' => 'Data berhasil dirubah',
    'FLASH_UPDATE_FAILED' => 'Data gagal dirubah',
    'FLASH_DELETE_SUCCESS' => 'Data berhasil dihapus',
    'FLASH_DELETE_FAILED' => 'Data gagal dihapus',
    'FLASH_ADD_DUPLICATE' => 'Data sudah ada',
    'FLASH_DETAIL_EMPTY' => 'Detail tidak boleh kosong',
  ),
);
