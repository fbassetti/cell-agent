<?php

class Activaciones_ImportacionController extends BootPoint {

	public function indexAction(){
		$importar = (int)$this->getRequest()->getParam('importar');

		if($this->getRequest()->isPost()){
			$texto = $this->getRequest()->getParam('texto');
			$texto = str_replace(array("\r","\t",'  ', '    ', '    ',' '),'',$texto);
			$activaciones = explode("\n",$texto);
			$activaciones = array_filter($activaciones);
			asort($activaciones);
			$activaciones = array_unique($activaciones);

			$texto = implode("\n",$activaciones);

			/** Buscar en Base y descartar repetidos */
			$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
			$select = $adapter->fetchCol('SELECT activacion_sim FROM integracion.ACTIVACION');
			$diferencia = array_diff($activaciones,$select);

			if(sizeof($diferencia) > 0 && $importar == 1){
				$maxfc = $adapter->fetchOne('SELECT MAX(activacion_nroFac) FROM integracion.ACTIVACION');
				$maxdni = $adapter->fetchOne('SELECT MAX(activacion_nroDoc) FROM integracion.ACTIVACION WHERE activacion_nroDoc!= "SIMBAD"');
				$localidad = $this->getRequest()->getParam('localidad');

				$adapter->beginTransaction();
				$cantidad = 100;

				$activaciones = array_chunk($diferencia,$cantidad);

				$values = array(
					'activacion_locLin'=> $localidad,
					'activacion_nroDoc'=> $maxdni+1,
					'activacion_nroFac'=> $maxfc+1,
					'activacion_estado'=> 1
				);
				foreach($activaciones as $i){
					foreach($i as $v){
						$values['activacion_sim'] = $v;
						$adapter->insert('integracion.ACTIVACION',$values);
						$values['activacion_nroFac']++;
					}
					$values['activacion_nroDoc']++;
					$values['activacion_estado']++;
				}
				$adapter->commit();
				$this->view->mensaje = 'Se importaron '.sizeof($diferencia).' repros';
			}
			else {
				$this->view->texto = $texto;
				$this->view->cantidad = sizeof($activaciones);
			}
		}
	}

	/** @deprecated */
	private function insertaActivaciones(array $values){
		$cantidad = 100;
		#loadfile activaciones
		$adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
		$adapter->beginTransaction();

		$activaciones = array(); //sim para activar
		$chunk = array_chunk($activaciones,$cantidad);
		foreach($activaciones as $i){
			foreach($i as $v){
				$values['activacion_sim'] = $v;
				$adapter->insert('ACTIVACION',$values);
			}
			$values['activacion_nroDoc']++;
		}
		$adapter->commit();
	}

