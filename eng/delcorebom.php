<?php require_once('../Connections/core.php');  ?>
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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
  $deleteSQL = sprintf("DELETE FROM e_core_bom WHERE id=%s",
                       GetSQLValueString($_GET['data'], "int"));

  mysql_select_db($database_core, $core);
  $Result = mysql_query($deleteSQL, $core) or die(mysql_error());
  if($_GET['act']=='edit'){$deleteGoTo = "editbom.php?data=".$_GET['data2'] ; }
  else{$deleteGoTo = "inputcorebom.php?data=".$_GET['data2'];}
  header(sprintf("Location: %s", $deleteGoTo));
?>
