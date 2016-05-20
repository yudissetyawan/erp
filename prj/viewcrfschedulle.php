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
<p>CRF <strong><?php echo $row_Recordset1['nocrf']; ?></strong> Schedulle </p>
<p><a href="inputcrfschedulle.php?data=<?php echo $row_Recordset1['id']; ?>">Input Schedulle</a></p>
<table width="485" border="0">
  <tr>
    <td width="68" class="tabel_header">Schedulle</td>
    <td width="194" class="tabel_header">Start Date</td>
    <td width="204" class="tabel_header">End Date</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Design</td>
    <td class="tabel_body"><?php echo $row_Recordset2['designstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['designend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Drawing</td>
    <td class="tabel_body"><?php echo $row_Recordset2['drawingstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['drawingend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">ITP</td>
    <td class="tabel_body"><?php echo $row_Recordset2['itpstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['itpend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Material</td>
    <td class="tabel_body"><?php echo $row_Recordset2['materialstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['materialend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Fabrication</td>
    <td class="tabel_body"><?php echo $row_Recordset2['fabricationstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['fabricationend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Testing</td>
    <td class="tabel_body"><?php echo $row_Recordset2['testingstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['testingend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Blasting Painting</td>
    <td class="tabel_body"><?php echo $row_Recordset2['blastingpaintingstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['blastingpaintingend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Delivery</td>
    <td class="tabel_body"><?php echo $row_Recordset2['deliverystart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['deliveryend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Instalation</td>
    <td class="tabel_body"><?php echo $row_Recordset2['instalationstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['instalationend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">Others</td>
    <td class="tabel_body"><?php echo $row_Recordset2['othersstart']; ?></td>
    <td class="tabel_body"><?php echo $row_Recordset2['othersend']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="tabel_body">&nbsp;</td>
    <td class="tabel_body">&nbsp;</td>
    <td class="tabel_body">&nbsp;</td>
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
