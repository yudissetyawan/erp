<?php require_once('../Connections/core.php'); ?>
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

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT p_mr_header.*, a_production_code.projectcode, a_production_code.productioncode FROM p_mr_header, a_production_code WHERE p_mr_header.id = %s AND a_production_code.id = p_mr_header.id_prodcode", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT p_mr_core.id, p_mr_core.itemmr, p_mr_core.qty, p_mr_core.dateinuse, p_mr_core.tobeuse, p_mr_core.remark, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS itemunit FROM p_mr_core, m_master, m_e_model, m_unit WHERE p_mr_core.mrheader = %s AND p_mr_core.itemmr = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_rscoremr = "-1";
if (isset($_GET['data'])) {
  $colname_rscoremr = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rscoremr = sprintf("SELECT DISTINCT p_mr_core . * , m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS MRunit, c_po_header.podate, p_btb_header.tanggal AS BTBdate
FROM p_mr_header, p_mr_core, m_master, m_e_model, m_unit, c_po_header, c_po_core, p_btb_header
WHERE p_mr_core.itemmr = m_master.id_item
AND m_master.id_mmodel = m_e_model.id_mmodel
AND m_master.id_unit = m_unit.id_unit
AND p_mr_core.mrheader = %s
AND p_mr_core.mrheader = p_mr_header.id
AND p_mr_header.id = c_po_header.mrno", GetSQLValueString($colname_rscoremr, "text"));
$rscoremr = mysql_query($query_rscoremr, $core) or die(mysql_error());
$row_rscoremr = mysql_fetch_assoc($rscoremr);
$totalRows_rscoremr = mysql_num_rows($rscoremr);
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
<?php { require_once "../dateformat_funct.php"; } ?>
<p class="buatform">Item of MR No. : <b><?php echo $row_Recordset3['nomr']; ?></b></p>

<table width="1000" class="table">
    <tr align="center" class="tabel_header" height="30">
      <td width="20"><b>No.</b></td>
      <td width="263"><b>Description</b></td>
      <td width="145"><b>Spec.</b></td>
      <td width="48"><b>Qty</b></td>
      <td width="86"><b>Date In Use</b></td>
      <td width="170"><b>To be Used</b></td>
      <td width="70"><b>Prod. Code</b></td>
      <td><b>Remark</b></td>
    </tr>
    <?php do { ?>
      <tr class="tabel_body"><?php $a=$a+1; ?>
        <td align="center"><?php echo $a; ?></td>
        <td><?php echo $row_Recordset1['mtrl_model']; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></td>
        <td><?php echo $row_Recordset1['descr_spec']; ?></td>
        <td align="center"><?php echo $row_Recordset1[qty]; ?> <?php echo $row_Recordset1[itemunit]; ?></td>
        <td align="center"><?php echo functddmmmyyyy($row_Recordset1[dateinuse]); ?></td>
        <td align="center"><?php echo $row_Recordset1[tobeuse]; ?></td>
        <td align="center"><?php echo $row_Recordset3[prodcode]; ?></td>
        <td width="142"><?php echo $row_Recordset1['remark']; ?></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>

</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset3);
	mysql_free_result($rscoremr);
?>