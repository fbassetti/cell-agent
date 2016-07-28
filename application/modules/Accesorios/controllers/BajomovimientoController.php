<?php

class Accesorios_BajomovimientoController extends BootPoint {

	/**
	* Listar Accesorios de Bajo movimiento un Punto de Venta
	* Requiere que todos los parámetros no sean nulos Suc,Pun,Mes,Año
	*
	*/
	public function indexAction(){
		$this->view->layout()->setLayout('default2');

		$suc_id = (int)$this->getRequest()->getParam('suc_id');
		$pun_id = $this->getRequest()->getParam('pun_id');
		$limite = $this->getRequest()->getParam('limite');

		$fechas = new default_helpers_FechasDH();
		$fechas->setRequest($this->getRequest());
		$hasta = $fechas->getHasta();
		$desde = $fechas->getDesde();

		$form = new Accesorios_forms_bajomovimiento();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales)->setValue($suc_id);

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$values = $form->getValues();
				$model = new Accesorios_models_bajomovimiento();

				$ingresos = $model->obtenerIngresos($suc_id,$values['pun_id'],$fechas->desdeEn,$fechas->hastaEn);
				if(!empty($ingresos) > 0){
					$egresos = $model->obtenerEgresos($suc_id,$values['pun_id'],$fechas->desdeEn,
						$fechas->hastaEn,array_keys($ingresos));

					if(!empty($egresos) > 0){
						foreach($egresos as $i => $v){
							if($v <= $limite){
								$ingresos[$i]['cantidad'] = $v;
							}
							else{
								unset($ingresos[$i]);
							}
						}
					}
				}
				$this->view->periodo = 'desde '.$desde.' hasta '.$hasta;
				$this->view->resultados = $ingresos;
			}
		}
		$this->view->limite = (int)$limite;
		$this->view->desde = $desde;
		$this->view->hasta = $hasta;
		$this->view->form = $form;
		$this->view->suc_id = $suc_id;
		$this->view->pun_id = $pun_id;

		$this->datepickerHeaders();
	}

}