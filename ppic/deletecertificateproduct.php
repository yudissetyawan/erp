<?php
require_once('../Connections/core.php');
$vid = $_REQUEST['data'];
$vidcat = $_REQUEST['data1'];
$tagsn = $_REQUEST['data2'];

/* echo "<script>alert(\"$vid dan $updateGoTo\");</script>"; */	
$q = "UPDATE p_certificate_product SET activeYN='0' WHERE id_certificate='$vid'";
$cmd = mysql_query($q) or die(mysql_error());

//DELETE NOTIF IF NOT NULL
$sqlIdJob3 = "SELECT id_pekerjaan FROM log_pesan WHERE id_pekerjaan = '$vid' AND id_inisial = '60'";
$cmdIdJob3 = mysql_query($sqlIdJob3) or die(mysql_error());
$nData3 = mysql_num_rows($cmdIdJob3);
		
if ($nData3 != 0) {
	$sqlDelMsg3 = "DELETE FROM log_pesan WHERE id_pekerjaan = '$vid' AND id_inisial = '60'";
	$cmdDelMsg3 = mysql_query($sqlDelMsg3) or die(mysql_error());
}

switch($vidcat){
	case "1" : $updateGoTo="viewcertificateproductSB.php";break;
	case "2" : $updateGoTo="viewcertificateproductSP.php";break;
	case "3" : $updateGoTo="viewcertificateproductSK.php";break;
	case "4" : $updateGoTo="viewcertificateproductCBR.php";break;
	case "5" : $updateGoTo="viewcertificateproductSL.php";break;
	case "6" : $updateGoTo="viewcertificateproductBS.php";break;
	case "7" : $updateGoTo="viewcertificateproductCB.php";break;
	case "8" : $updateGoTo="viewcertificateproductWS.php";break;
	case "9" : $updateGoTo="viewcertificateproductBC.php";break;
}
	
if ($cmd) {
	echo "<script>document.location=\"$updateGoTo\";
	</script>";
} else {
	echo "<script>alert(\"Data can't be deleted , Pesan Error: ".mysql_error()."\");
		 document.location=\"$updateGoTo\";
	</script>";
}
?>