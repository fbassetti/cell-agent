<?php

class Logistica_PedidosController extends BootPoint {

	public function init(){
		parent::init();
		$this->view->layout()->setLayout('default2');
	}

	/**
	* Listado de Pedidos
	*
	*/
	public function indexAction(){
		$tp = $this->getRequest()->getParam('tp');
		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;

		$perPage = 20;

		/* Fechas */
		$model = new default_models_Web_Pedidos();
		$pedidos = $model->getPedidos($this->usu_id,null,null,$page,$perPage,$this->usu_id);
		$total = $model->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
		$paginas = ceil($total/$perPage);

		$this->view->pedidos = $pedidos;
		$this->view->total = $total;
		$this->view->paginas = $paginas;
		/* Fechas */
	}

	/**
	* Alta de Pedido
	*
	*/
	public function altaAction(){
		$modelo = new default_models_Web_Virtual();
		$productos = $modelo->getProductos($this->usu_id);

		$this->view->productos = $productos;
	}

	public function verAction(){
		$this->editarAction();
	}

	/**
	* Editar Pedido
	* REVISAR
	*/
	public function editarAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');

		$model = new default_models_Web_Pedidos();
		$pedido = $model->find($ped_id)->current()->toArray(); //usu

		$productos = $model->getProductos($ped_id);

