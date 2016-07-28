<?php

class Zend_View_Helper_Paginador {

	public function paginador($paginas=1){
		if($paginas < 2)
			return;
		$front = Zend_Controller_Front::getInstance();
		$request = $front->getRequest();

		$page = 1;
		if($request->isGet()){
			$page = (int)$request->getParam('pagina');
			if($page < 1) $page = 1;
		}

		$baseUrl = $front->getBaseUrl().'/'.$this->getParams($request->getParams());

		$_actual = $page;
		$retorno = '';
		$margen = 10;
		if($page > $margen && $page <= $paginas){
			$inicio = $_actual-$margen;
			$offset = $margen+$_actual;
		}
		else{
			$inicio = $_actual = 1;
			$offset = $margen*2;
		}
		for($i=$inicio;$i<$offset;$i++){
			if($i > $paginas){ break; }
			if($i == $page){ $retorno .= "&nbsp;<b style=\"color:#999;\">{$i}</b>&nbsp;"; }
			elseif($i == 1) { $retorno .= "&nbsp;<a href=\"{$baseUrl}\">{$i}</a>&nbsp;"; }
			else { $retorno .= "&nbsp;<a href=\"{$baseUrl}/pagina/{$i}\">{$i}</a>&nbsp;"; }
		}

		if($page > 1)
			$s = "<a class=\"fst\" href=\"{$baseUrl}/pagina/".($page-1)."\">&laquo; Anterior</a> &nbsp;";
		else
			$s = "<span class=\"fst\">&laquo; Anterior</span>";
		if($page > 1)
			$s = "<a class=\"fst\" href=\"{$baseUrl}\">&laquo; Primeros</a> &nbsp;".$s;
		else
			$s = "<span class=\"fst\">&laquo; Primeros</span> &nbsp;".$s;

		$s .= $retorno;
		if($page < $paginas)
			$s .= "&nbsp; <a class=\"lst\" href=\"{$baseUrl}/pagina/{$paginas}\">Ultimos &raquo;</a>";
		else
			$s .= "&nbsp; <span class=\"lst\">Ultimos &raquo;</span>";
		if($page+1 <= $paginas)
			$s .= "&nbsp; <a class=\"lst\" href=\"{$baseUrl}/pagina/".($page+1)."\">Siguiente &raquo;</a> ";
		else
			$s .= "&nbsp; <span class=\"lst\">Siguiente &raquo;</span> ";

		return '<div id="pages">'.$s.'</div>';
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
