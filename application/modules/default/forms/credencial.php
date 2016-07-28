<?php

class default_forms_credencial extends Zend_Form {

	public function init(){
		$spwd = $this->createElement('password','usr_spwd')
			->setRequired(true)
			->addValidator('notEmpty');

		$rspwd = $this->createElement('password','rspwd')
			->setRequired(true)
			->addValidator('notEmpty');

		$rrspwd = $this->createElement('password','rrspwd')
			->setRequired(true)
			->addValidator('notEmpty');

		$this->addElements(array($spwd,$rspwd,$rrspwd));
	}
}