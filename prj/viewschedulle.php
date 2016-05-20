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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM a_crf_schedulle WHERE crf = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<h3>CRF No. : <?php echo $_GET['data']; ?></h3>
<table width="480" border="0">
  <tr class="tabel_header">
    <td width="68">Schedulle</td>
    <td width="194">Start Date</td>
    <td width="204">End Date</td>
  </tr>
  <tr class="tabel_body">
    <td>Design</td>
    <td><?php echo $row_Recordset2['designstart']; ?></td>
    <td><?php echo $row_Recordset2['designend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td><? if ($row_Recordset2['drawingprogress']=='') {echo "Drawing";} else {echo  "<a href='../eng/upload_work/upload/$row_Recordset2[file_drawing]'>Drawing</a>";} ?></td>
    <td><?php echo $row_Recordset2['drawingstart']; ?></td>
    <td><?php echo $row_Recordset2['drawingend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td><? if ($row_Recordset2['itpprogress']=='') {echo "ITP";} else {echo  "<a href='../qly/upload_itp/$row_Recordset2[file_itp]'>ITP</a>";} ?></td>
    <td><?php echo $row_Recordset2['itpstart']; ?></td>
    <td><?php echo $row_Recordset2['itpend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>Material</td>
    <td><?php echo $row_Recordset2['materialstart']; ?></td>
    <td><?php echo $row_Recordset2['materialend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td><? if ($row_Recordset2['fabricationprogress']=='') {echo "Fabrication";} else {echo  "<a href='../fab/upload/ik/$row_Recordset2[file_fab]'>Fabrication</a>";} ?></td>
    <td><?php echo $row_Recordset2['fabricationstart']; ?></td>
    <td><?php echo $row_Recordset2['fabricationend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>Testing</td>
    <td><?php echo $row_Recordset2['testingstart']; ?></td>
    <td><?php echo $row_Recordset2['testingend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>Blasting Painting</td>
    <td><?php echo $row_Recordset2['blastingpaintingstart']; ?></td>
    <td><?php echo $row_Recordset2['blastingpaintingend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>Delivery</td>
    <td><?php echo $row_Recordset2['instalationstart']; ?></td>
    <td><?php echo $row_Recordset2['instalationend']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td>Instalation</td>
    <td><?php echo $row_Recordset2['deliverystart']; ?></td>
    <td><?php echo $row_Recordset2['deliveryend']; ?></td>
  </tr>
  <tr class="tabel_header">
    <td colspan="3">Others</td>
  </tr>
  <tr class="tabel_body">
    <td><?php echo $row_Recordset2['other1']; ?></td>
    <td><?php echo $row_Recordset2['other1start']; ?></td>
    <td><?php echo $row_Recordset2['other1end']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td><?php echo $row_Recordset2['other2']; ?></td>
    <td><?php echo $row_Recordset2['other2start']; ?></td>
    <td><?php echo $row_Recordset2['other2end']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td><?php echo $row_Recordset2['other3']; ?></td>
    <td><?php echo $row_Recordset2['other3start']; ?></td>
    <td><?php echo $row_Recordset2['other3end']; ?></td>
  </tr>
  <tr class="tabel_body">
    <td><?php echo $row_Recordset2['other4']; ?></td>
    <td><?php echo $row_Recordset2['other4start']; ?></td>
    <td><?php echo $row_Recordset2['other4end']; ?></td>
  </tr>
  <tr class="tabel_body">
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

mysql_free_result($Recordset2);
?>
