<?php

class default_models_Integracion_TarjetasIngresoView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'tarjetas_ingreso_view';
	protected $_primary = 'idsucursal';

	public function getIngresos($suc_id,$desde,$hasta){
		$select = $this->select(true)
			->reset('columns')
			->columns(array('SUM(TarCO) AS CO', 'SUM(TarCP) AS CP'))
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")>=?',$desde)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")<=?',$hasta)
			->where('idsucursal=?',$suc_id)
			->group('idsucursal');

		return $this->getDefaultAdapter()->fetchRow($select);
	}
}