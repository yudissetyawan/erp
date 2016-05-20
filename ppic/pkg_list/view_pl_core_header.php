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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT p_pl_header.*, pr_header_wpr.wo_no, pr_header_wpr.contract_no, pr_header_wpr.startdate, pr_si_header.`to`, pr_si_header.dest, pr_si_header.ship, pr_si_header.contract_no FROM p_pl_header, pr_header_wpr, pr_si_header WHERE p_pl_header.id = %s  AND p_pl_header.id_wo=pr_header_wpr.id  AND p_pl_header.id_si=pr_si_header.id", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT p_pl_core.*, m_unit.unit, m_master.descr_name, m_master.descr_spec, m_master.brand, m_e_model.mtrl_model, m_master_prop.weight_kgs, m_master_prop.dimension_m, m_master_prop.volume_m3 FROM p_pl_core, m_unit, m_master, m_e_model, m_master_prop WHERE p_pl_core.id_header = %s AND p_pl_core.id_unit=m_unit.id_unit AND m_master_prop.id_item=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND p_pl_core.id_prop=m_master_prop.id_prop", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_prepared = "-1";
if (isset($_GET['data'])) {
  $colname_prepared = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_prepared = sprintf("SELECT p_pl_header.prepared_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_pl_header, h_employee WHERE p_pl_header.id = %s AND p_pl_header.prepared_by=h_employee.id", GetSQLValueString($colname_prepared, "int"));
$prepared = mysql_query($query_prepared, $core) or die(mysql_error());
$row_prepared = mysql_fetch_assoc($prepared);
$totalRows_prepared = mysql_num_rows($prepared);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT p_pl_header.approved_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_pl_header, h_employee WHERE p_pl_header.id = %s AND p_pl_header.approved_by=h_employee.id", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$data=$_GET['data'];
$tmpg = "select SUM(p_pl_core.weights) as total from p_pl_core where id_header='$data' "; // Cari jumlah
$hasil = mysql_query($tmpg, $core) or die(mysql_error()); // execute query
$vrb = mysql_fetch_assoc($hasil); // execute jd array
$panjang = $vrb['total'];

$tmpg11 = "select SUM(p_pl_core.volumes) as total from p_pl_core where id_header='$data' "; // Cari jumlah
$hasil11 = mysql_query($tmpg11, $core) or die(mysql_error()); // execute query
$vrb11 = mysql_fetch_assoc($hasil11); // execute jd array
$panjang11 = $vrb11['total'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
.headerdate {	text-align: left;
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
 <script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../../css/print.css" /><link rel="stylesheet" type="text/css" href="../../css/untuk_printmr.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../../css/untuk_printmr.css" /></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>

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
.headerdate {	text-align: left;
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
<link href="../../css/layoutforprint.css" rel="stylesheet" type="text/css" />
</head>

<body id="printarea">
<?php require_once "../../dateformat_funct.php"; ?>
<header>
<table width="1000" border="1" cellpadding="2">
  <tr >
    <td width="104" rowspan="2"><img src="../../images/bukaka.jpg" width="102" height="24" /></td>
    <td width="467" rowspan="2" align="center"><font size="-1"><strong>PT. Bukaka Teknik Utama </strong></font><br />
      Balikpapan
    Workshop &amp; Office<br />
    Jl. Mulawarman KM.21, Manggar Balikpapan 76116 - Kalimantan Timur<br />
    Phone : (0542) 763312, Fax : (0542) 743319</td>
    <td height="25" colspan="3">No: <?php echo $row_Recordset1['no_pl']; ?></td>
  </tr>
  <tr>
    <td height="25" colspan="3">Date: <?php echo functddmmmyyyy($row_Recordset1['date']); ?></td>
  </tr>
</table>
<table width="1000" border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center" colspan="6"><font size="+1"><strong>P A C K I N G  L I S T </strong></font></td>
  </tr>
  <tr>
    <td colspan="6">To : <?php echo $row_Recordset1['to']; ?></td>
  </tr>
  <tr>
    <td width="134">Destination</td>
    <td width="7" align="center">:</td>
    <td width="176"><?php echo $row_Recordset1['dest']; ?></td>
    <td width="134">Contract No.</td>
    <td width="7" align="center">:</td>
    <td width="176"><?php echo $row_Recordset1['contract_no']; ?></td>
  </tr>
  <tr>
    <td>Shipped</td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['ship']; ?></td>
    <td>No. of Package</td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['no_pack']; ?></td>
  </tr>
  <tr>
    <td>WO. No.</td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['wo_no']; ?></td>
    <td>Type of Package </td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['type_pack']; ?></td>
  </tr>
  <tr>
    <td>WO. Dated</td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['startdate']; ?></td>
    <td>Carrier</td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['carrier']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Plat No. Reg</td>
    <td align="center">:</td>
    <td><?php echo $row_Recordset1['plat_noreg']; ?></td>
  </tr>
</table>
</header>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($prepared);

mysql_free_result($Recordset3);
?>
