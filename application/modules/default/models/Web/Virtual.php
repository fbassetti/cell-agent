<?php

class default_models_Web_Virtual extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'vir_virtual';

	/**
	* Obtener Productos Uniendo Articulos
	*
	* @param mixed $usu_id
	* @return mixed
	*/
	public function getProductos($usu_id){
		$productos = $this->getDefaultAdapter()->fetchAll(
		$this->select(true)->reset('colums')
		->columns(array('pro_id','cant','pro_tipo'))
		->where('usu_id=?',$usu_id)->order('pro_tipo'));

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
		$this->update($data,"vir_id={$vir_id}");
	}
	/**
	* Inserta productos en Virtual
	*
	* @param mixed $usu_id
	* @param mixed $productos
	* @param mixed $tipo
	*/
	public function insertaProductos($usu_id,$productos,$tipo){
		$ids = $this->getDefaultAdapter()->fetchCol(
		$this->select(true)->reset('columns')->columns('pro_id')
		->where('usu_id=?',$usu_id)->where('pro_tipo=?',$tipo));

		$diferencia = array_diff($productos,$ids);
		if(!empty($diferencia)){
			foreach($diferencia as $i => $v){
				$this->insert(array(
				'pro_tipo' => $tipo,
				'pro_id' => $v,
				'usu_id' => $usu_id,
				'cant' => 1
				));
			}
		}
	}
}
