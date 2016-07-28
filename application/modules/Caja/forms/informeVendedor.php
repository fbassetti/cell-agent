<?php

class Caja_forms_informeVendedor extends Zend_Form {

	public function init(){
		$suc_id = $this->createElement('select','suc_id')
		->addMultiOption('','[Sucursal]')
		->setRegisterInArrayValidator(false);

		$pun_id = $this->createElement('select','pun_id')
		->setRegisterInArrayValidator(false);

		$this->addElements(array($suc_id,$pun_id));
	}
}