<?php

class Zend_View_Helper_Observacion extends Zend_View_Helper_Abstract {
	
	public function observacion($cli_id,$pre_id){
		$form = new panel_forms_observaciones();
		$form->cli_id->setValue($cli_id);
		$form->pre_id->setValue($pre_id);
		$form->obs_prioridad->setValue(3);
		$this->view->obsform = $form;
		
		return $this->view->render('observaciones/modal.phtml');
	}
}