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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT f_monitoring_activity_header.id, f_monitoring_activity_header.crf, f_monitoring_activity_header.`date`, f_monitoring_activity_header.revisi, f_monitoring_activity_header.preparedby, f_monitoring_activity_header.approvedby, f_monitoring_activity_header.status, a_crf.nocrf, a_crf.jobtitle, a_crf.projectcode, a_crf.productioncode FROM f_monitoring_activity_header, a_crf WHERE a_crf.id = f_monitoring_activity_header.crf";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/general.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p>Monitoring Activity <?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['productioncode']; ?></p>
<p><a href="prj/inputmonitoringactivity.php">Input New Monitoring Activity</a></p>
<table width="736" border="0">
  <tr class="General">
    <td width="162" bgcolor="#CCCCCC">Job Title</td>
    <td width="195" bgcolor="#CCCCCC">Project Code</td>
    <td width="213" bgcolor="#CCCCCC">Fabrication Start</td>
    <td width="148" bgcolor="#CCCCCC">Fabrication End</td>
  </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="post" action="">
    <tr>
      <td><?php echo $row_Recordset1['jobtitle']; ?></td>
      <td><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['productioncode']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<tr>
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
