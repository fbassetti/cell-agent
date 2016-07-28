<?php

class Ventas_IndexController extends BootPoint {

	/**
	* Facturación por punto de Venta
	*
	*/
	public function facturacionPuntoAction(){
		$this->view->layout()->setLayout('default2');
		$form = new Ventas_forms_facturacionPunto();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales);
		$form->mm->addMultiOptions($this->view->cache_meses);
		$form->operatoria->addMultiOptions($this->view->cache_operatorias);

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();

			if($form->isValid($post)){
				$model = new default_models_Integracion_Vistas();
				$resultados = $model->getFacturacionPunto($form->getValue('suc_id'),
				$form->getValue('pun_id'),$form->getValue('yy'),
				$form->getValue('mm'),$form->getValue('operatoria'));

				$resNew = array();
				foreach($resultados as $i => $v)
					$resNew[$v['tipo_operacion']][] = $v;

				$this->view->resultados = $resNew;
				$this->view->periodo = $form->getValue('yy').'/'.$form->getValue('mm');
				$this->view->pun_id = $form->getValue('pun_id');
				$this->view->suc_id = $form->getValue('suc_id');
			}
			else {
				$this->view->message = 'Sucursal, Punto de Venta, Año y Mes son datos obligatorios.';
			}
		}
		$this->view->form = $form;
	}

	/**
	* Comisión por Punto de Venta
	*
	*/
	public function comisionPuntoAction(){
		$this->view->layout()->setLayout('default2');
		$form = new Ventas_forms_comisionPunto();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales);
		$form->mm->addMultiOptions($this->view->cache_meses);
		$form->operatoria->addMultiOptions($this->view->cache_operatorias);

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			/** Fix */
			if($form->isValid($post)){
				if(intval($form->mm->getValue('mm')) < 4)
					$form->mm->setValue('04');

				$model = new default_models_Integracion_Vistas();
				$resultados = $model->getComisionPunto($form->getValue('suc_id'),
				$form->getValue('pun_id'),$form->getValue('yy'),
				$form->getValue('mm'),$form->getValue('operatoria'));

				$resNew = array();
				foreach($resultados as $i => $v)
					$resNew[$v['tipo_operacion']][] = $v;

				$this->view->resultados = $resNew;
				$this->view->periodo = $form->getValue('yy').'/'.$form->getValue('mm');
				$this->view->pun_id = $form->getValue('pun_id');
				$this->view->suc_id = $form->getValue('suc_id');
			}
			else {
				$this->view->message = 'Sucursal, Punto de Venta, Año y Mes son datos obligatorios.';
			}
		}
		$this->view->form = $form;
	}

	/*
	$planesM = new default_models_Integracion_PlanesView();
	$planes = $planesM->getDefaultAdapter()->fetchPairs($planesM->select()->order('Plan'));
	$form->pla_id->addMultiOptions($planes);
	*/

	public function comisionPuntoMensualAction(){
		$id = $this->getRequest()->getParam('id'); /** mm-yyyy */
		$compare = $this->getRequest()->getParam('compare'); /** mm-yyyy */
		/*
		* obtener parametro mes/anio
		* Comparativa
		* 	generar parametro comparativa
		*/
		$id = '04-2012';
		$compare = '05-2012';
		if(!is_null($id)){
			$exp = explode('-',$id);
			$year = $exp[1];
			$mes = $exp[0];

			$indices[] = $id;
			$resultados = array();

			$modelo = new default_models_Integracion_Vistas();
			$resultados[$id] = $modelo->getComisionPuntoMes($year,$mes);
			if(!is_null($compare)){
				$exp2 = explode('-',$compare);
				$year2 = $exp2[1];
				$mes2 = $exp2[0];

				$indices[] = $compare;
				$resultados[$compare] = $modelo->getComisionPuntoMes($year2,$mes2);
			}

			$res = $new = $new2 = array();
			foreach($resultados as $a){
				foreach($a as $c => $v){
					$res[$v['operatoria']][] = $v['puntuacion'];
					#$new[] = "['{$this->view->cache_operatorias[$v['operatoria']]}',{$v['puntuacion']}]";
					#$new2[] = "['{$this->view->cache_operatorias[$v['operatoria']]}',{$v['ventas']}]";
				}
			}
			foreach($res as $i => $v)
				$new[] = "['{$this->view->cache_operatorias[$i]}',".implode(',',$v)."]";

			$this->view->graph = implode(',',$new);
//			$this->view->graph2 = implode(',',$new2);
			$this->view->year = $year;
			$this->view->mes = $mes;
			$this->view->resultados = $resultados;
			$this->view->indices = $indices;
		}
	}
}