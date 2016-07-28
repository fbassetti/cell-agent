<?php

class Ventas_forms_operaciones extends Zend_Form {

	public function init(){
		$campo = $this->createElement('select','campo')
			->setRequired(true)
			->setAttrib('class','styled-select')
			->addMultiOptions(array(
				''=>'[Filtro]',
				'sim'=>'SIM',
				'abonado'=>'Abonado'
			));

		$query = $this->createElement('text','query')
			->setAttribs(array(
				'placeholder' => 'Ingresar..',
				'class' => 'input',
				'size' => 22,
				'maxlength' => 19
			));

		$tilde = $this->createElement('checkbox','tilde');

		$texto = $this->createElement('textarea','texto')
			->setAttribs(array(
				'cols' => 50,
				'rows' => 10,
				'style' => 'display:none;'
			));

		$error = $this->createElement('textarea','error')
			->setAttribs(array(
				'cols' => 50,
				'rows' => 10,
				'style' => 'display:none;',
			));

		$this->addElements(array($campo,$query,$tilde,$texto,$error));
	}
}