<?php

class Logistica_CotizacionesController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	public function indexAction(){
		$tp = $this->getRequest()->getParam('tp');
		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;

		$perPage = 20;

		/* Fechas */
		$model = new default_models_Web_Pedidos();
		$pedidos = $model->getPedidos(null,null,null,$page,$perPage);
		$total = $model->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
		$paginas = ceil($total/$perPage);

		$this->view->pedidos = $pedidos;
		$this->view->total = $total;
		$this->view->paginas = $paginas;
	}

	public function verAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');

		$model = new default_models_Web_Pedidos();
		$pedido = $model->find($ped_id)->current()->toArray(); //usu

		$productos = $model->getProductos($ped_id);
		if($cotizaciones = $model->getCotizaciones($ped_id)){
			$this->view->currency = new Zend_Currency();
			$this->view->cotizaciones = $cotizaciones;
		}

		$this->view->productos = $productos;
		$this->view->pedido = $pedido;
		$this->view->ped_id = $ped_id;

	}

	/**
	* Buscar Proveedor para añadir
	*
	*/
	public function buscarProveedorAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');

		$model = new default_models_Web_Proveedores();
		$resultados = $model->getProveedores();

		$this->view->resultados = $resultados;
		$this->view->ped_id = $ped_id;
	}

	/**
	* Agregar Cotizacion al pedido
	* Controlar el estado
	*/
	public function agregarAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');
		$prv_id = (int)$this->getRequest()->getParam('prv_id');

		$model = new default_models_Web_Cotizaciones();
		$model->createRow(array(
		'ped_id' => $ped_id,
		'prv_id' => $prv_id,
		'cot_precio' => 0
		))->save();

		$this->_redirect('/logistica/cotizaciones/ver/ped_id/'.$ped_id);
	}

	/**
	* Eliminar Cotizacion del Pedido
	* Controlar el estado
	*/
	public function quitarAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');
		$cot_id = (int)$this->getRequest()->getParam('cot_id');

		$model = new default_models_Web_Cotizaciones();
		$model->find($cot_id)->current()->delete();

		$this->_redirect('/logistica/cotizaciones/ver/ped_id/'.$ped_id);
	}
}
