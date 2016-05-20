<?php require_once('../../Connections/core.php'); ?>
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
  $updateSQL = sprintf("UPDATE h_experiences SET id_datapribadi=%s, id_h_employee=%s, pengalaman=%s, nama_instansi=%s, lokasi=%s, bagian=%s, jabatan=%s, uraian=%s, tgl_masuk=%s, tgl_keluar=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_datapribadi'], "text"),
                       GetSQLValueString($_POST['id_h_employee'], "int"),
                       GetSQLValueString($_POST['pengalaman'], "text"),
                       GetSQLValueString($_POST['nama_instansi'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['bagian'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['uraian'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "text"),
                       GetSQLValueString($_POST['tgl_keluar'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_experiences WHERE id = %s", GetSQLValueString($colname_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="422" align="center">
    <tr>
      <td width="130">&nbsp;</td>
      <td width="280"><?php echo $row_Recordset6['id']; ?></td>
    </tr>
    <tr>
      <td>Pengalaman:</td>
      <td><input type="text" name="pengalaman" value="<?php echo htmlentities($row_Recordset6['pengalaman'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Nama_instansi:</td>
      <td><input type="text" name="nama_instansi" value="<?php echo htmlentities($row_Recordset6['nama_instansi'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Lokasi:</td>
      <td><input type="text" name="lokasi" value="<?php echo htmlentities($row_Recordset6['lokasi'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Bagian:</td>
      <td><input type="text" name="bagian" value="<?php echo htmlentities($row_Recordset6['bagian'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Jabatan:</td>
      <td><input type="text" name="jabatan" value="<?php echo htmlentities($row_Recordset6['jabatan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Uraian:</td>
      <td><input type="text" name="uraian" value="<?php echo htmlentities($row_Recordset6['uraian'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td><input type="text" name="tgl_masuk" value="<?php echo htmlentities($row_Recordset6['tgl_masuk'], ENT_COMPAT, 'utf-8'); ?>" size="32" /> 
        / 
        <input type="text" name="tgl_keluar" value="<?php echo htmlentities($row_Recordset6['tgl_keluar'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="id_h_employee" value="<?php echo $row_Recordset6['id_h_employee']; ?>" size="32" />
<input type="hidden" name="id_datapribadi" value="<?php echo htmlentities($row_Recordset6['id_datapribadi'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
<input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset6['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset6);
?>
