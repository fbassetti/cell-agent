<?php

class default_models_Web_Niveles extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'cot_niveles';

	/**
	* Obtener Niveles de Autorizacion
	*
	*/
	public function getNiveles(){
		return $this->getDefaultAdapter()->fetchAll(
		$this->select(true)
		->setIntegrityCheck(false)
		->joinInner('usuarios_view','usu_id=idusuario','*','integracion')
		->order(array('niv_estado DESC','Apellido','nombre')));
	}

}