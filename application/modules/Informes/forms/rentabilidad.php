<?php

class Informes_forms_rentabilidad extends Zend_Form {

	public function init(){
		$suc_id = $this->createElement('select','suc_id')
		->setRequired(true)
		->addMultiOption('','[Sucursal]')
		->setRegisterInArrayValidator(false);

		$this->addElements(array($suc_id,$yy,$mm));
	}
}