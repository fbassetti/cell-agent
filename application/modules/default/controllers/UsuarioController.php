<?php

class UsuarioController extends BootPoint {

	public function indexAction(){
		$this->view->usuario = (array)$this->auth->getStorage()->read();
	}

}