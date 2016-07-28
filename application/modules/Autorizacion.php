<?php

class Autorizacion extends Zend_Controller_Plugin_Abstract {

	protected $auth;
	protected $acl;

	public function __construct(){
		$this->auth = Zend_Auth::getInstance();
		$this->auth->setStorage(new Zend_Auth_Storage_Session('Rgdis'));
		$this->acl = new Acl($this->auth);
	}

	/**
	* Funcionalidades antes de Despachar el Action
	*
	* @param Zend_Controller_Request_Abstract $request
	* @return Zend_Controller_Request_Abstract
	*/
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		if(!$this->auth->hasIdentity()){
			return $request->setModuleName('default')
			->setControllerName('index')
			->setActionName('login');
		}

		/**
		* Implementar Cache
		*/
		$cache = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('cache');
		if(!$acl = $cache->load('acl_'.$this->auth->getIdentity()->idusuario)){
			$acl = $this->acl;

			$model = new Acceso_models_Usuarios();
			$recursos = $model->getRecursosRoles($this->auth->getIdentity()->roles);

			$control = array();
			foreach($recursos as $i => $v){
				if(!isset($control[$v['module']])){
					$acl->addResource($v['module']);
					//if(empty($v['controller'])){
						$acl->allow($acl->rol,$v['module']);
						$control[$v['module']] = array();
						//continue;
					//}
				}
				if(!empty($v['controller'])){
					if(!isset($control[$v['module']][$v['controller']])){
						$acl->addResource($v['module'].':'.$v['controller']);

						if($v['action'] != ''){
							$acl->allow($acl->rol,$v['module'].':'.$v['controller'],$v['action']);
						}
						else{ //habilita controlador accion
							$acl->allow($acl->rol,$v['module'].':'.$v['controller']);
						}
						$control[$v['module']][$v['controller']] = ''; //creado
					}
				}
			}
			$cache->save($acl,'acl_'.$this->auth->getIdentity()->idusuario);
		}
		$this->acl = $acl;

		Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($this->acl->rol);
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($this->acl);

		if($this->acl->has($request->getModuleName())){ // existe module ?
			if($this->acl->isAllowed($this->acl->rol,$request->getModuleName())) return; //permite modulo completo
		}
		if($this->acl->has($request->getModuleName().':'.$request->getControllerName())){ //existe module:controller?
			if($this->acl->isAllowed($this->acl->rol,
				$request->getModuleName().':'.$request->getControllerName(),
				$request->getActionName())) return; //permite action
		}

		return $request->setModuleName('default')
			->setControllerName('index')
			->setActionName('sin-permiso');
	}

	public function dispatchLoopShutdown(){
		if($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->getParam('widget') == 1){
			$this->getResponse()->setBody(utf8_encode($this->getResponse()->getBody()));
		}
	}
}