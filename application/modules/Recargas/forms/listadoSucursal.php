<?php

class Recargas_forms_listadoSucursal extends Zend_Form {

	public function init(){
		$suc_id = $this->createElement('select','suc_id')
		->setAttrib('class','styled-select')
		->addMultiOption('','[Sucursal]')
		->setRequired(true)
		->setRegisterInArrayValidator(false);

		$yy = $this->createElement('select','yy')
		->setAttrib('class','styled-select')
		->setRequired(true)
		->addMultiOptions(array(''=>utf8_encode('[Año]')));

		for($i=date('Y');$i>=2007;$i--){
			$yy->addMultiOption($i,$i);
		}

		$mm = $this->createElement('select','mm')
		->setAttrib('class','styled-select')
		->setRequired(true)
		->addMultiOptions(array(''=>'[Mes]'));

		$operatoria = $this->createElement('select','operatoria')
		->setAttrib('class','styled-select')
		->addMultiOptions(array(''=>'[Todas las Operatorias]'));

		$this->addElements(array($suc_id,$yy,$mm,$operatoria));
	}

}