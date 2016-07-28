<?php

class Recargas_forms_listadoVendedor extends Zend_Form {

	public function init(){
		$ven_id = $this->createElement('select','ven_id')
		->addValidator('notEmpty',false)
		->setAttrib('style','width:185px;font-size:11px;')
		->setAttrib('size',8)
		->setAttrib('data-role','none')
		->addValidator('notEmpty',false)
		->setRegisterInArrayValidator(false);

		$yy = $this->createElement('select','yy')
		->setAttrib('data-mini','true')
		->addValidator('notEmpty',false)
		->addMultiOptions(array(''=>utf8_encode('[Año]')));

		for($i=date('Y');$i>=2007;$i--){
			$yy->addMultiOption($i,$i);
		}

		$mm = $this->createElement('select','mm')
		->setAttrib('data-mini','true')
		->addValidator('notEmpty',false)
		->addMultiOptions(array(''=>'[Mes]'));

		$operatoria = $this->createElement('select','operatoria')
		->setAttrib('data-mini','true')
		->addMultiOptions(array(''=>'[Todas las Operatorias]'));

		$this->addElements(array($ven_id,$yy,$mm,$operatoria));
	}
}