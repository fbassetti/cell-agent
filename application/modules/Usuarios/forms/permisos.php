<?php

class Usuarios_forms_permisos extends Zend_Form {

	public function init(){
		$recursos = $this->createElement('multiCheckbox','recursos')
			->setAllowEmpty(true)
			->setSeparator('__')
			->setAttrib('disable',array('default'))
			->setAttrib('data-mini','true')
			->setValue(array('default'))
			->setRegisterInArrayValidator(false);

		$this->addElement($recursos);
	}
}