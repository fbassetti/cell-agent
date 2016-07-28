<?php

class Informes_RentabilidadController extends BootPoint {

	public function indexAction(){
		$this->view->layout()->setLayout('default2');

		$suc_id = $this->getRequest()->getParam('suc_id');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$form = new Informes_forms_rentabilidad();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales);

		if($form->isValid(array('suc_id' => $suc_id))){
			$model = new default_models_Web_Rentabilidad();
			if($this->detalle == 1)
				$cuentas = $model->getCuentasDetalle($suc_id,$fechas->desdeEn,$fechas->hastaEn);
			else
				$cuentas = $model->getCuentas($suc_id,$fechas->desdeEn,$fechas->hastaEn);

			$model = new default_models_Integracion_TarjetasIngresoView();
			$tarjeta = $model->getIngresos($suc_id,$fechas->desdeEn,$fechas->hastaEn);
			if($tarjeta){
				array_unshift($cuentas,array(
				'cuenta'=>'[ Tarjetas ]',
				'monto' => $tarjeta['CP'],
				'debe_haber' => 'D',
				));
			}

			/** Equipos Ingresados */
			$equiposIngView = new default_models_Integracion_EquiposIngresadosView();
			$equipos = $equiposIngView->getCantidadMensual($suc_id,$fechas->desdeEn,$fechas->hastaEn);

			if($equipos){
				array_unshift($cuentas,array(
				'cuenta'=>'[ Equipos Ingresados ]',
				'cantidad'=>$equipos['cantidad'],
				'monto' => $equipos['monto'],
				'debe_haber' => 'D',
				'link' => "/informes/rentabilidad/equipos/suc_id/{$suc_id}/desde/".$fechas->desdeUrl."/hasta/".$fechas->hastaUrl
				));
			}

			/*WANDA */
			$wandaView = new default_models_Integracion_WandaIngresoView();
			$wanda = $wandaView->getIngresos($suc_id,$fechas->desdeEn,$fechas->hastaEn);
			if($wanda){
				array_unshift($cuentas,array(
				'cuenta'=>'[ Wanda ]',
				'monto' => $wanda['CO'],
				'debe_haber' => 'D',
				));
			}

			$this->view->cuentas = $cuentas;
			/** Select con Cuentas */
			$cuentasView = new default_models_Integracion_CuentasView();
			$pares = $cuentasView->getPares();

			$this->view->cuentas_select = $pares;
			$this->view->valid = 1;
			$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
		}
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->desdeEn = explode('-',$fechas->desdeEn);
		$this->view->hastaEn = explode('-',$fechas->hastaEn);
		$this->view->desdeUrl = $fechas->desdeUrl;
		$this->view->hastaUrl = $fechas->hastaUrl;

		$this->view->currency = new Zend_Currency();

		$this->datepickerHeaders();
	}

	public function detalleAction(){
		$this->detalle = 1;
		$this->indexAction();

		$this->view->navigation()->findByLabel('Rentabilidad')->setActive();
	}

	public function addConceptoAction(){
		$d = ($this->getRequest()->getParam('d') == 1) ? 'detalle' : 'index';

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			//Zend_Date::setOptions(array('cache' => $this->getInvokeArg('bootstrap')->getResource('cache')));
			$ZendDate = new Zend_Date($post['desde'],'dd/MM/y','es_AR');

			$values = array(
			'cue_id' => $post['cue_id'],
			'suc_id' => $post['suc_id'],
			'ren_fh' => $ZendDate->get('y-MM-dd'),
			'debe_haber' => $post['tipo'],
			'ren_monto' => str_replace(',','.',$post['ren_monto']),
			'ren_observa' => ''
			);
			$model = new default_models_Web_Rentabilidad();
			$model->fetchNew()->setFromArray($values)->save();
		}
		$suc_id = $this->getRequest()->getParam('suc_id');
		$desde = $this->getRequest()->getParam('desde');
		$hasta = $this->getRequest()->getParam('hasta');

		$this->_redirect("/informes/rentabilidad/{$d}/suc_id/{$suc_id}/desde/{$desde}/hasta/{$hasta}");
		//obtener conceptos
	}

	public function equiposAction(){
		$this->view->layout()->setLayout('default2');
		$suc_id = $this->getRequest()->getParam('suc_id');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		/** Equipos Ingresados */
		$equiposIngView = new default_models_Integracion_EquiposIngresadosView();
		$equipos = $equiposIngView->getListado($suc_id,$fechas->desdeEn,$fechas->hastaEn);

		$this->view->equipos = $equipos;
		$this->view->suc_id = $suc_id;
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->desdeUrl = $fechas->desdeUrl;
		$this->view->hastaUrl = $fechas->hastaUrl;
		$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;

		$this->view->currency = new Zend_Currency();
	}


	/**
	*
	*/
	public function deleteItemAction(){
		if(!$this->getRequest()->isXmlHttpRequest())
			die();
		$id = (int)$this->getRequest()->getParam('id');

		$model = new default_models_Web_Rentabilidad();
		$model->find($id)->current()->delete();

		$this->_helper->json(array('st'=>1));
	}
}