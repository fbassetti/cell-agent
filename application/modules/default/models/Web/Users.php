<?php

class default_models_Web_Users extends Zend_Db_Table_Abstract {

    protected $_schema = 'web';
    protected $_name = 'users';

    public function getUsuarios($page,$perPage){
		$select = $this->select(true)
		->reset('columns')
		->columns(new Zend_db_Expr('usr_nid,usr_sname,usr_sfullname,usr_role'))
		->order('usr_sname')
		->limit($perPage,$perPage*($page-1));

		return $this->fetchAll($select)->toArray();
    }
}