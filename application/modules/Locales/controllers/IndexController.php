<?php

class Locales_IndexController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	public function indexAction(){
		$modelo = new default_models_Web_Locales();
		$locales = $modelo->getDefaultAdapter()->fetchAll($modelo->select());

		$this->view->locales = $locales;
	}

	public function gastosAction(){
	}

	public function camaraAction(){
		$loc_id = $this->getRequest()->getParam('loc_id');
		$modelo = new default_models_Web_Locales();

		$this->view->local = $modelo->find($loc_id)->current();

		$this->view->headScript()
		->appendFile($this->view->baseUrl().'/public/archivos/itemname.js','text/javascript')
		->appendFile($this->view->baseUrl().'/public/archivos/msg.js','text/javascript')
		->appendFile($this->view->baseUrl().'/public/archivos/cookies.js','text/javascript')
		->appendFile($this->view->baseUrl().'/public/archivos/warn.js','text/javascript')
		->appendFile($this->view->baseUrl().'/public/js/cams.js','text/javascript');
	}

	public function getCamAction(){
		if(!$this->getRequest()->isXmlHttpRequest())
			die();

		$loc_id = $this->getRequest()->getParam('loc_id');
		$modelo = new default_models_Web_Locales();

		$local = $modelo->find($loc_id)->current()->toArray();
		$this->_helper->json(array(
		'host'=> $local['loc_ip'],
		'port'=> $local['loc_puerto'],
		'user'=> $local['loc_usu_cam'],
		'pass'=> $local['loc_usu_pas'],
		));
	}
}