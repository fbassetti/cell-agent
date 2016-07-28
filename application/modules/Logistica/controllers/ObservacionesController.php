<?php

class Logistica_ObservacionesController extends BootPoint {

	public function indexAction(){
		die();
	}

	/**
	* Inserta o Actualiza Observación
	*
	*/
	public function jsonAction(){
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			$form = new panel_forms_observaciones();
			if($form->isValid($post)){
				$obs_id = (int)$this->getRequest()->getParam('obs_id');

				$model = new panel_models_Observaciones();
				$values = $form->getValues();

				if($values['obs_fh_alarma'] != ''){
					$ZendDate = new Zend_Date($values['obs_fh_alarma'],'dd/MM/y','es');
					$values['obs_fh_alarma'] = $ZendDate->get('y-MM-dd');
				}

				$values['obs_fh_mod'] = new Zend_Db_Expr('NOW()');
				if($obs_id == 0){
					$values['obs_fh_creado'] = new Zend_Db_Expr('NOW()');
					$values['obs_id_creado'] = $this->auth->getIdentity()->usu_id;
					$model->fetchNew()->setFromArray($values)->save();
				}
				else{
					unset($values['obs_id']);
					unset($values['cli_id']);
					unset($values['ped_id']);
					$model->find($obs_id)->current()->setFromArray($values)->save();
				}
				$this->_helper->json(array('st'=>0));
			}

			$this->_helper->json(array('st'=>1,'msg'=>$form->getErrors()));
		}
	}

	/**
	* Obtiene Información de Observación
	*
	*/
	public function getInfoAction(){
		$obs_id = (int)$this->getRequest()->getParam('obs_id');

		$model = new panel_models_Observaciones();
		$row = $model->getObservacion($obs_id);

		$this->_helper->json(array('st'=>0,'data'=>$row));
	}

	/**
	* Elimina Observación
	*
	*/
	public function deleteAction(){
		$obs_id = (int)$this->getRequest()->getParam('obs_id');

		$model = new panel_models_Observaciones();
		$model->delete('obs_id='.$obs_id);
		$this->_helper->json(array('st'=>0));
	}
}