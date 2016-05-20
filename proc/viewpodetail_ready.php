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

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT c_po_header.*, c_vendor.vendorname, c_vendor.vendoraddress, c_vendor.officephone, c_vendor.email, p_mr_header.nomr, h_employee.firstname, h_employee.midlename, h_employee.lastname, pc_termsofpay.termosfpay_descr, pc_shipment_term.shipment_term, pc_shipmentloc.shipmentloc_descr FROM c_po_header, c_vendor, p_mr_header, h_employee, pc_termsofpay, pc_shipment_term, pc_shipmentloc WHERE c_po_header.id = %s AND c_vendor.id = c_po_header.vendor AND c_po_header.mrno=p_mr_header.id AND h_employee.id=c_po_header.pc AND c_po_header.termsofpayment = pc_termsofpay.id_pterm AND c_po_header.termsshipping = pc_shipment_term.id_sterm  AND c_po_header.shipmentloc = pc_shipmentloc.id_sloc", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if (!isset($_SESSION)) {
  session_start();
}

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
<title>PO Detail</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />

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

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body id="printarea">

<?php { include "../dateformat_funct.php"; }
	if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator') ) {
		//echo '<p class="btn"><a href="inputpodetail.php?data='.$_GET['data'].'"><b>+ ADD NEW</b></a></p>'; ?>
		<p class="btn"><a href="#" onclick="MM_openBrWindow('inputpodetail.php?data=<?php echo $_GET['data']; ?>','','scrollbars=yes,resizable=yes,width=600,height=500')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item</a></p>
<?php } ?>

<table border="1" height="1200" width="1000" >
  <tr>
    <td colspan="3"><iframe width="1000" height="220" frameborder="0" src="viewpodetail_header.php?data=<?php echo $_GET['data']; ?>"></iframe>
      <iframe width="1000" frameborder="0" height="1000" src="viewpodetail.php?data=<?php echo $_GET['data']; ?>"></iframe></td>
  </tr>
  <tr class="General"><td><table width="1000" border="1">
    <tr>
      <td>Terms of Payment :<br />
        Shipment Terms :<br />
        Delivery Time :</td>
      <td colspan="2"><?php echo $row_Recordset2['termosfpay_descr']; ?><br />
        <?php echo $row_Recordset2['shipment_term']; ?>- <?php echo $row_Recordset2['shipmentloc_descr']; ?><br />
        <?php echo $row_Recordset2['deliverytime']; ?></td>
    </tr>
    <tr>
      <td>YOUR ACCEPTANCE must be on terms and conditions contained our ORDER only. No. Variations will be accepted unless confirmed by us in writing</td>
      <td width="335">&nbsp;</td>
      <td width="335" valign="baseline"><p> for : </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><strong> Bukaka Teknik Utama</strong></p></td>
    </tr>
    </table></td>
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
mysql_free_result($Recordset2);
?>
