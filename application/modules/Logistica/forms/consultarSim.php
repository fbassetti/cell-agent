<?php

class Logistica_forms_consultarSim extends Zend_Form {

	public function init(){
		$idcard = $this->createElement('text','idcard')
		->setRequired(true)
		->setAttribs(array(
			'class' => 'input',
			'size' => 22,
			'maxlength' => 19
		))
		->addValidator('notEmpty',true);

		$this->addElement($idcard);
	}
}