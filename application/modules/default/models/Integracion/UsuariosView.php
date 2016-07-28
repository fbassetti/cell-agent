<?php

class default_models_Integracion_UsuariosView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'usuarios_view';
	protected $_primary = 'idusuario';

    public function getUsuarios($q,$page,$perPage){
		$select = $this->select(true)->reset('columns')
		->columns(new Zend_Db_Expr('SQL_CALC_FOUND_ROWS *'))
		->order(array('Apellido','nombre'))
		->limit($perPage,$perPage*($page-1));

		if($q != '')
			$select->where("Apellido LIKE '%{$q}%'")
				->orWhere("nombre like '%{$q}%'")
				->orWhere("username LIKE '%{$q}%'");

		return $this->fetchAll($select)->toArray();
    }

}