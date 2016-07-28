<?php

class Usuarios_PermisosController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}
	/*
	* Mostrar permisos activos
	*/
	public function indexAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');

		$acl = $this->view->navigation()->getAcl();
		$resources = $acl->getResources();
		$form = new Usuarios_forms_permisos();
		$form->recursos->addMultiOptions(array_combine(array_values($resources),array_values($resources)));

		$usuModelo = new default_models_Integracion_UsuariosView();
		$usuario = $usuModelo->find($usu_id)->current()->toArray();

		$model = new default_models_Web_Permisos();
		$fila = $model->find($usu_id)->current();
		if(!is_null($fila)){
			$permisos = explode(',',$fila['permisos']);
			if(sizeof($permisos) > 0)
				$form->recursos->setValue($permisos);
		}

		$elemento = $form->recursos->renderViewHelper();
		$elemento = str_replace('<label','<label class="label"',$elemento);
		$opciones = explode('__',$elemento);
		$columnas = ceil(sizeof($opciones)/5);
		$chunks = array_chunk($opciones,$columnas,true);

		$this->view->recursos = $chunks;
		$this->view->form = $form;
		$this->view->usu_id = $usu_id;
		$this->view->usuario = $usuario['Apellido'].', '.$usuario['nombre'];

		$fbuscar = new default_forms_buscar();
		$this->view->fbuscar = $fbuscar;
	}

	public function guardarAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			$form = new Usuarios_forms_permisos();
			if($form->isValid($post)){
				$recursos = $form->getValue('recursos');

				/* save in session */
				$auth = Zend_Auth::getInstance();
				$identity = $auth->getIdentity();
				if($identity->idusuario == $usu_id){
					$identity->permisos = implode(',',$recursos);
					$auth->getStorage()->write($identity);
				}

				/* save in db */
				$modelo = new default_models_Web_Permisos();
				$row = $modelo->find($usu_id)->current();
				if(is_null($row)){
					$modelo->createRow(array('usu_id'=>$usu_id,'permisos'=>implode(',',$recursos)))->save();
				}
				else {
					$row->permisos = implode(',',$recursos);
					$row->save();
				}

				$this->_redirect('/usuarios/index');
			}
		}
		$this->_redirect('/usuarios/permisos/index/usu_id/'.$usu_id);
	}
}