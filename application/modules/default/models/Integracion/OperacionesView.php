<?php

class default_models_Integracion_OperacionesView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'operaciones_view';
	protected $_primary = 'idventa';

	/**
	* Buscar Operacion
	*
	* @param string $campo activacion_sim/activacion_linea
	* @param string $valor
	*/
	public function getOperaciones($campo,$valor){
		$select = $this->select(true)
			->where("{$campo} IN ('".$valor."')")
			->order('sim');

		return $this->fetchAll($select)->toArray();
	}

}