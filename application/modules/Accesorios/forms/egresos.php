<?php

class Accesorios_forms_egresos extends Zend_Form {

	public function init(){
		$suc_id = $this->createElement('select','suc_id')
		->addMultiOption('','[Sucursal]')
		->setRegisterInArrayValidator(false);

		$pun_id = $this->createElement('select','pun_id')
		->setRegisterInArrayValidator(false);

		$ope = $this->createElement('select','ope')
		->setAttrib('class','styled-select')
		->addMultiOptions(array('Venta'=>'Venta','Asignacion'=>'Asignacion'));

		$this->addElements(array($suc_id,$pun_id,$ope));
	}
}