<?php

class default_models_Web_Pedidos extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'ped_pedidos';

	/**
	* Obtener Pedidos de Usuario
	*
	* @param mixed $usu_id
	* @param mixed $desde
	* @param mixed $hasta
	* @param mixed $page
	* @param mixed $perPage
	* @return array
	*/
	public function getPedidos($usu_id,$desde,$hasta,$page,$perPage){
		$select = $this->select(true)
		->setIntegrityCheck(false)
		->reset('columns')
		->columns(array(
		new Zend_Db_Expr('SQL_CALC_FOUND_ROWS ped_pedidos.*'),
		'DATE_FORMAT(ped_fh,"%d/%m/%Y") as fh',
		'DATE_FORMAT(ped_fhult,"%d/%m/%Y") as fhult'
		))
		->limitPage($page,$perPage)->order('ped_fh DESC');

		if(is_null($usu_id)){
			$select->joinLeft('usuarios_view','idusuario=usu_id',"*",'integracion');
		}
		else{
			$select->where('usu_id=?',$usu_id);
		}

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Productos de Pedido
	*
	* @param mixed $ped_id
	* @return mixed
	*/
	public function getProductos($ped_id){
		$select = $this->getDefaultAdapter()->select()
		->where('ped_id=?',$ped_id)
		->order('Articulo');

		$productos = $this->getDefaultAdapter()->fetchAssoc(
		$this->getDefaultAdapter()->select()
		->from('ped_presu_prod as ped','*',$this->_schema)
		->columns(array('pro_id','cant','pro_tipo'))
		->where('ped_id=?',$ped_id)->order('pro_tipo'));

		if(empty($productos))
			return $productos;
		/**
		*
		*/
		$ids_art = $ids_equ = array();
		foreach($productos as $i => $v){
			if($v['pro_tipo'] == 'A')
				$ids_art[] = $v['pro_id']; //codigobarra
			else
				$ids_equ[] = $v['pro_id']; //idmodelo
		}
		if(!empty($ids_art))
			$productos = $this->agregaArticulos($ids_art,$productos);
		if(!empty($ids_equ))
			$productos = $this->agregaEquipos($ids_equ,$productos);

		return $productos;
	}

	public function agregaArticulos($ids,$productos){
		$select = $this->getDefaultAdapter()->select()
		->from('articulos_view',array('CodigoBarra','Articulo'),'integracion')
		->where('CodigoBarra IN (?)',$ids)
		->order('Articulo');

		$articulos = $this->getDefaultAdapter()->fetchAll($select);
		foreach($articulos as $i => $v){
			foreach($productos as $a => $b){
				if($v['CodigoBarra'] == $b['pro_id']){
					$productos[$a]['articulo'] = $v['Articulo'];
					continue;
				}
			}
		}
		return $productos;
	}

	public function agregaEquipos($ids,$productos){
		$select = $this->getDefaultAdapter()->select()
		->from('modelos_view','*','integracion')
		->where('idmodelo IN (?)',$ids)
		->order('Modelo');

		$articulos = $this->getDefaultAdapter()->fetchAll($select);
		foreach($articulos as $i => $v){
			foreach($productos as $a => $b){
				if($v['idmodelo'] == $b['pro_id']){
					$productos[$a]['articulo'] = $v['Modelo'];
					$productos[$a]['idmarca'] = $v['idmarca'];
					continue;
				}
			}
		}
		return $productos;
	}

	public function updatePedProducto($vir_id,$data){
		$this->getDefaultAdapter()->update('ped_presu_prod',$data,"ppr_id={$ppr_id}");
	}

	/**
	* Inserta Productos en Pedido
	*
	* @param mixed $ped_id
	* @param mixed $productos
	* @param mixed $tipo
	*/
	public function insertaProductos($ped_id,$productos,$tipo){
		$ids = $this->getDefaultAdapter()->fetchCol(
		$this->select()->reset('columns')->columns('pro_id')->where('ped_id=?',$ped_id)->where('pro_tipo=?',$tipo));

		$diferencia = array_diff($productos,$ids);
		if(!empty($diferencia)){
			foreach($diferencia as $i => $v){
				$this->insert(array(
				'pro_tipo' => $tipo,
				'pro_id' => $i,
				'ped_id' => $ped_id,
				'cant' => 1
				));
			}
		}
		//
	}

	public function getCotizaciones($ped_id){
		return $this->getDefaultAdapter()->fetchAll($this->getDefaultAdapter()->select()
		->from('cot_cotizaciones AS c','*','web')
		->joinLeft('prv_proveedores AS p','c.prv_id=p.prv_id','prv_rsocial','web')
		->where('ped_id=?',$ped_id));
	}
}