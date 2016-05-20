<?php require_once('../../Connections/core.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form4")) {
  $updateSQL = sprintf("UPDATE h_experiences SET pengalaman=%s, nama_instansi=%s, lokasi=%s, bagian=%s, jabatan=%s, uraian=%s, tgl_masuk=%s, tgl_keluar=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['pengalaman'], "text"),
                       GetSQLValueString($_POST['nama_instansi'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['bagian'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['uraian'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "text"),
                       GetSQLValueString($_POST['tgl_keluar'], "text"),
                       GetSQLValueString($_POST['idexp'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form4")) {
  $updateSQL = sprintf("UPDATE h_experiences SET pengalaman=%s, nama_instansi=%s, lokasi=%s, bagian=%s, jabatan=%s, uraian=%s, tgl_masuk=%s, tgl_keluar=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['pengalaman'], "text"),
                       GetSQLValueString($_POST['nama_instansi'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['bagian'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['uraian'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "text"),
                       GetSQLValueString($_POST['tgl_keluar'], "text"),
                       GetSQLValueString($_POST['idexp'], "text"));

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
<form action="<?php echo $editFormAction; ?>" id="form4" name="form4" method="POST">
  <table width="675" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td class="General"><input name="idexp" type="text" class="hidentext" id="idexp" value="<?php echo $row_Recordset6['id_datapribadi']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td width="136" class="General">Kategori Experiences</td>
      <td width="10">:</td>
      <td width="328" class="General"><label for="pengalaman"></label>
        <input name="pengalaman" type="text" id="pengalaman" value="<?php echo $row_Recordset6['pengalaman']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Nama Instansi / Organisasi</td>
      <td>:</td>
      <td class="General"><label for="nama_instansi"></label>
        <input name="nama_instansi" type="text" id="nama_instansi" value="<?php echo $row_Recordset6['nama_instansi']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Lokasi</td>
      <td>:</td>
      <td class="General"><label for="lokasi"></label>
        <input name="lokasi" type="text" id="lokasi" value="<?php echo $row_Recordset6['lokasi']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Bagian</td>
      <td>:</td>
      <td class="General"><label for="bagian"></label>
        <input name="bagian" type="text" id="bagian" value="<?php echo $row_Recordset6['bagian']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Jabatan</td>
      <td>:</td>
      <td class="General"><label for="jabatan"></label>
        <input name="jabatan" type="text" id="jabatan" value="<?php echo $row_Recordset6['jabatan']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Uraian Singkat</td>
      <td>:</td>
      <td class="General"><label for="uraian"></label>
        <input name="uraian" type="text" id="uraian" value="<?php echo $row_Recordset6['uraian']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Lama</td>
      <td>&nbsp;</td>
      <td class="General"><label for="tgl_masuk"></label>
        <input name="tgl_masuk" type="text" id="tgl_masuk" value="<?php echo $row_Recordset6['tgl_masuk']; ?>" />
        s/d
        <label for="tgl_keluar"></label>
        <input name="tgl_keluar" type="text" id="tgl_keluar" value="<?php echo $row_Recordset6['tgl_keluar']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit5" id="submit4" value="Simpan" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form4" />
  <input type="hidden" name="MM_update" value="form4" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset6);
?>
