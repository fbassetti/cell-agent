<?php

class Acceso_UsuariosController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	/*
	* Listado de Usuarios
	*/
	public function indexAction(){
		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;
		$perPage = 14;

		$q = $this->getRequest()->getParam('q');
		$form = new default_forms_buscar();
		if($this->getRequest()->isPost()){
			if(!$form->isValid($this->getRequest()->getPost())){
				$q = '';
			}
		}

		$modelo = new default_models_Integracion_UsuariosView();
		$usuarios = $modelo->getUsuarios($q,$page,$perPage);
		$total = $modelo->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
		$paginas = ceil($total/$perPage);

		$this->view->fbuscar = $form;
		$this->view->usuarios = $usuarios;
		$this->view->total = $total;
		$this->view->paginas = $paginas;
	}

	/**
	* Roles
	*/

	public function manageAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');

		$model = new default_models_Integracion_UsuariosView();
		$usuario = $model->find($usu_id)->current()->toArray();
		
		$mRoles = new Acceso_models_Usuarios();
		$roles = $mRoles->getRoles($usu_id);

		$this->view->usuario = $usuario;
		$this->view->resultados = $roles;
	}

	public function assocAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');

		$model = new default_models_Integracion_UsuariosView();
		$usuario = $model->find($usu_id)->current()->toArray();
		
		$mRoles = new Acceso_models_Usuarios();
		$roles = $mRoles->getRoles($usu_id);

		$collect = array();
		foreach($roles as $i => $v)
			$collect[] = $v['rol_id'];
		$todos = $mRoles->getRolesRestantes($collect);

		$this->view->usuario = $usuario;
		$this->view->resultados = $roles;
		$this->view->roles = $todos;
	}

	public function agregarAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');
		if($this->getRequest()->isPost()){
			$roles = $this->getRequest()->getParam('rol');
			if(sizeof($roles) > 0){
				$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
				foreach($roles as $i){
					$sql = "INSERT INTO web.usuarios_roles (usu_id,rol_id,uro_activo) VALUES ({$usu_id},{$i},1) ON DUPLICATE KEY UPDATE uro_activo=1";
					$adapter->query($sql);
				}
			}
		}
		$this->_redirect('/acceso/usuarios/assoc/usu_id/'.$usu_id);
	}

	public function quitarAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');
		if($this->getRequest()->isPost()){
			$roles = $this->getRequest()->getParam('rol');
			if(!empty($roles)){
				$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
				$adapter->update('web.usuarios_roles',array('uro_activo' => 0),"usu_id={$usu_id} AND rol_id IN (".implode(',',$roles).")");
			}
		}
		$this->_redirect('/acceso/usuarios/assoc/usu_id/'.$usu_id);
	}

}