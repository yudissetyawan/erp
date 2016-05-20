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
$query_Recordset1 = "SELECT h_izin.id, h_izin.approval, log_pesan.isi FROM h_izin, log_pesan WHERE h_izin.approval = log_pesan.id_empdept AND log_pesan.id_inisial='61'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if (!isset($_SESSION)) {
  session_start();
}

$usrid = $_SESSION['empID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td>id</td>
    <td>employee</td>
    <td>tanggal</td>
    <td>keperluan</td>
    <td>jenis</td>
    <td>approval</td>
    <td>id_inisial</td>
    <td>id_empdept</td>
    <td>sudah_bacaYN</td>
    <td>waktu_notif</td>
    <td>isi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['id']; ?></td>
      <td><?php echo $row_Recordset1['employee']; ?></td>
      <td><?php echo $row_Recordset1['tanggal']; ?></td>
      <td><?php echo $row_Recordset1['keperluan']; ?></td>
      <td><?php echo $row_Recordset1['jenis']; ?></td>
      <td><?php echo $row_Recordset1['approval']; ?></td>
      <td><?php echo $row_Recordset1['id_inisial']; ?></td>
      <td><?php echo $row_Recordset1['id_empdept']; ?></td>
      <td><?php echo $row_Recordset1['sudah_bacaYN']; ?></td>
      <td><?php echo $row_Recordset1['waktu_notif']; ?></td>
      <td><?php echo $row_Recordset1['isi']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
