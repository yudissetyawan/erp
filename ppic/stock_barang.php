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
$query_description = "SELECT p_stock_item.*, m_master.id_item, m_master.item_code, m_master.descr_name, m_master.descr_spec, m_e_model.mtrl_model, m_master.id_mstd, m_unit.unit, m_master.brand FROM p_stock_item, m_master, m_e_model, m_unit WHERE m_master.id_item = p_stock_item.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit";
$description = mysql_query($query_description, $core) or die(mysql_error());
$row_description = mysql_fetch_assoc($description);
$totalRows_description = mysql_num_rows($description);

$colname_in = "-1";
if (isset($_GET['data'])) {
  $colname_in = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_in = sprintf("SELECT * FROM p_btb_core WHERE id_item = %s", GetSQLValueString($colname_in, "int"));
$in = mysql_query($query_in, $core) or die(mysql_error());
$row_in = mysql_fetch_assoc($in);
$totalRows_in = mysql_num_rows($in);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h2>Stock of Item</h2>
<table width="847" border="0">
  <tr class="tabel_header">
    <td width="31">No</td>
    <td width="115">Kode Barang</td>
    <td width="335">Nama</td>
    <td width="84">In (BTB dan BBK)</td>
    <td width="128">Out (BPB)</td>
    <td width="128">Stock</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php
  $iditem = $row_description['id_item'];
	mysql_select_db($database_core, $core);
	$query_qty = "SELECT SUM(p_btb_core.qty+p_bbk_core.qty) AS jml FROM p_btb_core, p_bbk_core WHERE p_btb_core.id_item = '$iditem' OR p_bbk_core.id_item = '$iditem'";
	$qty = mysql_query($query_qty, $core) or die(mysql_error());
	$row_qty = mysql_fetch_assoc($qty);
	$totalRows_qty = mysql_num_rows($qty);
	
	$iditem = $row_description['id_item'];
	mysql_select_db($database_core, $core);
	$query_qtybbk = "SELECT SUM(p_bbk_core.qty) AS jml_bbk FROM p_bbk_core WHERE p_bbk_core.id_item = '$iditem'";
	$qtybbk = mysql_query($query_qtybbk, $core) or die(mysql_error());
	$row_qtybbk = mysql_fetch_assoc($qtybbk);
	$totalRows_qtybbk = mysql_num_rows($qtybbk);
	
	$iditem = $row_description['id_item'];
	mysql_select_db($database_core, $core);
	$query_qtyout = "SELECT SUM(p_bpb_core.qty) AS jml_out FROM p_bpb_core WHERE p_bpb_core.id_item = '$iditem'";
	$qtyout = mysql_query($query_qtyout, $core) or die(mysql_error());
	$row_qtyout = mysql_fetch_assoc($qtyout);
	$totalRows_qtyout = mysql_num_rows($qtyout);
	
	 $b=$b+1 ?>
      <td align="center"><?php echo $b; ?></td>
      <td align="center"><?php echo $row_description['item_code']; ?></td>
      <td><?php echo $row_description['mtrl_model']; ?> <?php echo $row_description['descr_name']; ?> <?php echo $row_description['descr_spec']; ?> <?php echo $row_description['brand']; ?></td>
      <td align="center"><a href="stock_btblist.php?data=<?php echo $row_description['id_item']; ?>"><?php $jumlahin=$row_qty['jml']+$row_qtybbk['jml_bbk']; echo $jumlahin; ?> <?php echo $row_description['unit']; ?></a></td>
      <td align="center"><a href="stock_bpblist.php?data=<?php echo $row_description['id_item']; ?>"><?php echo $row_qtyout['jml_out']; ?> <?php echo $row_description['unit']; ?></a></td>
      <td align="center"><?php $now=$row_qty['jml']-$row_qtyout['jml_out']+$row_qtybbk['jml_bbk']; echo $now;  ?> <a href="stock_bpblist.php?data=<?php echo $row_description['id_item']; ?>"><?php echo $row_description['unit']; ?></a></td>
    </tr>
    <?php } while ($row_description = mysql_fetch_assoc($description)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($stock);

mysql_free_result($description);

mysql_free_result($in);
?>
