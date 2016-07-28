<?php

class Logistica_ProveedoresController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	public function indexAction(){
		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;

		$perPage = 20;

		$model = new default_models_Integracion_Proveedores();
		$resultados = $model->getProveedores($q,$page,$perPage);
		$total = $model->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
		$paginas = ceil($total/$perPage);

		$this->view->resultados = $resultados;
		$this->view->paginas = $paginas;
		$this->view->total = $total;
	}

	public function altaAction(){
		$form = new Logistica_forms_proveedores();
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$model = new default_models_Integracion_Proveedores();
				$row = $model->createRow($form->getValues());
				$id = $row->save();
				$this->_redirect('/logistica/proveedores/ver/prv_id/'.$id);
			}
		}
		$this->view->form = $form;
	}

	public function verAction(){
		$prv_id = $this->getRequest()->getParam('prv_id');

		$model = new default_models_Integracion_Proveedores();
		$info = $model->find($prv_id)->current()->toArray();
		#$contactos = $model->getContactos($prv_id);

		$this->view->info = $info;
		#$this->view->contactos = $contactos;
	}

	public function editarAction(){
		$prv_id = $this->getRequest()->getParam('prv_id');

		$form = new Logistica_forms_proveedores();
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$model = new default_models_Integracion_Proveedores();
				$model->find($prv_id)->current()->setFromArray($form->getValues())->save();

				$this->_redirect('/logistica/proveedores/ver/prv_id/'.$prv_id);
			}
		}
		else {
			$model = new default_models_Integracion_Proveedores();
			$form->populate($model->find($prv_id)->current()->toArray());
		}
		$this->view->form = $form;
		$this->view->prv_id = $prv_id;
	}

	public function eliminarAction(){
		$prv_id = $this->getRequest()->getParam('prv_id');

		$model = new default_models_Integracion_Proveedores();
		$model->find($prv_id)->current()->delete();

		$this->_redirect('/logistica/proveedores');
	}
}