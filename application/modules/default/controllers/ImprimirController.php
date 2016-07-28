<?php

class ImprimirController extends BootPoint {

	public function indexAction(){
		$this->view->layout()->disableLayout();
		$post = $this->getRequest()->getPost();
		$body = urldecode($post['body']);

		$this->view->body = stripslashes($body);
	}

	public function exportarAction(){
		header('Content-Disposition: attachment; filename="export.html"');

		$this->view->layout()->disableLayout();
		$post = $this->getRequest()->getPost();
		$body = urldecode($post['body']);

		$this->view->body = stripslashes($body);
		$this->view->noprint = 1;
	}

	public function excelAction(){
		header('Content-Disposition: attachment; filename="export.xls"');

		$this->view->layout()->disableLayout();
		$post = $this->getRequest()->getPost();
		$body = urldecode($post['body']);

		$this->view->body = '<table>'.stripslashes($body).'</table>';
		$this->view->noprint = 1;
		$this->renderScript('imprimir/exportar.phtml');
	}
}