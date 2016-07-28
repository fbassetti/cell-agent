<?php

class panel_forms_observaciones extends Zend_Form {

	public function init(){
		$obs_id = $this->createElement('hidden','obs_id')
			->setAttrib('class','req');
		$cli_id = $this->createElement('hidden','cli_id')
			->setAllowEmpty(false);
		$pre_id = $this->createElement('hidden','pre_id');

		$obs_fh_alarma = $this->createElement('text','obs_fh_alarma')
			->setAttrib('class','input');

		$obs_comentario = $this->createElement('textarea','obs_comentario')
			->setAllowEmpty(false)
			->setAttrib('class','req input')
			->setAttrib('rows',4)
			->setAttrib('cols',50);

		$obs_prioridad	= $this->createElement('radio','obs_prioridad')
			->setAttrib('style','vertical-align:middle;')
			->addMultiOptions(array('1'=>'Alta','2'=>'Media','3'=>'Baja','4'=>'Ninguna'))
			->setSeparator('&nbsp; ');

		$this->addElements(array($obs_id,$cli_id,$pre_id,$obs_fh_alarma,$obs_comentario,$obs_prioridad));
	}
}