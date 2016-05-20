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
// menerima $_GET['data'] dan $_GET['tb']
// $_GET['data'] = id yg akan dihapus
// $_GET['tb'] = nama table yg isi nya akan dihapus
if ((isset($_GET['data'])) && ($_GET['data'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ".$_GET['tb']." WHERE id=%s",
                       GetSQLValueString($_GET['data'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($deleteSQL, $core) or die(mysql_error());

  $deleteGoTo = "viewdailyreportdetail.php?data=".$_GET['header'];
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
