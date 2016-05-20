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

$colname_rsbpbcore = "-1";
if (isset($_GET['data'])) {
  $colname_rsbpbcore = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsbpbcore = sprintf("SELECT p_bpb_core.*, m_master.item_code, m_e_model.mtrl_model, m_master.descr_name, m_master.id_type, m_master.brand, a_production_code.productioncode FROM p_bpb_core, p_bpb_header, m_master, m_e_model, a_production_code WHERE m_master.id_item = p_bpb_core.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND a_production_code.id = p_bpb_core.prod_code AND p_bpb_core.bpb_idheader = p_bpb_header.id AND p_bpb_header.id = %s", GetSQLValueString($colname_rsbpbcore, "int"));
$rsbpbcore = mysql_query($query_rsbpbcore, $core) or die(mysql_error());
$row_rsbpbcore = mysql_fetch_assoc($rsbpbcore);
$totalRows_rsbpbcore = mysql_num_rows($rsbpbcore);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/layoutforprint.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="670" border="0">
  <tr>
    <td width="27" height="20"><div align="center"><b>No.</b></div></td>
    <td width="115"><div align="center"><b>Item Code</b></div></td>
    <td width="329"><div align="center"><b>Name of Item</b></div></td>
    <td width="100"><div align="center"><b>Prod. Code</b></div></td>
    <td width="100"><div align="center"><b>Qty</b></div></td>
    <td width="110"><div align="center"><b>Note</b></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <?php $a=$a+1; ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_rsbpbcore['item_code']; ?></td>
      <td><?php echo $row_rsbpbcore['mtrl_model']; ?> (<?php echo $row_rsbpbcore['descr_name']; ?>) <?php echo $row_rsbpbcore['id_type']; ?> <?php echo $row_rsbpbcore['brand']; ?></td>
      <td align="center"><?php echo $row_rsbpbcore[productioncode]; ?></td>
      <td align="center"><?php echo $row_rsbpbcore[qty]; ?> <?php echo $row_rsbpbcore[unit]; ?></td>
      <td align="center"><?php echo $row_rsbpbcore[bpb_itemnote]; ?></td>
    </tr>
    <?php } while ($row_rsbpbcore = mysql_fetch_assoc($rsbpbcore)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsbpbcore);
?>
