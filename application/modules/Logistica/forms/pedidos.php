<?php

class Logistica_forms_pedidos extends Zend_Form {

	public function init(){
		$descuento = $this->createElement('text','descuento')
			->setAttrib('size',11);
		$ped_envio = $this->createElement('text','ped_envio')
			->setAttrib('size',11);

		$iva = $this->createElement('select','iva')
			->addMultiOptions(array('1'=>'Con IVA','0'=>'Sin IVA'));

		$comentarios = $this->createElement('textarea','comentarios')
				->setAttribs(array('rows'=>6,'cols'=> 120));

		$this->addElements(array(
			$descuento,$ped_envio,$iva,$comentarios
		));
	}

}