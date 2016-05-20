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
$query_Recordset1 = sprintf("SELECT pr_si_core.*, m_unit.unit, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.item_code, m_e_model.mtrl_model, m_master_prop.weight_kgs, m_master_prop.dimension_m, m_master_prop.volume_m3 FROM pr_si_core, m_unit, m_master, m_e_model, m_master_prop WHERE pr_si_core.id_header = %s AND pr_si_core.id_unit=m_unit.id_unit AND pr_si_core.id_descr=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND pr_si_core.id_prop=m_master_prop.id_prop", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM pr_si_header WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_prepared = "-1";
if (isset($_GET['data'])) {
  $colname_prepared = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_prepared = sprintf("SELECT pr_si_header.req_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM pr_si_header, h_employee WHERE pr_si_header.id = %s AND pr_si_header.req_by=h_employee.id", GetSQLValueString($colname_prepared, "int"));
$prepared = mysql_query($query_prepared, $core) or die(mysql_error());
$row_prepared = mysql_fetch_assoc($prepared);
$totalRows_prepared = mysql_num_rows($prepared);

$colname_recieved = "-1";
if (isset($_GET['data'])) {
  $colname_recieved = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_recieved = sprintf("SELECT pr_si_header.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM pr_si_header, h_employee WHERE pr_si_header.id = %s  AND pr_si_header.recv_by=h_employee.id", GetSQLValueString($colname_recieved, "int"));
$recieved = mysql_query($query_recieved, $core) or die(mysql_error());
$row_recieved = mysql_fetch_assoc($recieved);
$totalRows_recieved = mysql_num_rows($recieved);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT pr_si_header.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM pr_si_header, h_employee WHERE pr_si_header.id = %s  AND pr_si_header.apprv_by=h_employee.id", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$data=$_GET['data'];
$tmpg = "select SUM(pr_si_core.weights) as total from pr_si_core where id_header='$data' "; // Cari jumlah
$hasil = mysql_query($tmpg, $core) or die(mysql_error()); // execute query
$vrb = mysql_fetch_assoc($hasil); // execute jd array
$panjang = $vrb['total'];

$tmpg11 = "select SUM(pr_si_core.volumes) as total from pr_si_core where id_header='$data' "; // Cari jumlah
$hasil11 = mysql_query($tmpg11, $core) or die(mysql_error()); // execute query
$vrb11 = mysql_fetch_assoc($hasil11); // execute jd array
$panjang11 = $vrb11['total'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />

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

</head>

<body id="printarea">
<?php
	require_once "../../dateformat_funct.php";
	if (($_SESSION['userlvl'] == 'project') || ($_SESSION['userlvl'] == 'administrator') ) {
		echo '<p class="btn"><a href="/prj/ship_inst/input_si_core.php?data='.$_GET['data'].'" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item</a></p>';
	}
?>
<table border="1" height="1200" width="1010" >
  <tr>
    <td colspan="3"><iframe width="1010" height="225" frameborder="0" src="view_si_core_header.php?data=<?php echo $_GET['data']; ?>"></iframe>
      <iframe width="1010" frameborder="0" height="1000" src="view_si_core_isi.php?data=<?php echo $_GET['data']; ?>"></iframe></td>
  </tr>
  <tr class="General">
    <td><p>Request by : </p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p><?php echo $row_prepared[firstname]; ?> <?php echo $row_prepared[midlename]; ?> <?php echo $row_prepared[lastname]; ?>
      </p></td>
    <td><p>Recieved  by : </p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p><?php echo $row_recieved[firstname]; ?><?php echo $row_recieved[midlename]; ?> <?php echo $row_recieved[lastname]; ?>
      </p></td>
    <td><p>Approved by : </p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p><?php echo $row_Recordset3[firstname]; ?> <?php echo $row_Recordset3[midlename]; ?> <?php echo $row_Recordset3[lastname]; ?>
      </p></td>
  </tr>
  <tr>
    <td><?php echo functddmmmyyyy($row_Recordset1['req_date']); ?></td>
    <td><?php echo functddmmmyyyy($row_recieved['recv_date']); ?></td>
    <td><?php echo functddmmmyyyy($row_Recordset3['apprv_date']); ?></td>
  </tr>
</table>
<table>
  <tr>
    <td><img src="/images/icon_print.gif" alt="" width="25" height="25" class="btn" onclick="PrintDoc()" /></td>
    <td><img src="/images/icon_printpw.gif" alt="" width="24" height="25" class="btn" onclick="PrintPreview()"/></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($prepared);

mysql_free_result($recieved);

mysql_free_result($Recordset3);
?>
