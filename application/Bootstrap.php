<?php

class Bootstrap extends Zend_Application_Module_Bootstrap {

	protected function _initDb(){
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/db.ini",APPLICATION_ENV);

		$params = array(
			'host' => $config->host,
			'username'	=> $config->username,
			'password'	=> $config->password,
			'dbname'	=> $config->dbname,
			'charset'	=> 'utf8',
			'profiler'	=> true
		);
		$db = Zend_Db::factory('Mysqli',$params);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		return $db;
	}
	
	protected function _initSettings(){
		return new Zend_Config(require APPLICATION_PATH.'/configs/settings.php',true);
	}

	protected function _initRoutes(){
		$this->bootstrap('frontController');

		$front = $this->getResource('frontController');
		$front->setControllerDirectory(
			array(
				'default'   => APPLICATION_PATH . '/modules/default/controllers',
				'acceso'  => APPLICATION_PATH . '/modules/Acceso/controllers',
				'caja'  => APPLICATION_PATH . '/modules/Caja/controllers',
				'locales'  => APPLICATION_PATH . '/modules/Locales/controllers',
				'logistica'  => APPLICATION_PATH . '/modules/Logistica/controllers',
				'recargas'  => APPLICATION_PATH . '/modules/Recargas/controllers',
				'accesorios'  => APPLICATION_PATH . '/modules/Accesorios/controllers',
				'herramientas'  => APPLICATION_PATH . '/modules/Herramientas/controllers',
				'ventas'  => APPLICATION_PATH . '/modules/Ventas/controllers',
				'usuarios'  => APPLICATION_PATH . '/modules/Usuarios/controllers',
				'activaciones'  => APPLICATION_PATH . '/modules/Activaciones/controllers',
				'pedidos'  => APPLICATION_PATH . '/modules/Pedidos/controllers',
				'informes'  => APPLICATION_PATH . '/modules/Informes/controllers',
			)
		)
		->registerPlugin( new Autorizacion())
		->setBaseUrl($this->getResource('settings')->baseurl)
		->throwExceptions(false);
	}

	protected function _initView(){
		$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$mobile = preg_match('#iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm#',$userAgent);

		if(isset($_GET['m'])){
			$mobile = true;
		}
		Zend_Layout::startMvc(
			array(
			'layoutPath' => APPLICATION_PATH . '/layouts/scripts',
			'layout'     => ($mobile) ? 'mobile2' : 'default'
			)
		);

		$view = Zend_Layout::getMvcInstance()->getView();
		$view->doctype('HTML5');
		$view->setEncoding('UTF-8')
			->setBasePath(APPLICATION_PATH.'/modules/default/views');

		$config = new Zend_Config_Xml(APPLICATION_PATH.'/modules/navigation.xml','nav');
		$container = new Zend_Navigation($config);
		$view->navigation($container);

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		return $view;
	}

	protected function _initAuth(){
		return new Zend_Auth_Adapter_DbTable(
			$this->getResource('db'),
			'integracion.usuarios_view',
			'username',
			'passmd5',
			'MD5(?)'
		);
		//identidad
		//crendential
	}

		
	protected function _initCache(){
       	$frontendOptions = array('lifetime' => null,'automatic_serialization' => true);
        	$backendOptions = array('cache_dir' => "./cache",'cache_file_perm' => 0777);
        	return Zend_Cache::factory('Core','File',$frontendOptions,$backendOptions);
	}

	protected function _initTranslate(){
		$translate = new Zend_Translate(
			array(
			'adapter' => 'array',
			'content' => APPLICATION_PATH . '/languages/es/Zend_Validate.php',
			'locale' => 'es_AR')
		);
		Zend_Form::setDefaultTranslator($translate);
		$locale = new Zend_Locale('es_AR');
		$locale->setCache($this->getResource('cache'));
		Zend_Registry::set('Zend_Locale', $locale);
		Zend_Registry::set('Zend_Translate', $translate);
	}

}

function dump_var($var,$f=true){
	Zend_Debug::dump($var);
	if(!$f)
		return;
	die();
}
