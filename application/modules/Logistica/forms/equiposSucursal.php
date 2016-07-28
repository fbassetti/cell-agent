<?php

class Logistica_forms_equiposSucursal extends Zend_Form {

	public function init(){
		$suc_id = $this->createElement('select','suc_id')
		->addMultiOption('','[Sucursales]')
		->setRegisterInArrayValidator(false);

		$pun_id = $this->createElement('select','pun_id')
		->addMultiOption('','[Puntos de Venta]')
		->setRegisterInArrayValidator(false);

		$mar_id = $this->createElement('select','mar_id')
		->addMultiOption('','[Marcas]')
		->setAttrib('style','display:none')
		->setRegisterInArrayValidator(false);

		$mod_id = $this->createElement('select','mod_id')
		->addMultiOption('','[Modelos]')
		->setRegisterInArrayValidator(false);

		$this->addElements(array($suc_id,$pun_id,$mar_id,$mod_id));
	}
}