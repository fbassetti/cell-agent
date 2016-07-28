<?php

class Activaciones_EstadisticasController extends BootPoint {

	public function indexAction(){
		$this->view->layout()->setLayout('default2');

		$modelo = new default_models_Integracion_Activacion();
//		$resumen = $modelo->getResumen();

		$sql = "SELECT COUNT(activacion_id) AS cantidad,activacion_nroDoc,activacion_estado "
		. "FROM integracion.ACTIVACION WHERE activacion_estado != 'Finalizado' "
		. "GROUP BY activacion_nroDoc,activacion_estado";
		$resumen = $modelo->getDefaultAdapter()->fetchAll($sql);

		$new = array();
		foreach($resumen as $i => $v)
			if($v['activacion_estado'] != 'Finalizado' && !preg_match('#tanda#',$v['activacion_estado']))
				$new[] = "['{$v['activacion_estado']} ({$v['cantidad']})',{$v['cantidad']}]";

			$this->view->repros = implode(',',$new);



		//$this->view->repros = implode(',',$pendientes);
	}
}