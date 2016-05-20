<?php require_once('Connections/core.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
 /* require_once('../Connections/core.php');

if (!isset($_SESSION)) {
  session_start();
}
*/

//AND h_employee.id = '$usrid'";
mysql_select_db($database_core, $core);
$query_rsunapprvproj = "SELECT log_pesan.id_notif FROM log_pesan WHERE log_pesan.id_msgcat = '3' AND log_pesan.id_empdept = '$usrid' AND log_pesan.sudah_bacaYN = 'N'";
$rsunapprvproj = mysql_query($query_rsunapprvproj, $core) or die(mysql_error());
$row_rsunapprvproj = mysql_fetch_assoc($rsunapprvproj);
$totalRows_rsunapprvproj = mysql_num_rows($rsunapprvproj);

//$usrid = $_SESSION['empID'];

mysql_select_db($database_core, $core);
$query_rsreadnotif = "SELECT log_pesan.id_notif FROM log_pesan WHERE log_pesan.id_msgcat <> '3' AND log_pesan.id_empdept = '$usrid' AND log_pesan.sudah_bacaYN = 'N'";
$rsreadnotif = mysql_query($query_rsreadnotif, $core) or die(mysql_error());
$row_rsreadnotif = mysql_fetch_assoc($rsreadnotif);
$totalRows_rsreadnotif = mysql_num_rows($rsreadnotif);


if ($_SESSION['lvl'] == '0') { ?>
	<a href="?modul=unapproved" style="text-decoration:none;" title="Need for Approval"> <img src="images/iconApproval.png" height="25" width="25" /> <font color="#FF0000" size="3"><b><sup><?php echo $totalRows_rsunapprvproj ?></sup></b></font></a> &nbsp;&nbsp; 
<?php } ?>
	
<a href="?modul=notif" style="text-decoration:none;" title="Notification"> <img src="images/iconNotif.png" height="23" width="23" /> <font color="#FF0000" size="3"><b><sup><?php echo $totalRows_rsreadnotif ?></sup></b></font></a> &nbsp;&nbsp;
	
<?php
	$lvl = $_SESSION['userlvl'];
	switch($lvl){
		case "administrator"	: $filename="1_User_Manual_of_BiSmartS_IND.pdf";break;
		case "branchmanager"	: $filename="1_User_Manual_of_BiSmartS_IND.pdf";break;
		case "it"				: $filename="15_User_Manual_of_BiSmartS_IND_(IT).pdf";break;
		case "marketing"		: $filename="2_User_Manual_of_BiSmartS_IND_(MKT).pdf";break;
		case "commercial"		: $filename="3_User_Manual_of_BiSmartS_IND_(COMM).pdf";break;
		case "project"			: $filename="4_User_Manual_of_BiSmartS_IND_(PROJ).pdf";break;
		case "fabrication"		: $filename="11_User_Manual_of_BiSmartS_IND_(FAB).pdf";break;
		case "finance"			: $filename="10_User_Manual_of_BiSmartS_IND_(FIN).pdf";break;
		case "engineering"		: $filename="6_User_Manual_of_BiSmartS_IND_(ENG).pdf";break;
		case "qly"				: $filename="12_User_Manual_of_BiSmartS_IND_(QC).pdf";break;
		case "maintenance"		: $filename="14_User_Manual_of_BiSmartS_IND_(MTN).pdf";break;
		case "hse"				: $filename="13_User_Manual_of_BiSmartS_IND_(HSE).pdf";break;
		case "procurement"		: $filename="8_User_Manual_of_BiSmartS_IND_(PROC).pdf";break;
		case "ppic"				: $filename="7_User_Manual_of_BiSmartS_IND_(PPIC).pdf";break;
		case "production"		: $filename="7_User_Manual_of_BiSmartS_IND_(PPIC).pdf";break;
		case "hrd"				: $filename="9_User_Manual_of_BiSmartS_IND_(HRD).pdf";break;
		case "GAFF"				: $filename="9_User_Manual_of_BiSmartS_IND_(HRD).pdf";break;
	}

	if (file_exists('umanual/'.$filename)) {
		$addr = 'umanual/'.$filename;
	} else if (file_exists('../umanual/'.$filename)) {
		$addr = '../umanual/'.$filename;
	} else {
		$addr = '../../umanual/'.$filename;
	}
?>

<a href="<?php echo $addr; ?>" target="_blank" style="text-decoration:none;" title="Help (User Manual)"> <img src="images/iconHelp.png" height="23" width="23" /> </a>
     
<?php
	mysql_free_result($rsunapprvproj);
	mysql_free_result($rsreadnotif);
?>