<?php

class Acl extends Zend_Acl {

	public $rol = 'user';

	public function __construct(Zend_Auth $auth){
		$this->addRole($this->rol);

		$this->addResource('default');

		$this->allow($this->rol,array('default')); //permitir modulo default
	}

	public function permite($module,$controller,$action){
		if($this->has($module)){
			if($this->isAllowed($this->rol,$module)) return true;
		}
		elseif($this->has("{$module}:{$controller}")){
			if($this->isAllowed($this->rol,"{$module}:{$controller}",$action)) return true;
		}
		return false;
	}
}
