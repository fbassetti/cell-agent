<?php

class ErrorController extends Zend_Controller_Action{

	public function errorAction(){
		switch($this->_getParam('error_handler')->type){
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Pagina no encontrada';
			break;
			default:
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Application Error';
				$this->view->exception = $this->_getParam('error_handler')->exception->getMessage();
				$this->view->trace = nl2br($this->_getParam('error_handler')->exception->getTraceAsString());
			break;
		}
	}
}