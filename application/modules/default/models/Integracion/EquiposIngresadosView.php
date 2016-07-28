<?php

class default_models_Integracion_EquiposIngresadosView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'equipos_ingresados_view';
	protected $_primary = 'serie';

	/**
	* Obtener Cantidad de Equipos Ingresados en un periodo
	*
	* @param mixed $suc_id
	* @param mixed $desde
	* @param mixed $hasta
	* @return string
	*/
	public function getCantidadMensual($suc_id,$desde,$hasta){
		$select = $this->select(true)->reset('columns')
			->columns(array('COUNT(idsucursal) as cantidad','SUM(costo_r) AS monto_r','SUM(costo) AS monto'))
			->where('idsucursal=?',$suc_id)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")>=?',$desde)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")<=?',$hasta)
			->group('idsucursal');

		return $this->getDefaultAdapter()->fetchRow($select);
	}

	public function getListado($suc_id,$desde,$hasta){
		$select = $this->select(true)
			->columns(array(
				'DATE_FORMAT(fecha_carga,"%d/%m/%Y %H:%i") as fh_carga',
				'COUNT(nroremito) as cantidad',
				'SUM(costo) AS monto',
				'SUM(costo_r) AS monto_r'))
			->where('idsucursal=?',$suc_id)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")>=?',$desde)
			->where('DATE_FORMAT(fecha_carga,"%Y-%m-%d")<=?',$hasta)
			->order('fecha_carga')
			->group('nroremito');

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}