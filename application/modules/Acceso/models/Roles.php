<?php

class Acceso_models_Roles extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'roles';

	public function getRoles(){
		return $this->getDefaultAdapter()->fetchAll($this->select()->order('rol_nombre'));
	}

	public function getRecursos($rol_id){
		$select = $this->getDefaultAdapter()->select()
			->from('roles_recursos','*',$this->_schema)
			->where('rol_id=?',$rol_id)
			->where('rec_activo=1')
			->order(array('module','controller','action'));

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}