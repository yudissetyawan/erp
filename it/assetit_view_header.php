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
$query_fn_asset_inv = "SELECT fn_asset_inv.*, m_master.item_code, m_master.descr_name, m_master.descr_spec, m_master.id_type, m_master.id_unit, m_master.brand, m_e_model.mtrl_model, m_unit.unit FROM fn_asset_inv, m_master, m_e_model, m_unit WHERE m_master.id_item = fn_asset_inv.id_material AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit";
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
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<table width="1450" border="0">
  <tr class="tabel_header">
    <td>No</td>
    <td>Nama Inventaris</td>
    <td>Kode Barang</td>
    <td>No. Inventaris</td>
    <td>Jumlah</td>
    <td>Foto</td>
    <td>Lokasi</td>
    <td>Keterangan</td>
    <td> Update Terakhir</td>
    <td>Action</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td><a href="assetit_view_core.php?data=<?php echo $row_fn_asset_inv['id']; ?>"><?php echo $row_fn_asset_inv['mtrl_model']; ?></a></td>
      <td><?php echo $row_fn_asset_inv['item_code']; ?></td>
      <td><?php echo $row_fn_asset_inv['no_inventaris']; ?></td>
      <td><?php echo $row_fn_asset_inv['jumlah']; ?> <?php echo $row_fn_asset_inv['unit']; ?></td>
      <td><a href="upload/<?php echo $row_fn_asset_inv['foto']; ?>" target="_blank"><?php echo $row_fn_asset_inv['foto']; ?></a></td>
      <td><?php echo $row_fn_asset_inv['lokasi']; ?></td>
      <td><?php echo $row_fn_asset_inv['keterangan']; ?></td>
      <td><?php echo $row_fn_asset_inv['tgl_update']; ?></td>
      <td align="center"><a href="#" onclick="MM_openBrWindow('assetit_update.php?data=<?php echo $row_fn_asset_inv['id']; ?>','Update Data Asset IT','scrollbars=yes,width=600,height=500')">UPDATE</a></td>
    </tr>
    <?php } while ($row_fn_asset_inv = mysql_fetch_assoc($fn_asset_inv)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($fn_asset_inv);
?>
