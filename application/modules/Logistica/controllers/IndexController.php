<?php

class Logistica_IndexController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}
	/**
	* Consulta de Equipos
	*
	*/
	public function consultarEquiposAction(){
		$idmsn = $this->getRequest()->getParam('idmsn');

		$form = new Logistica_forms_consultarEquipos();
		$form->idmsn->setValue($idmsn);
		if($idmsn != ''){
			$model = new default_models_Integracion_Vistas();
			$equipo = $model->getEquipo($idmsn);

			$this->view->equipo = $equipo;
			$this->view->currency = new Zend_Currency();
		}
		$this->view->form = $form;
	}

	/**
	* Consulta de SimCard
	*
	*/
	public function consultarSimAction(){
		$idcard = $this->getRequest()->getParam('idcard');

		$form = new Logistica_forms_consultarSim();
		$form->idcard->setValue($idcard);
		if($idcard != ''){
			$model = new default_models_Integracion_Vistas();
			$equipo = $model->getSim($idcard);

			$this->view->equipo = $equipo;
			$this->view->currency = new Zend_Currency();
		}
		$this->view->form = $form;
	}

	/**
	* Listar Equipos por Sucursal
	*
	*/
	public function equiposSucursalAction(){
		$suc_id = (int)$this->getRequest()->getParam('suc_id');
		$pun_id = $this->getRequest()->getParam('pun_id');
		$mar_id = (int)$this->getRequest()->getParam('mar_id');
		$mod_id = $this->getRequest()->getParam('mod_id');

		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;

		$perPage = 14;

		$form = new Logistica_forms_equiposSucursal();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)->setValue($suc_id);
		$form->mar_id->addMultiOptions($this->view->cache_marcas)->setValue($mar_id);
		if($suc_id > 0 || $mar_id > 0){
			$model = new default_models_Integracion_Vistas();
			$equipos = $model->getEquiposPorSucursal($suc_id,$pun_id,$mar_id,$mod_id,$page,$perPage);

			$total = $model->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
			$paginas = ceil($total/$perPage);

			$this->view->equipos = $equipos;
			$this->view->paginas = $paginas;
			$this->view->total = $total;
		}
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->pun_id = $pun_id;
		$this->view->mar_id = $mar_id;
		$this->view->mod_id = $mod_id;

		$this->view->currency = new Zend_Currency();
	}

	/**
	* Buscar SIM en Sucursal
	*
	*/
	public function simcardSucursalAction(){
		$suc_id = (int)$this->getRequest()->getParam('suc_id');

		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;

		$perPage = 14;

		$form = new Logistica_forms_equiposSucursal();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)
			->setValue($suc_id)->setAttrib('class','styled-select');
		if($suc_id > 0){
			$model = new default_models_Integracion_Vistas();
			$equipos = $model->getSimSucursal($suc_id,$page,$perPage);

			$total = $model->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
			$paginas = ceil($total/$perPage);

			$this->view->equipos = $equipos;
			$this->view->paginas = $paginas;
			$this->view->total = $total;
		}
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
	}

}