<?php

class Caja_IndexController extends BootPoint {

	/**
	* Informe de Caja Sucursal/Punto Unico Varios Dias
	*
	*/
	public function informeAction(){
		$this->view->layout()->setLayout('default2');
		$suc_id = (int)$this->getRequest()->getParam('suc_id');
		$pun_id = $this->getRequest()->getParam('pun_id');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$form = new Caja_forms_informeCaja();###cambiar
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)->setValue($suc_id);
		if($suc_id > 0 && $pun_id > 0){
			$model = new default_models_Integracion_Vistas();
			$resultados = $model->getInformeCaja($suc_id,$pun_id,$fechas->desdeEn,$fechas->hastaEn);

			$this->view->resultados = $resultados;
			$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
		}
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->pun_id = $pun_id;

		$this->view->currency = new Zend_Currency();

		$this->datepickerHeaders();
	}
	
	/**
	* Informe de Caja Sucursal/Vendedor Unico Varios Dias
	*
	*/
	public function vendedorAction(){
		$this->view->layout()->setLayout('default2');
		$suc_id = (int)$this->getRequest()->getParam('suc_id');
		$pun_id = $this->getRequest()->getParam('pun_id');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();
		
		$desdemenos = $fechas->dameFecha($hasta,-1);
		
		$form = new Caja_forms_informeVendedor();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)->setValue($suc_id);
		if($suc_id > 0 && $pun_id > 0){
			$model = new default_models_Integracion_Vistas();
			$resultados = $model->getInformeVendedor($suc_id,$pun_id,$fechas->desdeEn,$fechas->hastaEn);

			$this->view->resultados = $resultados;
			$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
		}
		
		$this->view->desdemenos = $desdemenos;
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->pun_id = $pun_id;

		$this->view->currency = new Zend_Currency();

		$this->datepickerHeaders();
	}
	/**
	* Caja Diaria
	*
	*/
	public function diariaAction(){
		$this->view->layout()->setLayout('default2');
		$suc_id = (int)$this->getRequest()->getParam('suc_id');
		$pun_id = $this->getRequest()->getParam('pun_id');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$form = new Caja_forms_cajadiaria();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)->setValue($suc_id);
		if($suc_id > 0 && !empty($pun_id)){

			$model = new default_models_Integracion_Vistas();
			$resultados = $model->getInformeCajaDiaria($suc_id,$pun_id,$fechas->desdeEn,$fechas->hastaEn);
			if($resultados){
				$model = new default_models_Integracion_WandaIngresoView();
				$wanda = $model->getIngresosPunto($suc_id,$pun_id,$desde,$hasta);

				$this->view->wanda = $wanda;
			}

			$this->view->resultados = $resultados;
			$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
		}
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->pun_id = $pun_id;

		$this->view->currency = new Zend_Currency();

		$this->datepickerHeaders();
	}
}