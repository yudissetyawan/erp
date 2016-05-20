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
$query_Recordset1 = sprintf("SELECT p_bpb_core.*, m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.id_mstd, m_master.descr_spec, m_master.id_type, m_master.brand, m_unit.unit, p_bpb_header.bpb_no, p_bpb_header.bpb_date FROM p_bpb_core, m_master, m_e_model, m_unit, p_bpb_header WHERE p_bpb_core.id_item = %s AND m_master.id_item = p_bpb_core.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit AND p_bpb_header.id = p_bpb_core.bpb_idheader", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0">
  <tr class="tabel_header">
    <td width="17">No</td>
    <td width="118">Kode Barang</td>
    <td width="437">Nama</td>
    <td width="87">Qty</td>
    <td width="183">No BPB</td>
    <td width="120">Tanggal</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_Recordset1['item_code']; ?></td>
      <td><?php echo $row_Recordset1['mtrl_model']; ?><?php echo $row_Recordset1['descr_name']; ?> <?php echo $row_Recordset1['descr_spec']; ?> <?php echo $row_Recordset1['brand']; ?></td>
      <td align="center"><?php echo $row_Recordset1['qty']; ?> <?php echo $row_Recordset1['unit']; ?></td>
      <td><?php echo $row_Recordset1['bpb_no']; ?></td>
      <td><?php echo $row_Recordset1['bpb_date']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