		//$form = new Logistica_forms_pedidos();
//		$form->populate($pedido);

//		$this->view->form = $form;

//		$this->view->currency = new Zend_Currency();
		$this->view->productos = $productos;
		$this->view->pedido = $pedido;
		$this->view->ped_id = $ped_id;
	}

	/**
	* Grabar cambios de cantidades
	* REVISAR
	*/
	public function grabarAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');

		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			$form = new Logistica_forms_pedidos();
			if($form->isValid($post)){
				$values = $form->getValues();
				$modelPed = new default_models_Web_Pedidos();

				$cant = $this->getRequest()->getParam('cant');
				if(!empty($cant)){
					foreach($cant as $id => $v){
						$modelPed->updatePedProducto($id,array('cant'=>$v));
					}
				}
				$modelPed->find($ped_id)->current()->setFromArray($values)->save();
			}
		}
		$this->_redirect('/logistica/pedidos/editar/ped_id/'.$ped_id);
	}

	/**
	* Guardar Cantidades de Virtual
	*
	*/
	public function guardarAction(){
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			$modelPed = new default_models_Web_Virtual();

			$cant = $this->getRequest()->getParam('cant');
			if(!empty($cant)){
				foreach($cant as $id => $v){
					$modelPed->updatePedProducto($id,array('cant'=>$v));
				}
			}
		}
		$this->_redirect('/logistica/pedidos/alta');
	}

	/**
	* Cambia el estado de un pedido
	* IMPLEMENTAR
	*/
	public function cambiarEstadoAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');
		$st = (int)$this->getRequest()->getParam('st');

		$model = new default_models_Web_Pedidos();
		$pedido = $model->find($ped_id)->current();
		if($pedido['ped_status'] < $st){
			$values = array('ped_status'=>$st);

			$pedido->setFromArray($values)->save();
		}
		$this->_redirect('/logistica/pedidos/ver/ped_id/'.$ped_id);
	}

	/**
	* Agrega Producto o Articulo
	* REVISAR EN PEDIDOS
	*/
	public function agregaProductoAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');
		$tipo = $this->getRequest()->getParam('tp');
		$productos = array($this->getRequest()->getParam('id'));

		if($ped_id > 0){
			$model = new default_models_Web_Pedidos();
			$model->insertaProductos($ped_id,$productos,$tipo);
			$model->update(array('ped_fhult' => new Zend_Db_Expr('NOW()')),"ped_id={$ped_id}");

			$this->_redirect('/logistica/pedidos/editar/ped_id/'.$ped_id);
		}
		#se añaden al Virtual
		$modelPro = new default_models_Web_Virtual();
		$modelPro->insertaProductos($this->usu_id,$productos,$tipo);

		$this->_redirect('/logistica/pedidos/alta');
	}

	/**
	* Elimina productos del Pedido
	* Revisar Pedido
	*/
	public function borraProductoAction(){
		$ped_id = (int)$this->getRequest()->getParam('ped_id');
		$ppr_id = (int)$this->getRequest()->getParam('ppr_id');

		if($ped_id > 0){
			$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
			$adapter->delete('ped_presu_prod',"ppr_id={$ppr_id}");

			$model = new default_models_Web_Pedidos();
			$model->update(array('ped_fhult'=>new Zend_Db_Expr('NOW()'),),"ped_id={$ped_id}");

			$this->_redirect('/logistica/pedidos/editar/ped_id/'.$ped_id);
		}
		#remueve del virtual
		$modelPro = new default_models_Web_Virtual();
		$modelPro->find($ppr_id)->current()->delete(); //vir_id

		$this->_redirect('/logistica/pedidos/alta');
	}

	/**
	* Buscar Equipos
	*
	*/
	public function equiposAction(){
		$id = (int)$this->getRequest()->getParam('id');

		$model = new default_models_Integracion_ModelosView();
		$modelos = $model->getDefaultAdapter()->fetchAll(
		$model->select(true)->where('idmarca=?',$id)->order(array('idmarca','Modelo')));

		$this->view->resultados = $modelos;
		$this->view->mar_id = $id;
	}

	/**
	* Buscar Articulos
	* @param $grupo
	* @param $page
	*/
	public function accesoriosAction(){
		$id = (int)$this->getRequest()->getParam('id');
		$grupo = $this->view->cache_grupos[$id];

		$page = (int)$this->getRequest()->getParam('pagina');
		if($page < 1)
			$page = 1;

		$perPage = 20;

		$modelo = new default_models_Integracion_ArticulosView();
		$articulos = $modelo->getListado($grupo,$page,$perPage);
		$total = $modelo->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
		$paginas = ceil($total/$perPage);

		$this->view->resultados = $articulos;
		$this->view->total = $total;
		$this->view->paginas = $paginas;
		$this->view->gru_id = $id;
	}

	/**
	* Migrar los datos temporales del pedido
	*
	*/
	public function procesarAction(){
		$modelo = new default_models_Web_Virtual();
		$productos = $modelo->getProductos($this->usu_id);
		if(!empty($productos)){
			$model = new default_models_Web_Pedidos();
			$model->createRow(array('usu_id' => $this->usu_id))->save();

			$id = $model->getDefaultAdapter()->lastInsertId();
			$sql = "INSERT INTO ped_presu_prod (ped_id,pro_id,pro_tipo,cant) "
			. "SELECT {$id},pro_id, pro_tipo, cant FROM web.vir_virtual WHERE usu_id={$this->usu_id}";
			$model->getAdapter()->query($sql);

			$modelo->delete("usu_id={$this->usu_id}");
		}
		$this->_redirect('/logistica/pedidos');
	}

	/**
	* Chequear
	*
	*/
	public function reportesAction(){
		$tipo = $this->getRequest()->getParam('tipo');
		$page = (int)$this->getRequest()->getParam('pagina');

		$perPage = 20;
		if($page < 1)
			$page = 1;

		$model = new default_models_Web_Reportes();
		$reportes = $model->getReportes($tipo,$page,$perPage);
		$total = $model->getDefaultAdapter()->fetchOne('SELECT FOUND_ROWS()');
		$paginas = ceil($total/$perPage);

		$this->view->paginas = $paginas;
		$this->view->total = $total;
		$this->view->reportes = $reportes;
	}

	/**
	* Reportar Equipo/Articulo
	*
	*/
	public function reportarAction(){
		$form = new Logistica_forms_reportes();
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($form->isValid($post)){
				$values = $form->getValues();
				$values['usu_id'] = $this->auth->getIdentity()->idusuario;
				$values['rep_fh'] = new Zend_Db_Expr('NOW()');

				$model = new default_models_Web_Reportes();
				$model->createRow($values)->save();
				//
				//Mostrar template
				die();
			}
		}

		$this->view->form = $form;
	}
}