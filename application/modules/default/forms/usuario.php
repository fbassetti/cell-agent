<?php

class default_models_usuario extends Zend_Form {

	public function init(){
		$sname = $this->createElement('text','usr_sname')
			->setRequired(true)
			->addValidator('notEmpty');
		$sfullname = $this->createElement('text','usr_sfullname')
			->setRequired(true)
			->addValidator('notEmpty');

		$this->addElements(array($sname,$sfullname));
	}
}