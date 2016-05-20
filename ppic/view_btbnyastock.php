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

$colname_btb = "-1";
if (isset($_GET['data'])) {
  $colname_btb = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_btb = sprintf("SELECT p_btb_core.*, p_btb_header.no_btb, m_master.item_code, m_master.descr_name, m_master.id_mstd, m_master.descr_spec, m_master.brand, m_master.id_unit, m_unit.unit FROM p_btb_core, p_btb_header, m_master, m_unit WHERE p_btb_core.id_item = %s AND p_btb_core.id_header = p_btb_header.id AND p_btb_core.id_item = m_master.id_item AND m_master.id_unit = m_unit.id_unit", GetSQLValueString($colname_btb, "int"));
$btb = mysql_query($query_btb, $core) or die(mysql_error());
$row_btb = mysql_fetch_assoc($btb);
$totalRows_btb = mysql_num_rows($btb);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="817" border="0">
  <tr class="tabel_header">
    <td>No</td>
    <td>Kode Barang</td>
    <td>Nama</td>
    <td>Quantity</td>
    <td>No BTB</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td><?php echo $row_btb['item_code']; ?></td>
      <td><?php echo $row_btb['mtrl_model']; ?> <?php echo $row_btb['descr_name']; ?> <?php echo $row_btb['descr_spec']; ?> <?php echo $row_btb['brand']; ?></td>
      <td align="center"><?php echo $row_btb['qty']; ?> <?php echo $row_btb['unit']; ?></td>
      <td align="center"><?php echo $row_btb['no_btb']; ?></td>
    </tr>
    <?php } while ($row_btb = mysql_fetch_assoc($btb)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($btb);
?>
