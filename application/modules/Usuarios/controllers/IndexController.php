<?php

class Usuarios_IndexController extends My_Bootstrap {

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

}