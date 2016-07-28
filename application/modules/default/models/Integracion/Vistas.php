<?php

class default_models_Integracion_Vistas extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';

	/**
	* Facturación por Punto de Venta en Mes, agrupa operatoria
	*
	* @param mixed $yy
	* @param mixed $mm
	* @return array
	*/
	public function getComisionPuntoMes($yy,$mm){
		$select = $this->getDefaultAdapter()->select()
		->from('ven_com_view',array('operatoria','SUM(ventas) AS ventas','SUM(puntuacion) AS puntuacion'),$this->_schema)
		->where('anio = ?',$yy)
		->where('mes = ?',(int)$mm)
		->order('tipo_operacion')
		->group('operatoria');

		return $this->getDefaultAdapter()->fetchAssoc($select);
	}

	/**
	* Facturación por punto de Venta por fecha de Activación
	*
	* @param int $suc_id
	* @param int $pun_id
	* @param mixed $yy
	* @param mixed $mm
	* @param mixed $operatoria
	* @return array
	*/
	public function getFacturacionPunto($suc_id,$pun_id,$yy,$mm,$operatoria){
		$select = $this->getDefaultAdapter()->select()
		->from('ven_fac_view','*',$this->_schema)
		->where('anio = ?',$yy)
		->where('mes = ?',(int)$mm)
		->order('tipo_operacion');

		if($suc_id > 0)
			$select->where('idsucursal = ?',(int)$suc_id);
		#else
		#$select->group('idsucursal');
		if($pun_id > 0)
			$select->where('idlocal = ?',(int)$pun_id);
		else{
			#$select->group('idlocal');
		}
		if($operatoria != '')
			$select->where('operatoria = ?',$operatoria);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Comisión por Punto de Venta
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $yy
	* @param mixed $mm
	* @param mixed $operatoria
	* @return array
	*/
	public function getComisionPunto($suc_id,$pun_id,$yy,$mm,$operatoria){
		$select = $this->getDefaultAdapter()->select()
		->from('ven_com_view','*',$this->_schema)
		->where('idsucursal = ?',(int)$suc_id)
		->where('idpunto = ?',(int)$pun_id)
		->where('anio = ?',$yy)
		->where('mes = ?',(int)$mm)
		->order('tipo_operacion');
		if($operatoria != '')
			$select->where('operatoria = ?',$operatoria);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Informe de Caja
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $desde
	* @param mixed $hasta
	* @return array
	*/
	public function getInformeCaja($suc_id,$pun_id,$desde,$hasta){
		$select = $this->getDefaultAdapter()->select()
		->from('cajas_view',array('*','DATE_FORMAT(caj_dt_fecha,"%d/%m/%Y") as fecha'),$this->_schema)
		->where('IdPunto = ?',(int)$pun_id)
		->where('Idsucursal = ?',$suc_id)
		->where('caj_dt_fecha >= ?',$desde)
		->where('caj_dt_fecha <= ?',$hasta)
		->order('caj_dt_fecha');

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Informe de Caja Diario
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $fecha
	* @return array
	*/

	
	
	/**
	* Obtener Informe de Caja-Vendedor
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $desde
	* @param mixed $hasta
	* @return array
	*/

	public function getInformeVendedor($suc_id,$pun_id,$desde,$hasta){
		$select = $this->getDefaultAdapter()->select()
		->from('cajas_view_vendedor',array('*','DATE_FORMAT(caj_dt_fecha,"%d/%m/%Y") as fecha'),$this->_schema)
		->where('IdPunto = ?',(int)$pun_id)
		->where('Idsucursal = ?',$suc_id)
		->where('caj_dt_fecha >= ?',$desde)
		->where('caj_dt_fecha <= ?',$hasta)
		->order('caj_dt_fecha');
		
	

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Informe de Caja Diario
	*
	* @param mixed $suc_id
	* @param mixed $pun_id
	* @param mixed $fecha
	* @return array
	*/
	public function getInformeCajaDiaria($suc_id,$pun_id,$desde,$hasta){
		$select = $this->getDefaultAdapter()->select()
		->from('cajas_view',array('*','DATE_FORMAT(caj_dt_fecha,"%d/%m/%Y") as fecha'),$this->_schema)
		->where('IdPunto IN (?)',$pun_id)
		->where('Idsucursal = ?',$suc_id)
		->where('caj_dt_fecha >= ?',$desde)
		->where('caj_dt_fecha <= ?',$hasta)
		->order('caj_dt_fecha');

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener recargas de vendedor
	*
	* @param mixed $ven_id
	* @param mixed $yy
	* @param mixed $mm
	* @param mixed $operatoria
	* @return array
	*/
	public function getRecargasVendedor($ven_id,$yy,$mm,$operatoria=null){
		$select = $this->getDefaultAdapter()->select()
		->from('rec_vend_view',
		new Zend_Db_Expr('Idvendedor,anio,liquidacion,SUM(base) as base,recarga,SUM(Tot) as total'),
		$this->_schema)
		->where('anio = ?',$yy)
		->where('mes = ?',(int)$mm)
		->where('Idvendedor=?',(int)$ven_id)
		->order('mes')
		->group(array('liquidacion','recarga'));

		if($operatoria > 0)
			$select->where('operatoria=?',$operatoria);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	public function getRecargasSucursal($suc_id,$yy,$mm,$operatoria=null){
		$select = $this->getDefaultAdapter()->select()
		->from('rec_suc_view',
		new Zend_Db_Expr('IdSucursal,anio,liquidacion,SUM(base) as base,recarga,SUM(Tot) as total'),
		$this->_schema)
		->where('anio = ?',$yy)
		->where('mes = ?',(int)$mm)
		->where('IdSucursal=?',$suc_id)
		->order('mes')
		->group(array('liquidacion','recarga'));

		if($operatoria > 0)
			$select->where('operatoria=?',$operatoria);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	public function getTotalVentas($suc_id,$yy,$mm,$operatoria=null){
		$select = $this->getDefaultAdapter()->select()
		->from('ventas_view','SUM(ventas)',$this->_schema)
		->where('anio = ?',$yy)
		->where('mes = ?',(int)$mm)
		->where('IdSucursal=?',$suc_id);

		if($operatoria > 0)
			$select->where('operatoria=?',$operatoria);
		return $this->getDefaultAdapter()->fetchOne($select);
	}

	public function getEquiposPorSucursal($suc_id,$pun_id,$mar_id,$mod_id,$page,$perPage){
		$select = $this->getDefaultAdapter()->select()
		->from('log_suc_equi_view',new Zend_Db_Expr('SQL_CALC_FOUND_ROWS *,cant'),$this->_schema)
		->order(array('marca','modelo'))
		->limit($perPage, $perPage*($page-1));

		if($suc_id > 0)
			$select->where('idsucursal=?',$suc_id);
		if($pun_id > 0)
			$select->where('Idvendedor=?',intval($pun_id));
		else
			$select->group('Idvendedor');
		if($mar_id > 0)
			$select->where('idmarca=?',$mar_id);
		if($mod_id > 0)
			$select->where('idmodelo=?',$mod_id);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	/**
	* Obtener Equipo
	*
	* @param mixed $idmsn
	*/
	public function getEquipo($idmsn){
		$select = $this->getDefaultAdapter()->select()
		->from('log_equi_view',array('*',
			'DATE_FORMAT(fecha_asignacion,"%d/%m/%Y %H:%i:%s") as fh_asignacion',
			'DATE_FORMAT(fecha_carga,"%d/%m/%Y %H:%i:%s") as fh_carga'
			),$this->_schema)
		->where('idmsn=?',$idmsn);

		return $this->getDefaultAdapter()->fetchRow($select);
	}

	/**
	* Obtener Numero de sim
	*
	* @param mixed $idcard
	*/
	public function getSim($idcard){
		$select = $this->getDefaultAdapter()->select()
		->from('log_sim_view',array('*',
			'DATE_FORMAT(fecha_asignacion,"%d/%m/%Y %H:%i:%s") as fh_asignacion',
			'DATE_FORMAT(fecha_carga,"%d/%m/%Y %H:%i:%s") as fh_carga'
			),$this->_schema)
		->where('Idcard=?',$idcard);

		return $this->getDefaultAdapter()->fetchRow($select);
	}

	public function getSimSucursal($suc_id,$page,$perPage){
		$select = $this->getDefaultAdapter()->select()
		->from('log_suc_sim_view',new Zend_Db_Expr('SQL_CALC_FOUND_ROWS *'),$this->_schema)
		->where('idsucursal=?',$suc_id)
		->order('modelo')
		->limit($perPage, $perPage*($page-1));

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	public function getEgresos($suc_id,$pun_id,$ope,$desde,$hasta){
		$select = $this->getDefaultAdapter()->select()
		->from('acce_egr_view',
		new Zend_Db_Expr('idsucursal,idpunto,idvendedor,sum(cantidad) as cantidad,sum(precio_t) as precio,Operacion')
		,$this->_schema)
		->where("dt_active BETWEEN '{$desde}' AND '{$hasta} 23:59:00'")
		->where('Operacion=?',$ope)
		->group(array('idsucursal','idvendedor'));

		if($suc_id > 0)
			$select->where('idsucursal=?',(int)$suc_id);
		if($pun_id > 0){
			$select->where('idpunto=?',(int)$pun_id);
		}
		else{
			$select->group('idpunto');
		}

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	public function getIngresos($suc_id,$pun_id,$ope,$desde,$hasta){
		$select = $this->getDefaultAdapter()->select()
		->from('acce_ing_view',
		new Zend_Db_Expr('idsucursal,idpunto,idvendedor,count(cantidad) AS cantidad,SUM(precio_u) as precio,Operacion')
		,$this->_schema)
		->where("dt_active BETWEEN '{$desde}' AND '{$hasta} 23:59:00'")
		->where('Operacion=?',$ope)
		->group(array('idsucursal','idpunto','idvendedor'));

		if($suc_id > 0)
			$select->where('idsucursal=?',$suc_id);
		if($pun_id > 0)
			$select->where('idpunto=?',$pun_id);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	public function getEgresosVendedor($ven_id,$ope,$pun_id,$desde,$hasta){
		return $this->functionVendedor($ven_id,$ope,$pun_id,$desde,$hasta,'acce_egr_view');
	}

	public function getEgresosPunto($pun_id,$ope,$desde,$hasta){
		return $this->funcionPunto($pun_id,$ope,$desde,$hasta,'acce_egr_view');
	}

	public function getIngresosVendedor($ven_id,$ope,$pun_id,$desde,$hasta){
		return $this->functionVendedor($ven_id,$ope,$pun_id,$desde,$hasta,'acce_ing_view');
	}

	public function getIngresosPunto($pun_id,$ope,$desde,$hasta){
		return $this->funcionPunto($pun_id,$ope,$desde,$hasta,'acce_ing_view');
	}

	/* Funciones genericas, cambia la vista */
	private function functionVendedor($ven_id,$ope,$pun_id,$desde,$hasta,$tabla){
		$select = $this->getDefaultAdapter()->select()
		->from($tabla,
		new Zend_Db_Expr('idsucursal,idpunto,idvendedor,dt_active,descripcion,codigobarra,cantidad,precio_u,Operacion'),
		$this->_schema)
		->where("dt_active BETWEEN '{$desde}' AND '{$hasta} 23:59:00'")
		->where('Operacion=?',$ope)
		->order('dt_active');

		if($ven_id > 0)
			$select->where('idvendedor=?',$ven_id);
		if($pun_id > 0)
			$select->where('idpunto=?',$pun_id);

		return $this->getDefaultAdapter()->fetchAll($select);
	}

	private function funcionPunto($pun_id,$ope,$desde,$hasta,$tabla){
		$select = $this->getDefaultAdapter()->select()
		->from($tabla,
		new Zend_Db_Expr('idsucursal,idpunto,idvendedor,SUM(cantidad) AS cant,SUM(precio_u*cantidad) as precio,Operacion'),
		$this->_schema)
		->where("dt_active BETWEEN '{$desde}' AND '{$hasta} 23:59:00'")
		->where('Operacion=?',$ope)
		->order('dt_active')
		->group(array('idsucursal','idvendedor'));

		if($pun_id > 0)
			$select->where('idpunto=?',$pun_id);

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}