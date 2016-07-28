<?php

class Activaciones_forms_activaciones extends Zend_Form {

	public function init(){
		$campo = $this->createElement('select','campo')
			->setRequired(true)
			->setAttrib('data-inline','true')
			->setAttrib('data-mini','true')
			->addMultiOptions(array(
				'activacion_sim'=>'SIM',
				'activacion_linea'=>'Abonado'
			));

		$query = $this->createElement('text','query')
			->setAttribs(array(
				'placeholder' => 'Ingresar..',
				'data-inline'=>'true',
				'maxlength' => 19
			));

		$tilde = $this->createElement('checkbox','tilde')
			->setAttrib('data-role','none');


		$texto = $this->createElement('textarea','texto')
			->setAttribs(array(
				'data-role'=>'none',
				'cols' => 30,
				'rows' => 8,
				'style' => 'display:none;'
			));

		$error = $this->createElement('textarea','error')
			->setAttribs(array(
				'data-role'=>'none',
				'cols' => 30,
				'rows' => 8,
				'style' => 'display:none;'
			));

		$this->addElements(array($campo,$query,$tilde,$texto,$error));
	}
}