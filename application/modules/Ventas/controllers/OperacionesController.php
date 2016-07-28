<?php

class Ventas_OperacionesController extends BootPoint {

	/**
	* Lista de Operaciones
	*
	*/
	public function indexAction(){
		header("Cache-Control: no-cache, must-revalidate");
		$form = new Ventas_forms_operaciones();

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			/**
			* Texto opcional
			*/
			if($post['tilde'] == 1){
				$form->query->setAttrib('disabled','disabled');
				$form->texto->setAttrib('style','');
			}

			if($form->isValid($post)){
				$values = $form->getValues();
				$query = $values['query'];

				if($values['tilde'] == 1){
					$texto = str_replace(array("\r","\t",'  ', '    ', '    ',' '),'',$values['texto']);
					$resultados = explode("\n",$texto);
					$resultados = array_filter($resultados);
					asort($resultados);
					$resultados = array_unique($resultados);

					$form->texto->setValue(implode("\n",$resultados)); #fix
					$query = implode("','",$resultados);
				}

				$modelo = new default_models_Integracion_OperacionesView();
				$operaciones = $modelo->getOperaciones($values['campo'],$query);
				if(sizeof($operaciones) > 0){
					$select = new Zend_Form_Element_Select('suc_id');
					$select->addMultiOptions($this->view->cache_sucursales);
					$this->view->form_select = $select;

					if($values['tilde'] == 1){
						$collect = array();
						foreach($operaciones as $i => $v)
							$collect[] = $v[$values['campo']];
						$error = array_diff($resultados,$collect);
						if(sizeof($error) > 0){
							$form->error->setValue(implode("\n",$error)); #fix
							$form->error->setAttrib('style','');
							$this->view->error = 1;
						}
					}
				}

				$this->view->operaciones = $operaciones;
			}
		}

		$this->view->form = $form;
	}

	/**
	* Asignación por Venta
	*
	*/
	public function asignacionAction(){
		if($this->getRequest()->isPost()){
			$id_vendedor = (int)$this->getRequest()->getParam('ven_id');
			$id_sucursal = (int)$this->getRequest()->getParam('suc_id');

			$ids = $this->getRequest()->getParam('ids');
			if(sizeof($ids) > 0 && $id_vendedor > 0){
				$auth = Zend_Auth::getInstance();
				$usu_id = $auth->getIdentity()->idusuario;

				$puntos = new default_models_Integracion_PuntosView();
				$data = $puntos->find($id_vendedor)->current()->toArray();

				$model = new default_models_Integracion_Functions();
				foreach($ids as $s){
					$explode = explode('-',$s);
					$model->asignacion_ope_func($explode[0],$explode[1],$id_vendedor,$data['tipovendedor'],$id_sucursal, $data['idsupervisor'], $usu_id);
				}
			}
			else {
				$this->_redirect('/ventas/operaciones/');
			}
		}
		else {
			$this->_redirect('/ventas/operaciones/');
		}

	}

}