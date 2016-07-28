<?php

class Accesorios_IngresosController extends BootPoint {

	public function indexAction(){
		$this->view->layout()->setLayout('default2');

		$suc_id = (int)$this->getRequest()->getParam('suc_id');
		$pun_id = $this->getRequest()->getParam('pun_id');
		$ope = $this->getRequest()->getParam('ope');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$form = new Accesorios_forms_ingresos();###cambiar
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)->setValue($suc_id);
		if($suc_id > 0){
			$model = new default_models_Integracion_Vistas();
			$resultados = $model->getIngresos($suc_id,$pun_id,$ope,$fechas->desdeEn,$fechas->hastaEn);

			$form->ope->setValue($ope);

			$this->view->resultados = $resultados;
			$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
			$this->view->desdeUrl = $fechas->desdeUrl;
			$this->view->hastaUrl = $fechas->hastaUrl;
		}
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->pun_id = $pun_id;
		$this->view->ope = $ope;

		$this->view->currency = new Zend_Currency();
		$this->datepickerHeaders();
	}

	public function vendedorAction(){
		$this->view->layout()->setLayout('default2');

		$ven_id = (int)$this->getRequest()->getParam('ven_id');
		$pun_id = (int)$this->getRequest()->getParam('pun_id');
		$ope = $this->getRequest()->getParam('ope');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$model = new default_models_Integracion_Vistas();
		$resultados = $model->getIngresosVendedor($ven_id,$ope,$pun_id,$fechas->desdeEn,$fechas->hastaEn);

		$this->view->resultados = $resultados;
		$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
		$this->view->desdeUrl = $fechas->desdeUrl;
		$this->view->hastaUrl = $fechas->hastaUrl;
		$this->view->ven_id = $ven_id;
		$this->view->pun_id = $pun_id;
		$this->view->ope = $ope;

		$this->view->currency = new Zend_Currency();
	}

	public function puntoAction(){
		$this->view->layout()->setLayout('default2');

		$pun_id = $this->getRequest()->getParam('pun_id');
		$ope = $this->getRequest()->getParam('ope');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$model = new default_models_Integracion_Vistas();
		$resultados = $model->getIngresosPunto($pun_id,$ope,$fechas->desdeEn,$fechas->hastaEn);

		$this->view->resultados = $resultados;
		$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
		$this->view->desdeUrl = $fechas->desdeUrl;
		$this->view->hastaUrl = $fechas->hastaUrl;
		$this->view->pun_id = $pun_id;
		$this->view->ope = $ope;

		$this->view->currency = new Zend_Currency();
	}
}
