<?php require_once('../../Connections/core.php'); ?>
<?php require_once ('Classes/PHPExcel.php'); ?>
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

mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_absen_core WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// Time Calculation operation
/**
 * @param $in
 * @param $out
 * @return int
 */
function totalTime($in, $out) {
  $IN = new DateTime($in);
  $OUT = new DateTime($out);

  $diff = $IN->diff($OUT);
  return printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Time Card Details</title>
</head>

<body>
<a href="http://erp.btubpn.com/hrd/absnkary/excel.php?data=1">Excel</a>
<table border="1" id="timecarddetail">
<?php
        echo"<tr><td>";
        echo "<b>Date </b>";
        echo"</td>";
        echo"<td>";
        echo "<b>In Time </b>";
        echo"</td>";
        echo"<td>";
        echo "<b>Out Time </b>";
        echo"</td>";
        echo "<td><b>Total Time </b></td></tr>";

      do {
        //echo totalTime($IN, $OUT) ;
        echo"<tr><td>";
        echo date('Y-m-d', strtotime($row_Recordset1['intime']));
        echo"</td>";
        echo"<td>";
        echo $row_Recordset1['intime'];
        echo"</td>";
        echo"<td>";
        echo $row_Recordset1['outtime'];
        echo"</td>";
        echo "<td>";
        echo totalTime($row_Recordset1['intime'],$row_Recordset1['outtime']);
        echo"</td></tr>";

      } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
