<?php

/*
data yang diterima $_GET['fld'] , $_GET['data'] , $_GET['tb']
$_GET['tb'] = data yg berisi nama table yang akan di tambahkan datanya
$_GET['fld'] = data yang berisi nama filed pada table yang akan diisi
$_GET['data'] = value yang akan di simpan
*/

?>
<?php require_once('../Connections/core.php'); ?>
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
if ((isset($_GET["data"])) && ($_GET["data"] != " ")) {
	if ((isset($_GET["fld"])) && ($_GET["fld"] != " ")) {
		if ((isset($_GET["tb"])) && ($_GET["tb"] != " ")) {
			// data dimasukkan ke database sesuai value dari $_GET['fld'] , $_GET['data'] , $_GET['tb']
		  $insertSQL = sprintf("INSERT INTO ".$_GET['tb']." (".$_GET['fld'].") VALUES (%s)",
							   GetSQLValueString($_GET['data'], "int"));
		
		  mysql_select_db($database_core, $core);
		  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
		
		  $insertGoTo = "viewdailyreportdetail.php?data=" . $_GET['data'] . "";
		  header(sprintf("Location: %s", $insertGoTo));
		}
	}
}
?>