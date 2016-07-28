<?php

class Logistica_forms_proveedores extends Zend_Form {

	public function init(){
		$prv_rsocial = $this->createElement('text','prv_rsocial')
			->setAttrib('style','width:300px');

		$prv_nombres = $this->createElement('text','prv_nombres')
			->setAttrib('style','width:240px')
			->setRequired(true);

		$prv_apellido = $this->createElement('text','prv_apellido')
			->setAttrib('style','width:240px')
			->setRequired(true);

		$prv_email = $this->createElement('text','prv_email')
			->setAttrib('style','width:240px')
			->addValidator('emailAddress');

		$prv_telefono = $this->createElement('text','prv_telefono')
			->setAttrib('style','width:200px');

		$prv_telefonoalt = $this->createElement('text','prv_telefonoalt')
			->setAttrib('style','width:200px');

		$prv_fax = $this->createElement('text','prv_fax')
			->setAttrib('style','width:200px');

		$prv_cuit = $this->createElement('text','prv_cuit')
			->setAttrib('style','width:200px');

		$dom_calle = $this->createElement('text','dom_calle')
			->setAttrib('style','width:200px');

		$dom_numero = $this->createElement('text','dom_numero')
			->setAttrib('data-role','none');

		$dom_extra = $this->createElement('text','dom_extra')
			->setAttrib('data-role','none');

		$dom_ciudad = $this->createElement('text','dom_ciudad')
			->setAttrib('style','width:200px');

		$dom_cp = $this->createElement('text','dom_cp')
			->setAttrib('style','width:80px');

		$comentario = $this->createElement('textarea','comentario')
			->setAttrib('rows',10)
			->setAttrib('cols',80);


		$this->addElements(array(
			$prv_rsocial,$prv_nombres,$prv_apellido,$prv_email,$prv_telefono,$prv_telefonoalt,$prv_fax,$prv_cuit,
			$dom_calle,$dom_numero,$dom_extra,$dom_ciudad,$dom_cp,$comentario
		));
	}

}