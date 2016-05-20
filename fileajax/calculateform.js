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

$colname_framemodel = "-1";
if (isset($_GET['id'])) {
  $colname_framemodel = $_GET['id'];
}
mysql_select_db($database_core, $core);
$query_framemodel = sprintf("SELECT * FROM e_framemodel WHERE id = %s", GetSQLValueString($colname_framemodel, "int"));
$framemodel = mysql_query($query_framemodel, $core) or die(mysql_error());
$row_framemodel = mysql_fetch_assoc($framemodel);
$totalRows_framemodel = mysql_num_rows($framemodel);
?>
<script>
	function calculateForm(){
		<?php if($row_Recordset1['t3'] != ""){ ?>
		var t3 = document.getElementById("t3").value;
		<?php } ?>
	}
--></script>
<?php
mysql_free_result($framemodel);
?>
