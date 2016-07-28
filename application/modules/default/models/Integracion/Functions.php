<?php

class default_models_Integracion_Functions extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';

	/**
	* Asignación de SIM
	*
	* @param char(20) $stSerie
	* @param int $idVendedor
	* @param int $idSucursal
	* @param int $idUsuario
	* @return bool
	*/
	public function asignacion_sim_func($stSerie,$idVendedor,$idSucursal,$idUsuario){
		return $this->getDefaultAdapter()
			->query("SELECT integracion.asignacion_sim_func('{$stSerie}',{$idVendedor},{$idSucursal},{$idUsuario})");
	}

	/**
	* Reservar número de remito
	* @return int
	*/
	public function remito_sim_func(){
		return $this->getDefaultAdapter()->query("SELECT integracion.remito_sim_func()");
	}

	/**
	* Asignacion Remito
	*
	* @param int $idRemito
	* @param char(60) $stVendedor
	* @param char(20) $stSerie
	* @param int $idUsuario
	* @param int $idVendedor
	* @return int
	*/
	public function remito_asig_func($idRemito,$stVendedor,$stSerie,$idUsuario,$idVendedor){
		$this->getDefaultAdapter()
			->query("SELECT integracion.remito_asig_func({$idRemito},'{$stVendedor}','{$stSerie}',{$idUsuario},{$idVendedor})");
	}

	/**
	* Asignar operación
	*
	* @param int $idventa
	* @param mixed $nroS numero solicitud
	* @param int $ven_id
	* @param mixed $tipoVend
	* @param int $suc_id
	* @param int $sup_id idsupervisor
	* @param int $usu_id
	*/
	public function asignacion_ope_func($idventa,$nroS,$ven_id,$tipoVend,$suc_id,$sup_id,$usu_id){
		$this->getDefaultAdapter()
			->query("SELECT integracion.asignacion_ope_func({$idventa},'{$nroS}',{$ven_id},'{$tipoVend}',{$suc_id},{$sup_id},{$usu_id})");
	}

}