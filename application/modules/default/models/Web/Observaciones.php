<?php

class default_models_Web_Observaciones extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'obs_observaciones';

	/**
	* Obtener Datos de Observacion
	*
	*/
	public function getObservacion($obs_id){
		$select = $this->select(true)
			->columns(array(
				'DATE_FORMAT(obs_fh_alarma,"%d/%m/%Y") AS alarma'
			))
			->where('obs_id=?',$obs_id)
			->order('obs_fh_alarma DESC');

		return $this->getDefaultAdapter()->fetchRow($select);
	}

	/**
	* Observaciones para Home
	*
	* @param mixed $fecha
	*/
	public function getObservacionesHome($fecha=null){
		$select = $this->select(true)
			->setIntegrityCheck(false)
			->columns(array(
				'DATE_FORMAT(obs_fh_creado,"%d/%m/%Y") AS creado',
				'DATE_FORMAT(obs_fh_alarma,"%d/%m/%Y") AS alarma',
				"CONCAT(cli_rsocial,', ',cli_apellido,' ',cli_nombres) as nombre"
			))
			->where('obs_fh_alarma != "0000-00-00"')

			->joinInner('cli_clientes AS c','c.cli_id=obs_observaciones.cli_id')
			->order('obs_fh_alarma DESC');

		if(!is_null($fecha))
			$select->where('obs_fh_alarma = ?',$fecha);
		else
			$select->where('obs_fh_alarma <= NOW()');

		return $this->fetchAll($select)->toArray();
	}
}