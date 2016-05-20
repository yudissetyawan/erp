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

if ((isset($_GET['data'])) && ($_GET['data'] != "")) {
  $deleteSQL1 = sprintf("DELETE FROM e_header_core_bom WHERE id=%s",
                       GetSQLValueString($_GET['data'], "int"));
  $deleteSQL2 = sprintf("DELETE FROM e_core_bom WHERE headercorebom=%s",
                       GetSQLValueString($_GET['data'], "text"));
  
  mysql_select_db($database_core, $core);
  $Result11 = mysql_query($deleteSQL1, $core) or die(mysql_error());
  $Result12 = mysql_query($deleteSQL2, $core) or die(mysql_error());

  $deleteGoTo = "editbom.php?data=".$_GET['data2']."";
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
