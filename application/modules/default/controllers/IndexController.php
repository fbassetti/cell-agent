<?php

class IndexController extends BootPoint {

	public function init(){
		parent::init();
	}

	public function indexAction(){
		if($this->view->layout()->getLayout() == 'mobile2'){ return; }
		$year = date('Y');
		$mes = date('m');

		$modelo = new default_models_Integracion_Vistas();
		$resultados = $modelo->getComisionPuntoMes($year,$mes);

		$new = $new2 = array();
		foreach($resultados as $i => $v){
			$new[] = "['{$this->view->cache_operatorias[$v['operatoria']]}',{$v['puntuacion']}]";
			$new2[] = "['{$this->view->cache_operatorias[$v['operatoria']]}',{$v['ventas']}]";
		}

		$this->view->graph = implode(',',$new);
		$this->view->graph2 = implode(',',$new2);
		$this->view->year = $year;
		$this->view->mes = $mes;
		$this->view->resultados = $resultados;
	}

	/**
	* Desloguear
	*
	*/
	public function logoutAction(){
		$this->auth->clearIdentity();
		$this->_redirect('/');
	}

	/**
	* Iniciar Sesión
	*
	*/
	public function loginAction(){
		if($this->view->layout()->getLayout() == 'mobile2'){
			$this->view->mobile = 1;
		}

		$this->view->layout()->setLayout('default');
		if($this->auth->hasIdentity()){
			$this->_redirect('/');
		}

		$form = new default_forms_inicio();

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$values = $form->getValues();
				$authAdapter = $this->getInvokeArg('bootstrap')->getResource('auth');

				$authAdapter->setAmbiguityIdentity(true)
					->setIdentity($values['username'])
					->setCredential($values['password']);
				$result = $authAdapter->authenticate();
				if($result->isValid()){
					$usr_nid = $authAdapter->getResultRowObject()->idusuario;

					$cache = $this->getFrontController()->getParam('bootstrap')->getResource('cache');
					$cache->remove('acl_'.$usr_nid);

					$this->auth->getStorage()->write($authAdapter->getResultRowObject(null));

					$modelo = new Acceso_models_Usuarios();
					$roles = $modelo->getRoles($usr_nid);
					if(!empty($roles)){
						$ids = array_keys($roles);
						$this->auth->getIdentity()->roles = $ids;
					}

					$sesiones = new default_models_Web_RegSesiones();
					$registro = $sesiones->fetchNew();
					$registro->usr_nid = $usr_nid;
					$registro->reg_ip = new Zend_Db_Expr("INET_ATON('{$_SERVER['REMOTE_ADDR']}')");
					$registro->reg_fh = new Zend_Db_Expr('now()');
					$registro->reg_browser = substr($_SERVER['HTTP_USER_AGENT'],0,120);
					$registro->save();

					$redirect = str_replace($this->view->baseUrl(),'',$_SERVER['REQUEST_URI']);
					$this->_redirect($redirect);
				}
				$form->username->addError('Datos de Sesion incorrectos');
			}
		}
		$this->view->form = $form;
		$this->view->nomenu = 1;
		$this->view->redirect = $_SERVER['REQUEST_URI'];
	}

	/**
	* Sesiones de Usuario
	*
	*/
	public function sesionesAction(){
		$modelo = new default_models_Web_RegSesiones();
		$select = $modelo->select(true)
			->columns('UNIX_TIMESTAMP(reg_fh) as unix,INET_NTOA(reg_ip) as ip')
			->where('usr_nid=?',$this->auth->getIdentity()->idusuario)
			->order('reg_fh DESC');
		$sesiones = $modelo->getDefaultAdapter()->fetchAll($select);

		//$fecha = $date = new Zend_Date(time());
		foreach($sesiones as $i => $v){
			$sesiones[$i]['fecha'] =  '<b>'.date('d/m H:i',$v['unix']).'</b> ('.$this->view->nicetime(date('Y-m-d',$v['unix'])).')';
		}

		$this->view->sesiones = $sesiones;
	}

	public function sinPermisoAction(){
		if($this->getRequest()->isXmlHttpRequest())
			$this->view->layout()->disableLayout();
	}

}