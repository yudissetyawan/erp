<?php
	//CONVERT FORMAT DATE FROM "DD MMMM YYYY" TO "YYYY-MM-DD"
	function functyyyymmdd($datebefore) { //$_POST['inspection_date']
		$tgl = substr($datebefore, 0, 2);
		$bln = substr($datebefore, 3, 3);
		$thn = substr($datebefore, -4);
		 switch($bln){
		   case "Jan"	: $bln="01";break;
		   case "Feb"	: $bln="02";break;
		   case "Mar"	: $bln="03";break;
		   case "Apr"	: $bln="04";break;
		   case "May"	: $bln="05";break;
		   case "Jun"	: $bln="06";break;
		   case "Jul"	: $bln="07";break;
		   case "Aug"	: $bln="08";break;
		   case "Sep"	: $bln="09";break;
		   case "Oct"	: $bln="10";break;
		   case "Nov"	: $bln="11";break;
		   case "Dec"	: $bln="12";break;
		   
		   case "Mei"	: $bln="05";break;
		   case "Agu"	: $bln="08";break;
		   case "Okt"	: $bln="10";break;
		   case "Nop"	: $bln="11";break;
		   case "Des"	: $bln="12";break;
		 }
		$dateafter = "$thn-$bln-$tgl";
		return $dateafter;
	}
	
	//CONVERT FORMAT DATE FROM "YYYY-MM-DD" TO "DD MMM YYYY"
	function functddmmmyyyy ($tglawal) {	
		$tgl2 = substr ($tglawal, 8, 2);
		$sbln = substr ($tglawal, 5, 2);
		$thn2 = substr ($tglawal, 0, 4);
		$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		$bln2 = $namaBulan[(ltrim ($sbln, '0') - 1)];
		
		$tglsesudah = "$tgl2 $bln2 $thn2";
		return $tglsesudah;
	}	
	
	//CONVERT FORMAT DATE FROM "YYYY-MM-DD" TO "DD, MM, YYYY"
	function functddmmyyyy ($tgl_0) {	
		$pecah = explode ("-", $tgl_0);
		$date1 = $pecah[2];
		$month1 = $pecah[1];
		$year1 = $pecah[0];
		return array($month1, $date1, $year1);
	}
	
	function functddmmyyyy2 ($tgl_a) {	
		$pecah2 = explode ("-", $tgl_a);
		$date2 = $pecah2[2];
		$month2 = $pecah2[1];
		$year2 = $pecah2[0];
		return array($month2, $date2, $year2);
	}
	
	/*
	date_default_timezone_set('Asia/Balikpapan');
	//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
	$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
	$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	$today = date('l, F j, Y');
	$jam = date("H:i");
	
	$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
	
	echo "$today $jam <br>";
	echo $sekarang.'<br>';
	$a = date('N');
	echo "$a<br>";
	
	$b = date('D, d M Y H:i:s');
	echo "$b<br>";
	echo "$c<br>";
*/
?>