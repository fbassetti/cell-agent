<?php

class default_models_Web_Rentabilidad extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'ren_rentabilidad';

	/**
	* Obtener Cuentas de Resumen
	*
	* @param mixed $suc_id
	* @param mixed $desde
	* @param mixed $hasta
	* @return array
	*/
	public function getCuentas($suc_id,$desde,$hasta){
		$select = $this->select(true)
			->setIntegrityCheck(false)
			->joinLeft('cuentas_view','idcuenta=cue_id',
				array('cuenta','SUM(ren_monto) as monto','COUNT(cue_id) as cantidad'),'integracion')
			->where('suc_id=?',$suc_id)
			->where('DATE_FORMAT(ren_fh,"%Y-%m-%d")>=?',$desde)
			->where('DATE_FORMAT(ren_fh,"%Y-%m-%d")<=?',$hasta)
			->group(array('cue_id','debe_haber'))
			->order(array('debe_haber','cuenta'));

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Detalle de cuentas
	*
	* @param mixed $suc_id
	* @param mixed $desde
	* @param mixed $hasta
	*/
	public function getCuentasDetalle($suc_id,$desde,$hasta){
		$select = $this->select(true)
			->setIntegrityCheck(false)
			->columns('ren_monto as monto')
			->joinLeft('cuentas_view','idcuenta=cue_id',
				array('cuenta','DATE_FORMAT(ren_fh,"%d/%m/%Y") as fh'),'integracion')
			->where('suc_id=?',$suc_id)
			->where('DATE_FORMAT(ren_fh,"%Y-%m-%d")>=?',$desde)
			->where('DATE_FORMAT(ren_fh,"%Y-%m-%d")<=?',$hasta)
			->order(array('debe_haber','cuenta'));

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}