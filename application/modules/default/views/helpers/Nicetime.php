<?php

class Zend_View_Helper_Nicetime {

	/**
	* Fecha de Ingreso
	*
	* @param mixed $date
	* @return mixed
	*/
	public function nicetime($date){
		if(empty($date)) {
			return "No date provided";
		}

		$periods = array("segundo", "minuto", "hora", "d&iacute;a", "semana", "mes", "a&ntilde;o", "decada");
		$lengths = array("60","60","24","7","4.35","12","10");

		$now = time();
		$unix_date = strtotime($date);

		// check validity of date
		if(empty($unix_date)) {
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {
			$difference = $now - $unix_date;
			$tense = "atras";

		} else {
			$difference = $unix_date - $now;
			$tense = "desde ahora";
		}

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}
		return "$difference {$periods[$j]} {$tense}";
	}

	//$date = "2009-03-04 17:45";
	//$result = nicetime($date); // 2 days ago
}