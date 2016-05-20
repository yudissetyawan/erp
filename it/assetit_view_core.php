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

$colname_fn_asset_inv = "-1";
if (isset($_GET['data'])) {
  $colname_fn_asset_inv = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_fn_asset_inv = sprintf("SELECT fn_asset_inv.*, m_master.item_code, m_master.descr_name, m_master.descr_spec, m_master.id_type, m_master.id_unit, m_master.brand, m_e_model.mtrl_model, m_unit.unit FROM fn_asset_inv, m_master, m_e_model, m_unit WHERE fn_asset_inv.id = %s AND m_master.id_item = fn_asset_inv.id_material AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit", GetSQLValueString($colname_fn_asset_inv, "int"));
$fn_asset_inv = mysql_query($query_fn_asset_inv, $core) or die(mysql_error());
$row_fn_asset_inv = mysql_fetch_assoc($fn_asset_inv);
$totalRows_fn_asset_inv = mysql_num_rows($fn_asset_inv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
<table width="941" border="0">
  <tr>
    <td colspan="7" align="center"><h3><?php echo $row_fn_asset_inv['item_code']; ?> - <?php echo $row_fn_asset_inv['mtrl_model']; ?> <?php echo $row_fn_asset_inv['brand']; ?></h3></td>
  </tr>
  <tr>
    <td colspan="7" align="center"><iframe src="upload/<?php echo $row_fn_asset_inv['foto']; ?>" width="400" height="300" style="border:none"></iframe>&nbsp;</td>
  </tr>
  <tr>
    <td width="160">No. Inventaris</td>
    <td width="4">:</td>
    <td width="238"><?php echo $row_fn_asset_inv['no_inventaris']; ?></td>
    <td width="5">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="290">&nbsp;</td>
  </tr>
  <tr>
    <td>Spesifikasi Teknis (ukuran dalam cm)</td>
    <td>:</td>
    <td><?php echo $row_fn_asset_inv['descr_spec']; ?></td>
    <td>&nbsp;</td>
    <td>Jumlah</td>
    <td>:</td>
    <td><?php echo $row_fn_asset_inv['jumlah']; ?> <?php echo $row_fn_asset_inv['unit']; ?></td>
  </tr>
  <tr>
    <td>Lokasi</td>
    <td>:</td>
    <td><?php echo $row_fn_asset_inv['lokasi']; ?></td>
    <td>&nbsp;</td>
    <td>Keterangan</td>
    <td>:</td>
    <td><?php echo $row_fn_asset_inv['keterangan']; ?></td>
  </tr>
  <tr>
    <td>Update Terakhir</td>
    <td>:</td>
    <td><?php echo $row_fn_asset_inv['tgl_update']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($fn_asset_inv);
?>
