<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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

mysql_select_db($database_core, $core);
$query_rsdept = "SELECT DISTINCT h_employee.department FROM h_employee";
$rsdept = mysql_query($query_rsdept, $core) or die(mysql_error());
$row_rsdept = mysql_fetch_assoc($rsdept);
$totalRows_rsdept = mysql_num_rows($rsdept);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of User Manual</title>
<link rel="stylesheet" type="text/css" href="../css/induk.css" />
</head>

<body class="General">
<table width="400">
  <tr class="tabel_header" height="40">
    <td width="30">No.</td>
    <td width="150">Department</td>
    <td>Total of Employee</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $j = $j+1; echo $j; ?></td>
      <td><?php echo $row_rsdept['department']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } while ($row_rsdept = mysql_fetch_assoc($rsdept)); ?>
</table>
</body>
</html>
<?php
	mysql_free_result($rsdept);
?>