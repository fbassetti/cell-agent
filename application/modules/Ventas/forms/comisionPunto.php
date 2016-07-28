<?php

class Ventas_forms_comisionPunto extends Zend_Form {

	public function init(){
		$suc_id = $this->createElement('select','suc_id')
		->setRequired(true)
		->addMultiOption('','[Sucursal]')
		->setRegisterInArrayValidator(false);

		$pun_id = $this->createElement('select','pun_id')
		->setRequired(true)
		->setRegisterInArrayValidator(false);

		$yy = $this->createElement('select','yy')
		->setRequired(true)
		->addValidator('notEmpty',false)
		->addMultiOptions(array(''=>utf8_encode('[Año]')));

		for($i=date('Y');$i>=2007;$i--){
			$yy->addMultiOption($i,$i);
		}

		$mm = $this->createElement('select','mm')
		->setRequired(true)
		->addValidator('notEmpty',false)
		->addMultiOptions(array(''=>'[Mes]'));

		$operatoria = $this->createElement('select','operatoria')
		->addMultiOptions(array(''=>'[Todas las Operatorias]'));

		/**
		* $pla_id = $this->createElement('select','pla_id')
		* ->addMultiOption('','[Todos los Planes]')
		* ->setRegisterInArrayValidator(false);
		*/

		$this->addElements(array($suc_id,$pun_id,$yy,$mm,$operatoria));
	}
}