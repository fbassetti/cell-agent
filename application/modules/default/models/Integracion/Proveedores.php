<?php

class default_models_Integracion_Proveedores extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'proveedores_view';
	protected $_primary = 'idproveedor';

	public function getProveedores($q,$page,$perPage){
		$select = $this->select(true)->reset('columns')
		->columns(new Zend_Db_Expr('SQL_CALC_FOUND_ROWS *'))
		->order('Razon')
		->limit($perPage, $perPage*($page-1));

		if($q != ''){
			$select->where('Razon LIKE "%?%"', $q);
		}

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}