<?php

class default_models_Web_Reportes extends Zend_Db_Table_Abstract {

	protected $_schema = 'web';
	protected $_name = 'rep_reportes';

	public function getReportes($tipo,$page,$perPage){
		$select = $this->select()
			->reset('columns')
			->columns('SQL_CALC_FOUND_ROWS *')
			->limitPage($page,$perPage)
			->order('rep_fh DESC');

		if(!is_null($tipo))
			$select->where('rep_tipo=?',$tipo);

		return $this->getDefaultAdapter()->fetchAll($select);
	}
}