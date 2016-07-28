<?php

class Logistica_NivelesController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	/**
	* Ver Niveles de Autorizacion
	*
	*/
	public function indexAction(){
		$form = new default_forms_buscar();

		$model = new default_models_Web_Niveles();
		$niveles = $model->getNiveles();

		$this->view->niveles = $niveles;
		$this->view->fbuscar = $form;
	}

	/**
	* Buscar Niveles para agregar
	*
	*/
	public function buscarAction(){
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
	* Agregar Usuario Nivel
	*
	*/
	public function agregarAction(){
		$usu_id = (int)$this->getRequest()->getParam('usu_id');

		$model = new default_models_Web_Niveles();
		$fetch = $model->getDefaultAdapter()->fetchRow($model->select(true)->where("usu_id={$usu_id}"));
		if(!$fetch){
			$model->createRow(array(
				'usu_id' => $usu_id,
				'niv_estado' => 1
			))->save();
		}
		else{
			$model->update(array('niv_estado' => 1),"usu_id={$usu_id}");
		}
		$this->_redirect('/logistica/niveles');
	}

	/**
	* Cambiar Estado de Nivel
	*
	*/
	public function cambiarEstadoAction(){
		$id = (int)$this->getRequest()->getParam('id');
		$st = (int)$this->getRequest()->getParam('st');

		$model = new default_models_Web_Niveles();
		$model->find($id)->current()->setFromArray(array('niv_estado' => $st))->save();

		$this->_redirect('/logistica/niveles');
	}
}