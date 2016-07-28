<?php

class Accesorios_models_bajomovimiento extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';

	/**
	* Obtener los accesorios que ingresaron
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $desde
	* @param mixed $hasta
	*/
	public function obtenerIngresos($suc_id,$pun_id,$desde,$hasta){
		$select = $this->getDefaultAdapter()->select()
			->from('acce_ing_view',array('codigobarra','descripcion','SUM(cantidad) as total'),$this->_schema)
			->where("dt_active BETWEEN '{$desde}' AND '{$hasta} 23:59:00'")
			->group('codigobarra')
			->order('descripcion');

		if($suc_id > 0)
			$select->where('idsucursal=?',$suc_id);
		if($pun_id > 0)
			$select->where('idpunto=?',$pun_id);

		return $this->getDefaultAdapter()->fetchAssoc($select);
	}

	/**
	* Obtener los accesorios que egresaron por venta
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $desde
	* @param mixed $hasta
	* @param array $ingresos
	*/
	public function obtenerEgresos($suc_id,$pun_id,$desde,$hasta,$ingresos){
		$select = $this->getDefaultAdapter()->select()
			->from('acce_egr_view',array('codigobarra','COUNT(cantidad)'),$this->_schema)
			->where("dt_active BETWEEN '{$desde}' AND '{$hasta} 23:59:00'")
			->where('operacion=?','Venta')
			->where("codigobarra IN ('".implode("','",$ingresos)."')")
			->group('codigobarra')
			->order('COUNT(cantidad)');

		if($suc_id > 0)
			$select->where('idsucursal=?',$suc_id);
		if($pun_id > 0)
			$select->where('idpunto=?',$pun_id);

		return $this->getDefaultAdapter()->fetchPairs($select);
	}

}