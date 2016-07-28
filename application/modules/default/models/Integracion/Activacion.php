<?php

class default_models_Integracion_Activacion extends Zend_Db_Table_Abstract {

	protected $_name = 'ACTIVACION_copy';
	protected $_schema = 'integracion';

	public function getActivaciones($campo,$valor){
		$select = $this->select(true)->reset('columns')
			->columns(array('activacion_sim','activacion_linea','activacion_estado','activacion_nroSol',
				'SUBSTR(activacion_sim,1,LENGTH(activacion_sim)-3) AS cod'))
			->where("{$campo} IN ('".$valor."')")
			->order('activacion_sim');

		return $this->fetchAll($select)->toArray();
	}

	/**
	* Obtener Resumen de Activaciones
	*
	*/
	public function getResumen(){
		$select = $this->select(true)->reset('columns')
			->columns(new Zend_Db_Expr('COUNT(activacion_id) as cantidad,activacion_estado'))
			->order('activacion_estado')
			->group('activacion_estado');

		return $this->fetchAll($select)->toArray();
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

		return $this->fetchAll($select)->toArray();
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
			->order('activacion_sim');

		return $this->fetchAll($select)->toArray();
	}

	/**
	* Obtener Listado Completo de Lotes y su estado
	*
	*/
	public function getLotes(){
		$select = $this->select(true)->reset('columns')
			->columns(array('COUNT(activacion_id) AS cantidad',
				'SUBSTR(activacion_sim,1,LENGTH(activacion_sim)-3) AS lote','activacion_estado',
				'activacion_locLin','activacion_abonado'))
			->order(array('activacion_abonado DESC','activacion_locLin'))
			->group(array('lote','activacion_locLin','activacion_estado','activacion_abonado'));

		return $this->fetchAll($select)->toArray();
	}
}