<?php

class default_helpers_FechasDH extends Zend_Date {

	public $hasta;
	public $desde;
	public $desdeEn;
	public $hastaEn;

	public function setRequest($request){
		$this->hasta = preg_replace('#_#','/',$request->getParam('hasta'));
		$this->desde = preg_replace('#_#','/',$request->getParam('desde'));
		$this->setLocale('es')->set(date('d/m/Y'),'dd/MM/y');
	}

	public function getDesde(){
		if(!empty($this->desde)){
			$this->setDate($this->desde);
		}
		else{ $this->setDay(1);}
		$this->desdeEn = $this->get('y-MM-dd');
		$this->desdeUrl = $this->get('dd_MM_y');
		return $this->get('dd/MM/y');
	}

	public function getHasta(){
		if(!empty($this->hasta))
			$this->set($this->hasta);
		$this->hastaEn = $this->get('y-MM-dd');
		$this->hastaUrl = $this->get('dd_MM_y');
		return $this->get('dd/MM/y');
	}
	
	/* made in internet :) */
	public function dameFecha($fecha,$dia)
	{	list($day,$mon,$year) = explode('/',$fecha);
		return date('d/m/Y',mktime(0,0,0,$mon,$day+$dia,$year));		
	}
 

}