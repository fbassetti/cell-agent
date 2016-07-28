<?php

class Acceso_forms_roles extends Zend_Form {

	public function init(){
		$nombre = $this->createElement('text','rol_nombre')
			->setRequired(true);

		$this->addElements(array($nombre));
	}
}