<?php require_once('../../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$colname_rspono = "-1";
if (isset($_GET['data'])) {
  $colname_rspono = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rspono = sprintf("SELECT id, pono FROM c_po_header WHERE c_po_header.id = %s", GetSQLValueString($colname_rspono, "int"));
$rspono = mysql_query($query_rspono, $core) or die(mysql_error());
$row_rspono = mysql_fetch_assoc($rspono);
$totalRows_rspono = mysql_num_rows($rspono);

$colname_rspocore = "-1";
if (isset($_GET['data'])) {
  $colname_rspocore = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rspocore = sprintf("SELECT c_po_core.*, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS itemunit FROM c_po_core, m_master, m_e_model, m_unit WHERE c_po_core.poheader = %s AND c_po_core.itemno = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit", GetSQLValueString($colname_rspocore, "text"));
$rspocore = mysql_query($query_rspocore, $core) or die(mysql_error());
$row_rspocore = mysql_fetch_assoc($rspocore);
$totalRows_rspocore = mysql_num_rows($rspocore);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>M/S Request</title>
<link rel="stylesheet" type="text/css" href="../css/styles.css" />

<style type="text/css">
	table {border-collapse:collapse;}
		.tdclass{border-right:1px solid #333333;}
		body{
			font: 75.5% "Trebuchet MS", sans-serif;
			margin: 50px;
			margin-left: 5px;
			margin-top: 5px;
			margin-right: 5px;
			margin-bottom: 5px;
}
	.demoHeaders { margin-top: 2em; }

	#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
	#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
	ul#icons {margin: 0; padding: 0;}
	ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
	ul#icons span.ui-icon {float: left; margin: 0 4px;}
.headerdate {
	text-align: left;
}
.headertable {
	text-align: center;
	color: #FFF;
	font-weight: 900;
}
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>

<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php // { require_once "../dateformat_funct.php"; } ?>
<p class="buatform">Item of PO No. : <b><?php echo $row_rspono['pono']; ?></b></p>

<table width="1000" class="table">
    <tr align="center" class="tabel_header" height="30">
      <td width="20"><b>No.</b></td>
      <td width="263"><b>Description</b></td>
      <td width="145"><b>Spec.</b></td>
      <td width="48"><b>Qty</b></td>
      <td width="86"><b>Total Price</b></td>
      <td width="170"><b>Price After Discount</b></td>
      <td width="70"><b>Currency</b></td>
      <td><b>Remark</b></td>
    </tr>
    <?php do { ?>
      <tr class="tabel_body">
        <td align="center"><?php $a=$a+1; echo $a; ?></td>
        <td><?php echo $row_rspocore['mtrl_model']; ?> (<?php echo $row_rspocore['descr_name']; ?>) <?php echo $row_rspocore['id_type']; ?> <?php echo $row_rspocore['brand']; ?></td>
        <td><?php echo $row_rspocore['descr_spec']; ?></td>
        <td align="center"><?php echo $row_rspocore[qty]; ?> <?php echo $row_rspocore[itemunit]; ?></td>
        <td align="center"><?php echo $row_rspocore['totalprice']; ?></td>
        <td align="center"><?php echo $row_rspocore['popriceafterdisc']; ?></td>
        <td align="center"><?php echo $row_rspocore['cur']; ?></td>
        <td width="142"><?php echo $row_rspocore['remark_pocore']; ?></td>
      </tr>
      <?php } while ($row_rspocore = mysql_fetch_assoc($rspocore)); ?>
</table>
</body>

</html>
<?php
	mysql_free_result($rspocore);
	mysql_free_result($rspono);
?>