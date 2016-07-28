<?php

class Recargas_IndexController extends BootPoint {

	/**
	* Listado por Sucursal
	*
	*/
	public function listadoPorSucursalAction(){
		$this->view->layout()->setLayout('default2');

		$form = new Recargas_forms_listadoSucursal();
		$form->suc_id->addMultiOptions($this->view->cache_sucursales);
		$form->mm->addMultiOptions($this->view->cache_meses);
		$form->operatoria->addMultiOptions($this->view->cache_operatorias);

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$model = new default_models_Integracion_Vistas();
				$resultados = $model->getRecargasSucursal($form->getValue('suc_id'),$form->getValue('yy'),
				$form->getValue('mm'),$form->getValue('operatoria'));

				if(!empty($resultados)){
					$total = $model->getTotalVentas($form->getValue('suc_id'),$form->getValue('yy'),
					$form->getValue('mm'),$form->getValue('operatoria'));
					$this->view->total = $total;
				}
				$this->view->resultados = $resultados;
				$this->view->periodo = $this->view->cache_meses[$form->getValue('mm')].' de '.$form->getValue('yy');
				$this->view->suc_id = $form->getValue('suc_id');
				$this->view->ope_id = $form->getValue('operatoria');

				$this->view->currency = new Zend_Currency();
			}
		}
		$this->view->form = $form;
	}

	/**
	* Listado por Vendedor
	*
	*/
	public function listadoPorVendedorAction(){
		$this->view->layout()->setLayout('default2');

		$form = new Recargas_forms_listadoVendedor();
		$form->ven_id->addMultiOptions($this->view->cache_vendedores);
		$form->mm->addMultiOptions($this->view->cache_meses);
		$form->operatoria->addMultiOptions($this->view->cache_operatorias);

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$model = new default_models_Integracion_Vistas();
				$resultados = $model->getRecargasVendedor($form->getValue('ven_id'),$form->getValue('yy'),
					$form->getValue('mm'),$form->getValue('operatoria'));

				$this->view->resultados = $resultados;
				$this->view->periodo = $this->view->cache_meses[$form->getValue('mm')].' de '.$form->getValue('yy');
				$this->view->ven_id = $form->getValue('ven_id');
				$this->view->ope_id = $form->getValue('operatoria');

				$this->view->currency = new Zend_Currency();
			}
		}
		$this->view->form = $form;
	}

	public function promedioRecargasAction(){
		$this->view->layout()->setLayout('default2');
	}

}