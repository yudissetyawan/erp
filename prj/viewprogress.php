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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT f_monitoring_activity_header.id, f_monitoring_activity_header.`date`, f_monitoring_activity_header.revisi, f_monitoring_activity_header.preparedby, f_monitoring_activity_header.approvedby, f_monitoring_activity_header.status, a_crf.nocrf, a_crf.jobtitle, a_production_code.productioncode, a_proj_code.project_code, a_crf_schedulle.fabricationstart, a_crf_schedulle.fabricationend FROM f_monitoring_activity_header, a_crf, a_production_code, a_proj_code, a_crf_schedulle WHERE a_crf.id = f_monitoring_activity_header.crf AND a_production_code.id = a_crf.productioncode AND a_proj_code.id = a_production_code.projectcode AND a_crf_schedulle.crf = a_crf.id";
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
<p>List Work Progress</p>
<p><a href="../input_monitoringactivity.php">Input New Work Progress</a></p>
<table width="1040" border="0">
  <tr class="tabel_header">
    <td width="162">Job Title</td>
    <td width="195">Project Code</td>
    <td width="213">Fabrication Start</td>
    <td width="148">Fabrication End</td>
    <td width="148">Status</td>
    <td width="148">Action</td>
  </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="post" action="">
    <tr class="tabel_body">
      <td><a href="../view_monitoringactivitydetail.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['jobtitle']; ?></a></td>
      <td> <?php echo $row_Recordset1['project_code']; ?> - <?php echo $row_Recordset1['productioncode']; ?></td>
      <td><?php echo $row_Recordset1['fabricationstart']; ?></td>
      <td><?php echo $row_Recordset1['fabricationend']; ?></td>
      <td><?php echo $row_Recordset1['status']; ?></td>
      <td><a href="../edit_monitoringactivity.php?data=<?php echo $row_Recordset1['id']; ?>">Update</a></td>
    </tr>
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<tr>
    <td>&nbsp;</td>
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
