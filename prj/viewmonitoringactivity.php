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

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) { ?>
<?
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

?>
<?php
mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM f_monitoring_activity_header ORDER BY document_no ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p>List Monitoring Activity</p>
<p><a href="../inputmonitoringactivity.php">New Monitoring Activity</a></p>
<table width="888" border="0">
  <tr class="tabel_header">
    <td width="35">No </td>
    <td width="322">Document No </td>
    <td width="213">Revisi No</td>
    <td width="148">Date</td>
    <td width="148">Progress</td>
  </tr>
  
  <?php $i=1; do { ?>
  <form id="form1" name="form1" method="post" action="">
    <tr class="tabel_body">
      <td><?php echo $i; $i++; ?></td>
      <td><a href="../view_monitoringactivitydetail.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['document_no']; ?></a></td>
      <td><?php echo $row_Recordset1['revisi']; ?></td>
      <td><?php echo $row_Recordset1['date']; ?></td>
      <td><?php echo $row_Recordset1['status']; ?></td>
      
    </tr>
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

 
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

?>
