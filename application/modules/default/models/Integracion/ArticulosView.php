<?php

class default_models_Integracion_ArticulosView extends Zend_Db_Table_Abstract {

	protected $_schema = 'integracion';
	protected $_name = 'articulos_view';
	protected $_primary = 'CodigoBarra';

	public function getListado($grupo,$page,$perPage){
		return $this->getDefaultAdapter()->fetchAll(
		$this->select(true)->reset('columns')
		->columns(new Zend_Db_Expr('SQL_CALC_FOUND_ROWS *'))
		->where('`Grupo A` = ?',$grupo)->order('Articulo')->limitPage($page-1,$perPage));
	}
}