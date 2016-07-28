<?php

class Logistica_forms_consultarEquipos extends Zend_Form {

	public function init(){
		$idmsn = $this->createElement('text','idmsn')
		->setAttrib('class','input')
		->setRequired(true)
		->addValidator('notEmpty',true);

		$this->addElement($idmsn);
	}
}