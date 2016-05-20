<?php
function MMRomawi($daten){
	 $daten = strtotime($daten);
	 $array_month = array('','I','II','III', 'IV', 'V', 'VI','VII','VIII','IX','X','XI','XII');
	 $bulan = $array_month[date('n',$daten)];
	 
	 return $bulan;
}
?>