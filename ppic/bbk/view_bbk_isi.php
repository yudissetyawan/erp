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

$colname_p_bbk_core = "-1";
if (isset($_GET['data'])) {
  $colname_p_bbk_core = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_bbk_core = sprintf("SELECT * FROM p_bbk_core WHERE id_header = %s", GetSQLValueString($colname_p_bbk_core, "int"));
$p_bbk_core = mysql_query($query_p_bbk_core, $core) or die(mysql_error());
$row_p_bbk_core = mysql_fetch_assoc($p_bbk_core);
$totalRows_p_bbk_core = mysql_num_rows($p_bbk_core);$colname_p_bbk_core = "-1";
if (isset($_GET['data'])) {
  $colname_p_bbk_core = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_bbk_core = sprintf("SELECT p_bbk_core.*, m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_unit.unit, m_master.id_type, a_production_code.projectcode, a_production_code.productioncode FROM p_bbk_core, p_bbk_header, m_master, m_e_model, m_unit, a_production_code WHERE p_bbk_core.id_header = %s  AND p_bbk_core.id_header=p_bbk_header.id AND p_bbk_core.id_item=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND m_unit.id_unit=p_bbk_core.unit AND p_bbk_core.id_prod_code=a_production_code.id", GetSQLValueString($colname_p_bbk_core, "int"));
$p_bbk_core = mysql_query($query_p_bbk_core, $core) or die(mysql_error());
$row_p_bbk_core = mysql_fetch_assoc($p_bbk_core);
$totalRows_p_bbk_core = mysql_num_rows($p_bbk_core);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/layoutforprint.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" width="670">
  <tr class="tabel_header">
    <td width="17"><div align="center"><strong>No</strong></div></td>
    <td width="115"><div align="center"><strong>Kode Barang</strong></div></td>
    <td width="251"><div align="center"><strong>Nama Barang</strong></div></td>
    <td width="109"><div align="center"><strong>Kode Produksi</strong></div></td>
    <td width="57"><div align="center"><strong>QTY</strong></div></td>
    <td width="186"><div align="center"><strong>Keterangan</strong></div></td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1; ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_p_bbk_core[item_code]; ?></td>
      <td><?php echo $row_p_bbk_core['mtrl_model']; ?> (<?php echo $row_p_bbk_core['descr_name']; ?>) <?php echo $row_p_bbk_core['id_type']; ?> <?php echo $row_p_bbk_core['brand']; ?></td>
      <td align="center"><?php echo $row_p_bbk_core[projectcode]; ?> - <?php echo $row_p_bbk_core[productioncode]; ?></td>
      <td align="center"><?php echo $row_p_bbk_core[qty]; ?> <?php echo $row_p_bbk_core['unit']; ?></td>
      <td align="center"><?php echo $row_p_bbk_core['keterangan']; ?></td>
    </tr>
    <?php } while ($row_p_bbk_core = mysql_fetch_assoc($p_bbk_core)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($p_bbk_core);
?>
