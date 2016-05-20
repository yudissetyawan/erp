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

?>
<?php
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT a.id,a.document_no,a.crf,a.date,a.revisi,a.status FROM f_monitoring_activity_header a LEFT JOIN a_crf b ON a.crf=b.id WHERE b.idms=%s ORDER BY a.document_no ASC",GetSQLValueString($_GET['data'], "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_actv = sprintf("SELECT * FROM a_crf a JOIN e_header_bom d ON d.projectcode=a.projectcode AND d.productioncode=a.productioncode WHERE a.idms=%s AND d.status='Active'",GetSQLValueString($_GET['data'], "int"));
$recAct = mysql_query($query_actv, $core) or die(mysql_error());
$totalRowsAct = mysql_num_rows($recAct);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php if($totalRowsAct != 0) { if($totalRows_Recordset1==0) {  ?>
<p> Tidak Ada Monitoring Activity </p>
<p><a href="inputmonitoringactivity.php?data=<?php echo $_GET['data']; ?>">New Monitoring Activity</a></p>
<?php } else { ?>
<p>List Monitoring Activity</p>

<table width="994" border="0">
  <tr class="tabel_header">
    <td width="35">No </td>
    <td width="266">Document No </td>
    <td width="232">Revisi No</td>
    <td width="196">Date</td>
    <td width="154">Progress</td>
    <td width="85">Action</td>
  </tr>
  
  <?php $i=1; do { ?>
  <form id="form1" name="form1" method="post" action="">
    <tr class="tabel_body">
      <td><?php echo $i; $i++; ?></td>
      <td>MF/BTU - BPN/P/<?php echo $row_Recordset1['id']; ?></td>
      <td><?php echo $row_Recordset1['revisi']; ?></td>
      <td><?php echo $row_Recordset1['date']; ?></td>
      <td><?php echo $row_Recordset1['status']; ?></td>
      <td>
	  <?php
	  	mysql_select_db($database_core, $core);
		$query_Recordq = "SELECT a.id, a.description, b.spec FROM f_monitoring_activity_header_core a LEFT JOIN c_material b ON a.specmat=b.id WHERE monitoringactivityheader = '".$row_Recordset1['id']."' ";
		$Recordq = mysql_query($query_Recordq, $core);
		$row_Recordq = mysql_fetch_assoc($Recorq);
		$totalRows_Recordq = mysql_num_rows($Recordq); 
	  ?>
	  <?php if( $totalRows_Recordq > 0 ){ ?><a href="viewmonitoringactivitydetail.php?data=<?php echo $row_Recordset1['id']; ?>&idms=<?php echo $_GET['data']; ?>">Detail</a><?php } else { ?><a href="retriveBOMtoMActivity.php?idms=<?php echo $_GET['data'] ?>&header=<?php echo $row_Recordset1['id']; ?>" >retrive data</a> <?php } ?></td>
      </tr>
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</table>


<?php }
} ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>