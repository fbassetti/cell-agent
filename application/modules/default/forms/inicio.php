<?php

class default_forms_inicio extends Zend_Form {

	public function init(){
		$username = $this->createElement('text','username')
			->setRequired(true)
			->addFilter('stringToLower')
			->setAttrib('class','input')
			->addValidator('notEmpty',false)
			->setAttrib('placeholder','Usuario');

		$password = $this->createElement('password','password')
			->setRequired(true)
			->setAttrib('class','input')
			->addValidator('notEmpty',false)
			->setAttrib('placeholder',utf8_encode('Contraseña'));

		$this->addElements(array($username,$password));
	}
}
