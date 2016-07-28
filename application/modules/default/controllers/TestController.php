<?php

class TestController extends My_Bootstrap {

	public function indexAction(){
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
}