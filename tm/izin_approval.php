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
$query_Recordset1 = sprintf("SELECT h_employee.*, h_izin.* FROM h_employee, h_izin WHERE h_izin.id = %s AND h_izin.employee=h_employee.id", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rscmbapprovedby = "SELECT h_employee.firstname AS apprv_fname, h_employee.midlename AS apprv_mname, h_employee.lastname AS apprv_lname FROM h_employee WHERE h_employee.id = '$vcmbapprovedby'";
$rscmbapprovedby = mysql_query($query_rscmbapprovedby, $core) or die(mysql_error());
$row_rscmbapprovedby = mysql_fetch_assoc($rscmbapprovedby);
$totalRows_rscmbapprovedby = mysql_num_rows($rscmbapprovedby);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="417">
  <tr>
    <td colspan="3">Surat Izin
      <input name="employee" type="hidden" id="employee" value="<?php echo $row_Recordset1['id']; ?>" /></td>
  </tr>
  <tr>
    <td width="108"> Nik</td>
    <td width="7">:</td>
    <td width="286"><?php echo $row_Recordset1['nik']; ?></td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
  </tr>
  <tr>
    <td>Departemen</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['department']; ?></td>
  </tr>
  <tr>
    <td>Bagian</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['jabatan']; ?></td>
  </tr>
  <tr class="tabel_header">
    <td class="tabel_header">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['tanggal']; ?></td>
  </tr>
  <tr>
    <td>Untuk Keperluan</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['keperluan']; ?></td>
  </tr>
  
  <tr>
    <td colspan="3" align="center"><select name="approval" id="approval">
      <option value="Y">Approve</option>
      <option value="N">Deny</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="submit" name="submit" id="submit" value="Submit" /></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rscmbapprovedby);
?>
