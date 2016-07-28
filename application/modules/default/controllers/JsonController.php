<?php

class JsonController extends BootPoint {

	/**
	* Listado de Modelos en Ajax
	*
	*/
	public function modelosAction(){
		$cache = $this->getFrontController()->getParam('bootstrap')->getResource('cache');
		if(!$new = $cache->load('cache_modelos')){
			$model = new default_models_Integracion_ModelosView();
			$modelos = $model->fetchAll($model->select(true)->order(new Zend_Db_Expr('idmarca,Modelo')));

			$new = array();
			foreach($modelos as $i => $v){
				$new[$v['idmarca']][] = array(
				'idmodelo'	=> $v['idmodelo'],
				'modelo'	=> $v['Modelo']
				);
			}
			$cache->save($new,'cache_modelos');
		}
		$this->_helper->json($new);
	}

	/**
	* Puntos de Venta en Ajax
	*
	*/
	public function puntosVentaAction(){
		$cache = $this->getFrontController()->getParam('bootstrap')->getResource('cache');
		if(!$new = $cache->load('ajax_puntos')){
			$model = new default_models_Integracion_PuntosView();
			$puntos = $model->fetchAll($model->select(true)->order('NombrePunto')
			->where('tipovendedor=?','L')->where('centro_costo=?',1));

			$new = array();
			foreach($puntos as $i => $v){
				$new[$v['idsucursal']][] = array(
				'idpunto'	=> $v['idpunto'],
				'nombre'	=> $v['NombrePunto']
				);
			}
			$cache->save($new,'ajax_puntos');
		}
		$this->_helper->json($new);
	}

	/**
	* Vendedores en Ajax
	*
	*/
	public function vendedoresAction(){
		$cache = $this->getFrontController()->getParam('bootstrap')->getResource('cache');
		if(!$new = $cache->load('ajax_vendedores')){
			$model = new default_models_Integracion_PuntosView();
			$vendedores = $model->fetchAll($model->select(true)->order('NombrePunto')
			->where('tipovendedor!=?','L'));

			$new = array();
			foreach($vendedores as $i => $v){
				$new[$v['idsucursal']][] = array(
				'idpunto'	=> $v['idpunto'],
				'nombre'	=> $v['NombrePunto']
				);
			}
			$cache->save($new,'ajax_vendedores');
		}
		$this->_helper->json($new);
	}

	/**
	* Accesorios en Ajax
	*
	*/
	public function accesoriosAction(){
		$cache = $this->getFrontController()->getParam('bootstrap')->getResource('cache');
		if(!$articulos = $cache->load('ajax_articulos')){
			$model = new default_models_Integracion_ArticulosView();
			$articulos = $model->getDefaultAdapter()->fetchAssoc($model->select()->order('Articulo'));

			$cache->save($articulos,'ajax_articulos');
		}
		$this->_helper->json($articulos);
	}
}