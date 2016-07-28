<?php

class default_forms_buscar extends Zend_Form {

	public function init(){
		$q = $this->createElement('text','q')
			->setAttribs(array(
				'class' => 'input-unstyled',
				'data-inline' => 'true',
				'data-mini' => 'true',
				'style' => 'display: inline-block;width:150px;',
				'placeholder' => utf8_encode('Ingresar búsqueda...')
			));

		$this->addElement($q);
	}
}
