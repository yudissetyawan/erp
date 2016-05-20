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

$colname_diserahkan_by = "-1";
if (isset($_GET['data'])) {
  $colname_diserahkan_by = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_diserahkan_by = sprintf("SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.diserahkan_by FROM h_employee, p_btb_header WHERE h_employee.department = 'procurement'  AND h_employee.id=p_btb_header.diserahkan_by AND p_btb_header.id = %s", GetSQLValueString($colname_diserahkan_by, "int"));
$diserahkan_by = mysql_query($query_diserahkan_by, $core) or die(mysql_error());
$row_diserahkan_by = mysql_fetch_assoc($diserahkan_by);
$totalRows_diserahkan_by = mysql_num_rows($diserahkan_by);

mysql_select_db($database_core, $core);
$query_diterima_by = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.diterima_by FROM h_employee, p_btb_header WHERE h_employee.department = 'warehouse' AND h_employee.id = p_btb_header.diterima_by";
$diterima_by = mysql_query($query_diterima_by, $core) or die(mysql_error());
$row_diterima_by = mysql_fetch_assoc($diterima_by);
$totalRows_diterima_by = mysql_num_rows($diterima_by);

mysql_select_db($database_core, $core);
$query_diperiksa_by = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.diperiksa_by FROM h_employee, p_btb_header WHERE h_employee.userlevel = 'qly' AND h_employee.id =p_btb_header.diperiksa_by";
$diperiksa_by = mysql_query($query_diperiksa_by, $core) or die(mysql_error());
$row_diperiksa_by = mysql_fetch_assoc($diperiksa_by);
$totalRows_diperiksa_by = mysql_num_rows($diperiksa_by);

mysql_select_db($database_core, $core);
$query_accounting = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname, p_btb_header.accounting FROM h_employee, p_btb_header WHERE h_employee.department = 'finance' AND h_employee.id =p_btb_header.accounting";
$accounting = mysql_query($query_accounting, $core) or die(mysql_error());
$row_accounting = mysql_fetch_assoc($accounting);
$totalRows_accounting = mysql_num_rows($accounting);

$colname_p_btb_core = "-1";
if (isset($_GET['data'])) {
  $colname_p_btb_core = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_btb_core = sprintf("SELECT p_btb_core.*, c_po_header.mrno, m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_unit.unit, m_master.id_type, p_mr_header.nomr FROM p_btb_core, p_btb_header, c_po_header, m_master, m_e_model, m_unit, p_mr_header WHERE p_btb_core.id_header = %s AND p_btb_core.id_header=p_btb_header.id AND p_btb_header.id_po=c_po_header.id AND p_btb_core.id_item=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND m_unit.id_unit=p_btb_core.unit AND c_po_header.mrno=p_mr_header.id", GetSQLValueString($colname_p_btb_core, "int"));
$p_btb_core = mysql_query($query_p_btb_core, $core) or die(mysql_error());
$row_p_btb_core = mysql_fetch_assoc($p_btb_core);
$totalRows_p_btb_core = mysql_num_rows($p_btb_core);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/layoutforprint.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="670" border="0">
  <tr>
    <td width="27" height="18"><div align="center"><b>No</b></div></td>
    <td width="115"><div align="center"><b>Kode Barang</b></div></td>
    <td width="329"><div align="center"><b>Nama Barang</b></div></td>
    <td width="45"><div align="center"><b>Quantity</b></div></td>
    <td width="132"><div align="center"><b>No MR</b></div></td>
    <td width="40">&nbsp;</td>
  </tr>
  <?php do { ?>
  <tr>
    <?php $a=$a+1; ?>
    <td align="center"><?php echo $a; ?></td>
    <td align="center"><?php echo $row_p_btb_core['item_code']; ?></td>
    <td><?php echo $row_p_btb_core['mtrl_model']; ?> (<?php echo $row_p_btb_core['descr_name']; ?>) <?php echo $row_p_btb_core['id_type']; ?> <?php echo $row_p_btb_core['brand']; ?></td>
    <td><?php echo $row_p_btb_core[qty]; ?> <?php echo $row_p_btb_core[unit]; ?></td>
    <td align="center"><?php echo $row_p_btb_core['nomr']; ?></td>
    <td align="center"><a href="del_btb_core.php?data=<?php echo $row_p_btb_core['id']; ?>&data2=<?php echo $row_p_btb_core['id_header']; ?>">Cancel</a></td>
  </tr>
  <?php } while ($row_p_btb_core = mysql_fetch_assoc($p_btb_core)); ?>
</table>
</body>
</html>

<?php
	mysql_free_result($p_btb_header);
	mysql_free_result($diserahkan_by);
	mysql_free_result($diterima_by);
	mysql_free_result($diperiksa_by);
	mysql_free_result($accounting);
	mysql_free_result($p_btb_core);
?>
