<?php

class Zend_View_Helper_LinkImprimir {

	public function linkimprimir(){
		$front = Zend_Controller_Front::getInstance();
		$request = $front->getRequest();

		$page = 1;
		if($request->isGet()){
			$page = (int)$request->getParam('pagina');
			if($page < 1) $page = 1;
		}

		$baseUrl = $front->getBaseUrl().'/'.$this->getParams($request->getParams());
	}

	private function getParams($params){
		$s = "{$params['module']}/{$params['controller']}/{$params['action']}";
		unset($params['action'],$params['controller'],$params['module'],$params['pagina']);

		foreach($params as $i => $v)
			if($v != '')
				$s .= "/{$i}/".preg_replace('#/#','_',$v);
		return $s;
	}

}