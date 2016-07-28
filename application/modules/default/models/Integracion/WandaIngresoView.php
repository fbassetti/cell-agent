<?php

class default_models_Integracion_WandaIngresoView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'wanda_ingreso_view';
	protected $_primary = 'solicitud';

	public function getIngresos($suc_id,$desde,$hasta){
		$select = $this->select(true)
			->columns(array('SUM(TarCO) AS CO', 'SUM(TarCP) AS CP'))
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")>=?',$desde)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")<=?',$hasta)
			->where('idsucursal=?',$suc_id)
			->group('idsucursal');

		return $this->getDefaultAdapter()->fetchRow($select);
	}

	public function getIngresosPunto($suc_id,$pun_id,$desde,$hasta){
		$select = $this->select(true)->reset('columns')
			->columns(array('idpunto','idsucursal','SUM(TarCO) AS CO','SUM(TarCP) AS CP'))
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d") >= ?',$desde)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d") <= ?',$hasta)
			->where('idsucursal = ?',$suc_id)
			->where('idpunto IN (?)',$pun_id)
			->group('idpunto');

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}