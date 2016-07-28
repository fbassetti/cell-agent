<?php

class default_models_Integracion_CuentasView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'cuentas_view';
	protected $_primary = 'idcuenta';

	public function getPares(){
		return $this->getDefaultAdapter()->fetchPairs($this->select(true)->order('cuenta'));
	}
}