<?php //$row_Recordset1['expired_date']
	
	function colorcode ($vtgl) {
		$thn = substr($vtgl, 0, 4);
		$bln = ltrim(substr($vtgl, 5, 2));
		if (($thn == '2013') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "35C7F3"; //"0000FF"; //"35C7F3";
			$fcolor = "FFF";
		}
		else if (($thn == '2013') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "FFFF00";
			$fcolor = "000";
		}
		else if (($thn == '2014') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "00FF00"; //"AAFF7F";
			$fcolor = "000";
		}
		
		
		else if (($thn == '2014') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "35C7F3";
			$fcolor = "FFF";
		}
		else if (($thn == '2015') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "FFFF00";
			$fcolor = "000";
		}
		else if (($thn == '2015') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "00FF00";
			$fcolor = "000";
		}
		
		
		else if (($thn == '2016') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "35C7F3";	
			$fcolor = "FFF";
		}
		else if (($thn == '2016') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "FFFF00";
			$fcolor = "000";
		}
		else if (($thn == '2017') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "00FF00";
			$fcolor = "000";
		}
		
		
		else if (($thn == '2017') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "35C7F3";
			$fcolor = "FFF";
		}
		else if (($thn == '2018') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "FFFF00";
			$fcolor = "000";
		}
		else if (($thn == '2018') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "00FF00";
			$fcolor = "000";
		}
		
		/*
		//SPARE
		else if (($thn == '2019') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "0000FF";
			$fcolor = "FFF";
		}
		else if (($thn == '2019') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "FFFF00";
			$fcolor = "000";
		}
		else if (($thn == '2020') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "00FF00";
			$fcolor = "000";
		}
		
		
		else if (($thn == '2020') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "0000FF";
			$fcolor = "FFF";
		}
		else if (($thn == '2021') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "FFFF00";
			$fcolor = "000";
		}
		else if (($thn == '2021') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "00FF00";
			$fcolor = "000";
		}
		*/
		
		return array($vbgcolor, $fcolor);
		//return $vbgcolor;
	}
	
	/*
		if (($thn == '2013') || ($thn == '2016') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "0000FF";	
		}
		else if (($thn == '2013') || ($thn == '2016') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "FFFF00";
		}
		else if (($thn == '2014') || ($thn == '2017') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "00FF00";
		}
		else if (($thn == '2014') || ($thn == '2017') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "0000FF";
		}
		else if (($thn == '2015') || ($thn == '2018') && ($bln >= 1) && ($bln <= 6)) {
			$vbgcolor = "FFFF00";
		}
		else if (($thn == '2015') || ($thn == '2018') && ($bln > 6) && ($bln <= 12)) {
			$vbgcolor = "00FF00";
		}
	*/

	/*
	DATEDIFF(CURDATE(), DATE(LEFT(Waktu, 10))) > $lama
	SELECT CURDATE(), expired_date, DATEDIFF(CURDATE(), DATE(expired_date)) AS selisih FROM `p_certificate_product`
	*/
?>