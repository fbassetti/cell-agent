<?php

class BootPoint extends Zend_Controller_Action {

	public $usu_id = 0;

	public function init(){
		$this->view->layout()->setLayout('default2');

		$this->auth = Zend_Auth::getInstance();
		if(!$this->auth->hasIdentity()){ return; }

		$acl = $this->view->navigation()->getAcl();
		$paginas = $this->view->navigation()->getContainer()->toArray();
		foreach($paginas as $i => $page){
			if(!empty($page['pages'])){
				foreach($page['pages'] as $a => $b){
					if($b['type'] != 'Zend_Navigation_Page_Mvc'){ continue; }
					if($acl->has($b['module'])){
						if($acl->isAllowed($acl->rol,$b['module']))
							continue;
					}
					if($acl->has($b['module'].':'.$b['controller'])){
						if(is_null($b['action']))
							$b['action'] = 'index';
						if($acl->isAllowed($acl->rol,$b['module'].':'.$b['controller'],$b['action']))
							continue;
					}
					unset($paginas[$i]['pages'][$a]);
				}
			}
			if($page['type'] != 'Zend_Navigation_Page_Mvc'){
				if($page['class'] == 'submenu' && empty($paginas[$i]['pages'])){
					unset($paginas[$i]);
				}
				continue;
			}
			if($acl->has($page['module'])){
				if($acl->isAllowed($acl->rol,$page['module']))
					continue;
			}
			if($acl->has($page['module'].':'.$page['controller'])){
				if($acl->isAllowed($acl->rol,$page['module'].':'.$page['controller']))
					continue;
			}
			unset($paginas[$i]);
		}
		$this->view->navigation()->getContainer()->setPages($paginas);

		$this->view->navigation()->findByLabel('Usuario')->setLabel('+ '.$this->auth->getIdentity()->username);
		$this->initCache();
	}

	public function postDispatch(){
		if($this->getRequest()->getParam('print') != null){
			$this->_helper->layout()->setLayout('print');
		}
	}

	/**
	* Cacheo de variables
	*
	*/
	private function initCache(){
		$cache = $this->getInvokeArg('bootstrap')->getResource('cache');
		if(!$config = $cache->load('mainconfig')){
			$sucursales = new default_models_Integracion_SucursalesView();
			$vendedores = new default_models_Integracion_PuntosView();
			$marcas = new default_models_Integracion_MarcasView();
			$operatorias = new default_models_Integracion_OperatoriasView();

			$config = array(
				'sucursales' => $sucursales->getDefaultAdapter()->fetchPairs($sucursales->select(true)->order('NombreSuc')),
				'vendedores' => $vendedores->getDefaultAdapter()->fetchPairs($vendedores->select(true)->reset('columns')->where('tipovendedor!=?','L')->columns(new Zend_Db_Expr('idpunto,NombrePunto'))->order('NombrePunto')),
				'puntos'  => $vendedores->getDefaultAdapter()->fetchPairs($vendedores->select(true)->reset('columns')->columns(new Zend_Db_Expr('idpunto,NombrePunto'))->where('tipovendedor=?','L')->where('centro_costo=?',1)->order('NombrePunto')),
				'marcas' => $marcas->getDefaultAdapter()->fetchPairs($marcas->select(true)->order('Marca')),
				'operatorias' => $operatorias->getDefaultAdapter()->fetchPairs($operatorias->select(true)->order('Operatoria'))
			);
			$cache->save($config,'mainconfig');
		}
		$this->view->cache_sucursales = $config['sucursales'];
		$this->view->cache_vendedores = $config['vendedores'];
		$this->view->cache_puntos = $config['puntos'];
		$this->view->cache_marcas = $config['marcas'];
		$this->view->cache_operatorias = $config['operatorias'];

		$this->view->cache_meses = array(
		'01' => 'Enero',
		'02' => 'Febrero',
		'03' => 'Marzo',
		'04' => 'Abril',
		'05' => 'Mayo',
		'06' => 'Junio',
		'07' => 'Julio',
		'08' => 'Agosto',
		'09' => 'Septiembre',
		'10' => 'Octubre',
		'11' => 'Noviembre',
		'12' => 'Diciembre',
		);

		$this->view->cache_localidades = array(
		'23-01' => 'Cordoba',
		'24-01' => 'Rosario',
		'27-01' => 'Santa Fe',
		'24-09' => 'San Lorenzo',
		);
		$this->view->cache_ped_status = array('Iniciado','Autorizado','Confirmado');

		$this->view->cache_grupos = array(
		"Bateria",
		"Cable de Datos",
		"Cargador",
		"Correa",
		"Cover",
		"Estuche",
		"Film",
		"Lapiz",
		"Manos libres",
		"Memoria",
		"Promo"
		);
	}

	public function datepickerHeaders(){
		$this->view->headScript()
		->appendFile($this->view->baseUrl()."/public/js/jquery-ui-1.8.18.custom.min.js",'text/javascript')
		->appendFile($this->view->baseUrl()."/public/js/datepicker.js",'text/javascript');
		$this->view->headLink()
		->appendStylesheet($this->view->baseUrl()."/public/css/ui-lightness/jquery-ui-1.8.18.custom.css",'all');

	}
}