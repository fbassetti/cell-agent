<?php

class Activaciones_IndexController extends BootPoint {

	/**
	* Lista de Activaciones
	*
	*/
	public function indexAction(){
		$this->view->layout()->setLayout('default2');
		$form = new Activaciones_forms_activaciones();

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
					$activaciones = explode("\n",$texto);
					$activaciones = array_filter($activaciones);
					asort($activaciones);
					$activaciones = array_unique($activaciones);

					$form->texto->setValue(implode("\n",$activaciones)); #fix
					//$query = implode('","',$activaciones);
					$query = $activaciones;
				}

				$modelo = new default_models_Web_Activacion();
				$resultados = $modelo->getActivaciones($values['campo'],$query);
				if(sizeof($resultados) > 0){
					$select = new Zend_Form_Element_Select('suc_id');
					$select->addMultiOptions($this->view->cache_sucursales);
					$this->view->form_select = $select;

					if($values['tilde'] == 1){
						$collect = array();
						foreach($resultados as $i => $v)
							$collect[] = trim($v[$values['campo']]);
						$error = array_diff($activaciones,$collect);

						if(sizeof($error) > 0){
							$form->error->setValue(implode("\n",$error)); #fix
							$form->error->setAttrib('style','');
							$this->view->error = 1;
						}
					}
				}

				$this->view->activaciones = $resultados;
			}
		}

		$this->view->form = $form;
	}

	/**
	* Lista de Lotes
	*
	*/
	public function lotesAction(){
		$this->view->layout()->setLayout('default2');
		$model = new default_models_Web_Activacion();
		$lotes = $model->getLotes();

		/** Filtro */
		$_lotes = array();
		foreach($lotes as $i => $v){
			$indice = $v['lote'].'-'.$v['activacion_locLin'];
			$st = ($v['activacion_estado'] != 'Finalizado') ? 'Pendiente' : 'Finalizado';
			$_lotes[$indice][$st] += $v['cantidad'];
			$_lotes[$indice]['activacion_abonado'] = $v['activacion_abonado'];
			$_lotes[$indice]['activacion_locLin'] = $v['activacion_locLin'];
			$_lotes[$indice]['lote'] = $v['lote'];
		}

		$this->view->lotes = $_lotes;
	}

	/**
	* Ver Listado de Activaciones / Lote
	*
	*/
	public function verLoteAction(){
		$this->view->layout()->setLayout('default2');
		$lote = $this->getRequest()->getParam('lote');
		$model = new default_models_Web_Activacion();
		$activaciones = $model->getLote($lote);

		$this->view->lote = $lote;
		$this->view->activaciones = $activaciones;
	}

	/**
	* Packs de Lotes
	*/
	public function packsAction(){

	}

	/**
	* Confirmacion de Asignacion
	*/
	public function asignacionAction(){
		if($this->getRequest()->isPost()){
			$id_vendedor = (int)$this->getRequest()->getParam('ven_id');
			$id_sucursal = (int)$this->getRequest()->getParam('suc_id');

			$sims = $this->getRequest()->getParam('ids');
			if(sizeof($sims) > 0 && $id_vendedor > 0){
				$auth = Zend_Auth::getInstance();
				$model = new default_models_Integracion_Functions();

				$usu_id = $auth->getIdentity()->idusuario;
				$vendedor = $this->view->cache_vendedores[$id_vendedor];

				$id_remito = $model->remito_sim_func(); //nro remito
				foreach($sims as $s){
					$model->asignacion_sim_func($s,$id_vendedor,$id_sucursal,$usu_id);
					$model->remito_asig_func($id_remito,$vendedor,$s,$usu_id,$id_vendedor);
				}

				$modelo = new default_model_Web_Activacion();
				$modelo->update(array('activacion_abonado'=>$id_vendedor)
					,"activacion_sim IN ('".implode("','",$sims)."')");
				//necesito un alfajor
				$this->view->id_remito = $id_remito;
			}
		}
	}


}