	private function goForm(){
		$form = new Zend_Form();

		$activacion_nroSol = $form->createElement('text','activacion_nroSol')
			->setValue('AU009702521'); //varchar 20
		$activacion_pinVen = $form->createElement('text','activacion_pinVen')
			->setValue('21D05005001'); //varchar 20 MUL

		/* datos cliente */
		$activacion_tipoDoc = $form->createElement('text','activacion_tipoDoc')
			->setValue('DU'); //varchar 20
		$activacion_nroDoc = $form->createElement('text','activacion_nroDoc')
			->setValue('30303042'); //varchar 20
		$activacion_apellido = $form->createElement('text','activacion_apellido')
			->setValue('MIRANDA'); //varchar 20
		$activacion_nombre = $form->createElement('text','activacion_nombre')
			->setValue('DANIEL'); //varchar 20
		$activacion_calle = $form->createElement('text','activacion_calle')
			->setValue('MAIPU'); //varchar 20
		$activacion_altura = $form->createElement('text','activacion_altura')
			->setValue('798'); //varchar 20
		$activacion_pisoDep = $form->createElement('text','activacion_pisoDep'); //varchar 20
		$activacion_codPos = $form->createElement('text','activacion_codPos')
			->setValue(2000); //varchar 20
		$activacion_provCli = $form->createElement('text','activacion_provCli')
			->setValue('S'); //varchar 20
		$activacion_locCli = $form->createElement('text','activacion_locCli')
			->setValue('R323'); //varchar 20

		$activacion_provLin = $form->createElement('text','activacion_provLin'); //varchar 20
		$activacion_locLin = $form->createElement('text','activacion_locLin')
			->setValue('24-01'); //varchar 20

		#$activacion_sim = $form->createElement('text','activacion_sim'); //varchar 20

		$activacion_centro = $form->createElement('text','activacion_centro')
			->setValue('107'); //varchar 20
		$activacion_nroFac = $form->createElement('text','activacion_nroFac')
			->setValue(31740); //varchar 20
		$activacion_tip_act = $form->createElement('text','activacion_tip_act')
			->setValue('repro_activa'); //varchar 20 NOT NULL
		$activacion_estado = $form->createElement('text','activacion_estado')
			->setValue('Pendiente'); //varchar 20
		$activacion_linea = $form->createElement('text','activacion_linea')
			->setValue('3412030795'); //varchar 20
		$activacion_abonado = $form->createElement('text','activacion_abonado'); //varchar 20
		$activacion_fecSol = $form->createElement('text','activacion_fecSol'); //varchar 20
		$conexion_codigoSuc = $form->createElement('text','conexion_codigoSuc')
			->setValue('1'); //varchar 20 MUL
		/*
		$activacion_simlock = $form->createElement('text','activacion_simlock'); //varchar 20
		$activacion_imei = $form->createElement('text','activacion_imei'); //varchar 20
		$activacion_obs = $form->createElement('text','activacion_obs'); //varchar 255
		*/
		#$activacion_fechaMov = $form->createElement('text','activacion_fechaMov'); //date
		#$activacion_creado = $form->createElement('text','activacion_creado'); //TIMESTAMP   no tocar

		/*
		$activacion_obs = $form->createElement('text','activacion_obs'); //varchar 255
		$activacion_descrip = $form->createElement('text','activacion_descrip'); //varchar 20
		$activacion_tipoFac = $form->createElement('text','activacion_tipoFac'); //varchar 20

		$activacion_importe = $form->createElement('text','activacion_importe'); //varchar 20
		$activacion_bonific = $form->createElement('text','activacion_bonific'); //varchar 20
		$activacion_fechaAlta = $form->createElement('text','activacion_fechaAlta'); //varchar 20
		$activacion_folio = $form->createElement('text','activacion_folio'); //varchar 20

		$activacion_cat_iva = $form->createElement('text','activacion_cat_iva'); //varchar 20
		$activacion_sexo = $form->createElement('text','activacion_sexo'); //varchar 20
		$activacion_sec_eq_a = $form->createElement('text','activacion_sec_eq_a'); //varchar 20
		$activacion_sec_eq_b = $form->createElement('text','activacion_sec_eq_b'); //varchar 20
		$activacion_sec_eq_c = $form->createElement('text','activacion_sec_eq_c'); //varchar 20
		$activacion_sec_eq_d = $form->createElement('text','activacion_sec_eq_d'); //varchar 20
		$activacion_sec_eq_e = $form->createElement('text','activacion_sec_eq_e'); //varchar 20
		$activacion_sec_eq_f = $form->createElement('text','activacion_sec_eq_f'); //varchar 20
		$activacion_sec_eq_g = $form->createElement('text','activacion_sec_eq_g'); //varchar 20
		*/
		$activacion_sec_pres_1 = $form->createElement('text','activacion_sec_pres_1')
			->setValue('13'); //varchar 20
		$activacion_sec_pres_2 = $form->createElement('text','activacion_sec_pres_2')
			->setValue('03'); //varchar 20
		$activacion_sec_pres_3 = $form->createElement('text','activacion_sec_pres_3')
			->setValue('1983'); //varchar 20
		$activacion_sec_pres_4 = $form->createElement('text','activacion_sec_pres_4')
			->setValue('107-31828'); //varchar 20
		/*
		$activacion_sec_pres_5 = $form->createElement('text','activacion_sec_pres_5'); //varchar 20
		$activacion_sec_pres_6 = $form->createElement('text','activacion_sec_pres_6'); //varchar 20

		$activacion_home = $form->createElement('text','activacion_home'); //varchar 20
		$activacion_nacion = $form->createElement('text','activacion_nacion'); //varchar 20
		$activacion_razon_social = $form->createElement('text','activacion_razon_social'); //varchar 20
		$activacion_entidad = $form->createElement('text','activacion_entidad'); //varchar 20
		$activacion_tarjeta = $form->createElement('text','activacion_tarjeta'); //varchar 20
		$activacion_cpa = $form->createElement('text','activacion_cpa'); //varchar 20
		$activacion_referencia = $form->createElement('text','activacion_referencia'); //varchar 20

		$activacion_telefono = $form->createElement('text','activacion_telefono'); //varchar 20
		$activacion_referencia = $form->createElement('text','activacion_referencia'); //varchar 20
		$activacion_email = $form->createElement('text','activacion_email'); //varchar 20
		*/
		$activacion_Obligatorio = $form->createElement('text','activacion_Obligatorio')
			->setValue(0); //smallint 1  default 0
		$activacion_cantidadErrores = $form->createElement('text','activacion_cantidadErrores')
			->setValue(0); //smallint 1  default 0

		/*
		$activacion_vendedores_id = $form->createElement('text','activacion_vendedores_id'); //int
		$activacion_comentario = $form->createElement('text','activacion_comentario'); //varchar 20
		$activacion_pkvendedor = $form->createElement('text','activacion_pkvendedor'); //int
		$VendedoresPKconciliacion = $form->createElement('text','VendedoresPKconciliacion'); //int

		$activacion_error = $form->createElement('text','activacion_error'); //varchar 80
		*/
		#$activacion_imagen = $form->createElement('text','activacion_imagen'); //blob

	}

}
