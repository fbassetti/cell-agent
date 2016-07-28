<?php

class default_models_Web_Activacion extends Zend_Db_Table_Abstract {

	protected $_name = 'activacion';
	protected $_schema = 'web';

	public function getActivaciones($campo,$valor){
		if(empty($valor))
			return;
		$select = $this->select(true)->reset('columns')
			->columns(array('activacion_sim','activacion_linea','activacion_estado','activacion_nroSol',
				'SUBSTR(activacion_sim,1,LENGTH(activacion_sim)-3) AS cod'))
			->where("{$campo} IN (?)",$valor)
			->order(array('activacion_estado DESC','activacion_sim'));

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Resumen de Activaciones
	*
	*/
	public function getResumen(){
		$select = $this->select(true)->reset('columns')
			->columns(new Zend_Db_Expr('COUNT(activacion_id) as cantidad,activacion_estado'))
			->order('activacion_estado DESC')
			->group('activacion_estado');

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Buscar Activacion
	*
	* @param string $campo activacion_sim/activacion_linea
	* @param string $valor
	*/
	public function getActivacion($campo,$valor){
		$select = $this->select(true)->reset('columns')
			->columns(array('activacion_sim','activacion_linea','activacion_estado','activacion_nroSol',
				'SUBSTR(activacion_sim,1,LENGTH(activacion_sim)-3) AS cod'))
			->where("{$campo}=?",$valor)
			->order('activacion_sim');

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Activaciones de un Lote
	*
	* @param string $lote
	*/
	public function getLote($lote){
		$select = $this->select(true)->reset('columns')
			->columns(array('activacion_sim','activacion_linea','activacion_estado','activacion_nroSol'))
			->where('SUBSTR(activacion_sim,1,LENGTH(activacion_sim)-3)=?',$lote)
			->order(array('activacion_estado DESC','activacion_sim'));

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Listado Completo de Lotes y su estado
	*
	*/
	public function getLotes(){
		$select = $this->select(true)->reset('columns')
			->columns(array(
				'COUNT(activacion_id) AS cantidad',
				'SUBSTR(activacion_sim,1,LENGTH(activacion_sim)-3) AS lote',
				'activacion_estado',
				'activacion_locLin',
				'activacion_abonado'))
			->group(array('lote','activacion_abonado','activacion_locLin','activacion_estado'))
			->order('lote');

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* SIMS por Id
	*
	* @param mixed $ids
	*/
	public function getSimsPorId($ids){
		$select = $this->select(true)->reset('columns')
			->columns(array('activacion_id','activacion_sim','activacion_abonado'))
			->where('activacion_id IN ('.implode(',',$ids).')')
			->order('activacion_sim');

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}