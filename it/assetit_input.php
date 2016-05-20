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
  $updateSQL = sprintf("UPDATE it_asset_header SET jumlah=%s, foto=%s, lokasi=%s, no_inventaris=%s, keterangan=%s, tgl_update=%s WHERE id_material=%s",
                       GetSQLValueString($_POST['jumlah'], "int"),
                       GetSQLValueString($_POST['foto'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['no_inventaris'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['tgl_update'], "text"),
                       GetSQLValueString($_POST['id_material'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE it_asset_header SET jumlah=%s, foto=%s, lokasi=%s, no_inventaris=%s, keterangan=%s WHERE id_material=%s",
                       GetSQLValueString($_POST['jumlah'], "int"),
                       GetSQLValueString($_POST['foto'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['no_inventaris'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['id_material'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
  echo "<script>
  	alert(\"Data Asset has been saved\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
  
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT it_asset_header.*, m_master.item_code, m_master.descr_name, m_master.descr_spec, m_master.id_type, m_master.id_unit, m_master.brand, m_e_model.mtrl_model, m_unit.unit FROM it_asset_header, m_master, m_e_model, m_unit WHERE it_asset_header.id = %s AND m_master.id_item = it_asset_header.id_material AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h3 { font-size:14px; font-weight:bold; }
	p {font-size:12px; font-weight:bold;}
	input { padding: 1px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
</style>

</head>

<body>
<?php { include "uploads.php"; }?>
<p><?php echo $row_Recordset1['item_code']; ?> - <?php echo $row_Recordset1['mtrl_model']; ?>, <?php echo $row_Recordset1['brand']; ?></p>
<table width="383" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2"><input type="text" name="idmsps" id="idmsps" value="<?php echo $row_Recordset1['idms']; ?>" /></td>
  </tr>
  <tr>
    <td width="94">Foto : </td>
    <td width="307" class="contenthdr"><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit" value="Upload" />
    </form></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="383">
    <tr>
      <td>No Iinventaris:</td>
      <td><input type="text" name="no_inventaris" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Jumlah:</td>
      <td><input type="text" name="jumlah" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Lokasi:</td>
      <td><input type="text" name="lokasi" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Keterangan:</td>
      <td><textarea name="keterangan" id="keterangan" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td><input type="text" name="id_material" id="id_material" value="" /></td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <p>		<?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang; ?></b>
            
            <input name="tgl_update" type="hidden" id="tgl_update" value="<?php echo $sekarang; ?>" />
    <input type="text" name="foto" id="nama_fileps" value="<?php echo $nama_file; ?>" size="32" />
  </p>
  <p></p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
