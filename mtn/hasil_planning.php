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

$colname_dms_PN = "-1";
if (isset($_GET['data'])) {
  $colname_dms_PN = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dms_PN = sprintf("SELECT * FROM dms WHERE inisial_pekerjaan = %s AND dms.id_departemen = 'mtn'  AND dms.inisial_pekerjaan = 'PN'", GetSQLValueString($colname_dms_PN, "text"));
$dms_PN = mysql_query($query_dms_PN, $core) or die(mysql_error());
$row_dms_PN = mysql_fetch_assoc($dms_PN);
$totalRows_dms_PN = mysql_num_rows($dms_PN);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM dms WHERE idms = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$dms_PN = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h2 align="center">CRF <?php echo $_GET['data']; ?> Planning</h2>
<table width="650" border="1" align="center">
  <tr class="tabel_header">
    <th scope="col">No</th>
    <th scope="col">Tanggal</th>
    <th scope="col">Inisial Pekerjaan</th>
    <th scope="col">Nama File </th>
    <th scope="col">Keterangan</th>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a = $a+1 ?>
      <td><?php echo $a ?></td>
      <td><?php echo $row_dms_PN['date']; ?></td>
      <td><?php echo $row_dms_PN['inisial_pekerjaan']; ?></td>
      <td><a href="upload/<?php echo $row_dms_PN['fileupload']; ?>"><?php echo $row_dms_PN['fileupload']; ?></a></td>
      <td><?php echo $row_dms_PN['keterangan']; ?></td>
    </tr>
    <?php } while ($row_dms_PN = mysql_fetch_assoc($dms_PN)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($dms_PN);
?>
