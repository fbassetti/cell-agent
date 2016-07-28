<?php

class Acceso_RecursosController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	public $arrModules = array();
	public $arrControllers = array();
	public $arrActions = array();
	private $arrIgnore = array('.','..','.svn','navigation.xml','default','Rest','My');

	public function indexAction(){
		$this->buildModulesArray();
		$this->buildControllerArrays();
		$this->buildActionArrays();

		$this->view->recursos = $this->arrActions;
	}

	public function assocAction(){
		$rol_id = (int)$this->getRequest()->getParam('rol_id');

		$model = new Acceso_models_Roles();
		$rol = $model->find($rol_id)->current()->toArray();
		$recursos = $model->getRecursos($rol_id);

		$new = array();
		foreach($recursos as $i => $v){
			if($v['controller'] == '')
				$new[$v['module']] = array();
			elseif($v['action'] == ''){
				$new[$v['module']][$v['controller']] = array();
			}
			else{ $new[$v['module']][$v['controller']][] = $v['action']; }
		}

		$this->view->rol = $rol;
		$this->view->resultados = $new;
		$this->indexAction();
	}

	public function agregarAction(){
		$rol_id = (int)$this->getRequest()->getParam('rol_id');

		if($this->getRequest()->isPost()){
			$modulos = $this->getRequest()->getParam('modulo');
			$controladores = $this->getRequest()->getParam('controlador');
			$acciones = $this->getRequest()->getParam('accion');

			$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();

			if(!empty($modulos)){
				foreach($modulos as $i => $v){
					//#limpieza hereditaria
					unset($controladores[$v]);
					unset($accion[$v]);
					/*
					update hereditario */
					$adapter->update('web.roles_recursos',array('rec_activo' => 0),"rol_id={$rol_id} AND module='{$v}' AND (controller!='' OR action!='')");

					$sql = "INSERT INTO web.roles_recursos (rol_id,module,controller,action,rec_activo) VALUES ({$rol_id},'{$v}','','',1) "
					. "ON DUPLICATE KEY UPDATE rec_activo=1";
					$adapter->query($sql);
					//insert if exist update
				}
			}

			if(!empty($controladores)){
				foreach($controladores as $i => $v){
					unset($accion[$i][$v]); //limpieza
					/* si existen acciones o modulo desactiva */
					foreach($v as $ii => $c){
						$adapter->update('web.roles_recursos',array('rec_activo' => 0),
						"rol_id={$rol_id} AND module='{$i}' AND ((controller='{$c}' AND action!='') OR (controller='' AND action=''))");

						//insert if exist update
						$sql = "INSERT INTO web.roles_recursos (rol_id,module,controller,action,rec_activo) VALUES ({$rol_id},'{$i}','{$c}','',1) "
						. "ON DUPLICATE KEY UPDATE rec_activo=1";
						$adapter->query($sql);
					}
				}
			}

			if(!empty($acciones)){
				foreach($acciones as $m => $c){
					foreach($c as $i => $v){
						$adapter->update('web.roles_recursos',array('rec_activo' => 0),
						"rol_id={$rol_id} AND module='{$m}' AND (controller='' OR controller='{$i}') AND action=''");

						foreach($v as $b => $a){
							$sql = "INSERT INTO web.roles_recursos (rol_id,module,controller,action,rec_activo) "
							. "VALUES ({$rol_id},'{$m}','{$i}','{$a}',1) ON DUPLICATE KEY UPDATE rec_activo=1";
							$adapter->query($sql);
							//insert if exist update
						}
					}
				}
			}
		}
		$this->_redirect('/acceso/recursos/assoc/rol_id/'.$rol_id);
	}

	public function removerAction(){
		$rol_id = (int)$this->getRequest()->getParam('rol_id');

		if($this->getRequest()->isPost()){
			$modulos = $this->getRequest()->getParam('modulo');
			$controladores = $this->getRequest()->getParam('controlador');
			$acciones = $this->getRequest()->getParam('accion');

			$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
			$model = new Acceso_models_Recursos();

			if(!empty($modulos)){
				unset($controladores[$v]);
				unset($accion[$v]);
				$model->update(array('rec_activo' => 0),array('rol_id = ?' => $rol_id, 'module IN (?)',$modulos));
			}

			if(!empty($controladores)){
				foreach($controladores as $i => $v){
					unset($accion[$i][$v]); //limpieza
					$model->update(array('rec_activo' => 0),
					array(
					'rol_id = ?' => $rol_id,
					'module = ?' => $i,
					'controller IN (?)' =>  $v
					));
				}
			}
			if(!empty($acciones)){
				foreach($acciones as $m => $c){
					foreach($c as $i => $v){
						$model->update(array('rec_activo' => 0),
						array(
						'rol_id = ?' => $rol_id,
						'module = ?' => $m,
						'controller = ?' => $i,
						'action IN (?)'=> array_values($v)
						));
					}
				}
			}
		}

		$this->_redirect('/acceso/recursos/assoc/rol_id/'.$rol_id);
	}


	public function buildModulesArray() {
		$dstApplicationModules = opendir(APPLICATION_PATH . '/modules');
		while(($dstFile = readdir($dstApplicationModules)) !== false ) {
			if(!in_array($dstFile, $this->arrIgnore)) {
				if(is_dir(APPLICATION_PATH . '/modules/' . $dstFile)) {
					$this->arrModules[] = strval($dstFile);
				}
			}
		}
		asort($this->arrModules);
		closedir($dstApplicationModules);
	}

	public function buildControllerArrays(){
		if(count($this->arrModules) > 0){
			foreach($this->arrModules as $strModuleName){
				$datControllerFolder = opendir(APPLICATION_PATH . '/modules/' . $strModuleName . '/controllers');
				while(($dstFile = readdir($datControllerFolder) ) !== false){
					if(!in_array($dstFile, $this->arrIgnore)) {
						if(preg_match( '/Controller/', $dstFile) ) {
							$this->arrControllers[$strModuleName][] = strtolower(substr($dstFile,0,-14));
						}
					}
				}
				asort($this->arrControllers[$strModuleName]);
				closedir($datControllerFolder);
			}
		}
	}

	public function buildActionArrays(){
		if(count($this->arrControllers) > 0){
			foreach($this->arrControllers as $strModule => $arrController){
				foreach($arrController as $strController){
					$strClassName = ucfirst($strModule).'_'.ucfirst( $strController . 'Controller');
					if(!@class_exists($strClassName)){
						Zend_Loader::loadFile(APPLICATION_PATH . '/modules/'. $strModule.'/controllers/'.ucfirst($strController).'Controller.php');
					}
					$objReflection = new Zend_Reflection_Class($strClassName);
					$arrMethods = $objReflection->getMethods();
					foreach($arrMethods as $objMethods){
						if(preg_match('/Action/', $objMethods->name )){
							$this->arrActions[$strModule][$strController][] = substr($this->_camelCaseToHyphens($objMethods->name),0,-6);
						}
					}
					asort($this->arrActions[$strModule][$strController]);
				}
			}
		}
	}

	private function _camelCaseToHyphens($string) {
		if($string == 'currentPermissionsAction') {$found = true;}
		$length = strlen($string);
		$convertedString = '';
		for($i = 0; $i <$length; $i++) {
			if(ord($string[$i]) > ord('A') && ord($string[$i]) < ord('Z')) {
				$convertedString .= '-' .strtolower($string[$i]);
			} else {
				$convertedString .= $string[$i];
			}
		}
		return strtolower($convertedString);
	}
}