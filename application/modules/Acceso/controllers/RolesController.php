<?php

class Acceso_RolesController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	/**
	* Listar Roles Asociados a un perfil
	*
	*/
	public function indexAction(){
		$model = new Acceso_models_Roles();
		$roles = $model->getRoles();

		$this->view->resultados = $roles;
	}

	/**
	* Añadir Rol
	*
	*/
	public function addAction(){
		$form = new Acceso_forms_roles();

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$values = $form->getValues();

				$model = new Acceso_models_Roles();
				$model->createRow($values)->save();

				$this->_redirect('/acceso/roles/index');
			}
		}

		$this->view->form = $form;
	}

	public function delAction(){

	}

	/**
	* Editar Rol
	*
	*/
	public function editAction(){
		$rol_id = (int)$this->getRequest()->getParam('rol_id');

		$form = new Acceso_forms_roles();
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$values = $form->getValues();

				$model = new Acceso_models_Roles();
				$model->update($values,"rol_id={$rol_id}");

				$this->_redirect('/acceso/roles/index');
			}
		}
		else {
			$model = new Acceso_models_Roles();
			$form->populate($model->find($rol_id)->current()->toArray());
		}

		$this->view->form = $form;
		$this->view->rol_id = $rol_id;
	}

	/**
	* Ver Recursos asociados al Rol
	*
	*/
	public function manageAction(){
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
	}
}