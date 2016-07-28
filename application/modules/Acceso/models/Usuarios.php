<?php

class Acceso_models_Usuarios extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'usuarios_roles';

	/**
	* Obtener Perfiles Asociados a un Usuario
	*
	* @param mixed $usu_id
	*/
	public function getRoles($usu_id){
		$select = $this->getDefaultAdapter()->select()
			->from('roles as r','r.*',$this->_schema)
			->joinLeft('usuarios_roles as ur','ur.rol_id=r.rol_id',null,$this->_schema)
			->where('ur.usu_id=?',$usu_id)
			->where('uro_activo=1')
			->order('rol_nombre');

		return $this->getDefaultAdapter()->fetchAssoc($select);
	}

	public function getRolesRestantes($not_in){
		$select = $this->getDefaultAdapter()->select()
			->from('roles as r','*',$this->_schema)
			->order('rol_nombre');

		if(!empty($not_in))
		    $select->where('rol_id NOT IN (?)',$not_in);

		return $this->getDefaultAdapter()->fetchAll($select);
	}
	/**
	* Obtener recursos asociados a un rol
	*
	* @param mixed $rol_ids
	*/
	public function getRecursosRoles($rol_ids){
		if(empty($rol_ids)) return array();

		$sql = "SELECT module,controller,action FROM roles_recursos "
			. "WHERE rol_id IN (".implode(',',$rol_ids).") AND rec_activo=1 GROUP BY module,controller,action "
			. "ORDER BY module,controller,action";

		return $this->getDefaultAdapter()->fetchAll($sql);
	}

}