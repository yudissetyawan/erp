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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_cuti SET id_employee=%s, date_awal=%s, date_akhir=%s, keperluan=%s, kota_tujuan=%s, no_hp1=%s, no_hp2=%s, disetujui_oleh=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_employee'], "int"),
                       GetSQLValueString($_POST['date_awal'], "text"),
                       GetSQLValueString($_POST['date_akhir'], "text"),
                       GetSQLValueString($_POST['keperluan'], "text"),
                       GetSQLValueString($_POST['kota_tujuan'], "text"),
                       GetSQLValueString($_POST['no_hp1'], "text"),
                       GetSQLValueString($_POST['no_hp2'], "text"),
                       GetSQLValueString($_POST['disetujui_oleh'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_h_cuti = "-1";
if (isset($_GET['data'])) {
  $colname_h_cuti = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_cuti = sprintf("SELECT * FROM h_cuti WHERE id = %s", GetSQLValueString($colname_h_cuti, "int"));
$h_cuti = mysql_query($query_h_cuti, $core) or die(mysql_error());
$row_h_cuti = mysql_fetch_assoc($h_cuti);
$totalRows_h_cuti = mysql_num_rows($h_cuti);$colname_h_cuti = "-1";
if (isset($_GET['data'])) {
  $colname_h_cuti = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_cuti = sprintf("SELECT h_cuti.*, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_cuti, h_employee WHERE h_cuti.id = %s AND h_cuti.id_employee = h_employee.id", GetSQLValueString($colname_h_cuti, "int"));
$h_cuti = mysql_query($query_h_cuti, $core) or die(mysql_error());
$row_h_cuti = mysql_fetch_assoc($h_cuti);
$totalRows_h_cuti = mysql_num_rows($h_cuti);

$colname_h_employee_apprv = "-1";
if (isset($_GET['data'])) {
  $colname_h_employee_apprv = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_employee_apprv = sprintf("SELECT h_cuti.disetujui_oleh, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_cuti, h_employee WHERE h_cuti.id = %s AND h_cuti.disetujui_oleh = h_employee.id", GetSQLValueString($colname_h_employee_apprv, "int"));
$h_employee_apprv = mysql_query($query_h_employee_apprv, $core) or die(mysql_error());
$row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv);
$totalRows_h_employee_apprv = mysql_num_rows($h_employee_apprv);

mysql_select_db($database_core, $core);
$query_h_employee = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE `level` = '0' ORDER BY firstname ASC";
$h_employee = mysql_query($query_h_employee, $core) or die(mysql_error());
$row_h_employee = mysql_fetch_assoc($h_employee);
$totalRows_h_employee = mysql_num_rows($h_employee);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
* { font:Tahoma, Geneva, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h3>Edit Cuti
    <?php {include "date.php";} ?>
</h3>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  
  <table class="General">
    <tr>
      <td>NIK</td>
      <td>:</td>
      <td><label for="nik"></label>
      <input name="nik" type="text" id="nik" value="<?php echo $row_h_cuti['nik']; ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><label for="nama"></label>
      <input name="nama" type="text" id="nama" value="<?php echo $row_h_cuti['firstname']; ?> <?php echo $row_h_cuti['midlename']; ?> <?php echo $row_h_cuti['lastname']; ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td><input type="text" name="date_awal" id="tanggal1" value="<?php echo htmlentities($row_h_cuti['date_awal'], ENT_COMPAT, 'utf-8'); ?>" size="32" /> 
        s/ d 
        <input type="text" name="date_akhir" id="tanggal2" value="<?php echo htmlentities($row_h_cuti['date_akhir'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Keperluan</td>
      <td>:</td>
      <td><textarea name="keperluan" cols="45" rows="5"><?php echo htmlentities($row_h_cuti['keperluan'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr>
      <td>Kota Tujuan</td>
      <td>:</td>
      <td><input type="text" name="kota_tujuan" value="<?php echo htmlentities($row_h_cuti['kota_tujuan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap" align="right">No HP</td>
      <td>:</td>
      <td><input type="text" name="no_hp1" value="<?php echo htmlentities($row_h_cuti['no_hp1'], ENT_COMPAT, 'utf-8'); ?>" size="32" /> 
        / 
        <input type="text" name="no_hp2" value="<?php echo htmlentities($row_h_cuti['no_hp2'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Disetujui Oleh</td>
      <td>:</td>
      <td><label for="disetujui_oleh"></label>
  <select name="disetujui_oleh" id="disetujui_oleh">
  <option value="<?php echo $row_h_employee_apprv['disetujui_oleh']; ?>"><?php echo $row_h_employee_apprv['firstname']; ?> <?php echo $row_h_employee_apprv['midlename']; ?> <?php echo $row_h_employee_apprv['lastname']; ?></option>
    <?php
do {  
?>
    <option value="<?php echo $row_h_employee['id']?>"><?php echo $row_h_employee['firstname']?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?></option>
    <?php
} while ($row_h_employee = mysql_fetch_assoc($h_employee));
  $rows = mysql_num_rows($h_employee);
  if($rows > 0) {
      mysql_data_seek($h_employee, 0);
	  $row_h_employee = mysql_fetch_assoc($h_employee);
  }
?>
  </select></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  
<input type="text" name="id_employee" value="<?php echo htmlentities($row_h_cuti['id_employee'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
<input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_h_cuti['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($h_cuti);

mysql_free_result($h_employee_apprv);

mysql_free_result($h_employee);
?>
