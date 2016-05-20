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

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT c_po_header.*, c_vendor.vendorname, c_vendor.vendoraddress, c_vendor.officephone, c_vendor.email, p_mr_header.nomr, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM c_po_header, c_vendor, p_mr_header, h_employee WHERE c_po_header.id = %s AND c_vendor.id = c_po_header.vendor AND c_po_header.mrno=p_mr_header.id AND h_employee.id=c_po_header.pc", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$data = $_GET['data'];
$tmpg = "select sum(totalprice) as total from c_po_core where poheader=$data "; // Cari jumlah
$hasil = mysql_query($tmpg); // execute query
$vrb=mysql_fetch_array($hasil); // execute jd array
$panjang = ($vrb["total"]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="../js/javauni.min.js"></script>
<script src="../SpryAssets/SpryEffects.js" type="text/javascript"></script>
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet" />
<title>Purchase Order (PO) Detail</title>

<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
        popupWin.document.write('<html><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../css/print.css" /><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" media="screen"/> </head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../css/layoutforprint.css" media="screen"/></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
	
	function MM_effectShake(targetElement) {
		Spry.Effect.DoShake(targetElement);
	}
</script>

</head>

<body id="printarea" class="General">
<link href="../css/layoutforprint.css" type="text/css" />

<?php { include "../dateformat_funct.php"; } ?>
<table width="987" border="0">  <tr>
    <td width="299"><img src="../images/btubpn.jpg" width="212" height="56" /></td>
    <td width="276">&nbsp;    </td>
    <td width="411" align="center"><table height="5" border="1">
      <tr>
        <td align="center"><h1>PURCHASE ORDER</h1></td>
      </tr>
    </table>
    &nbsp;</td>
  </tr>
</table>
<br />
<table width="987" border="1" cellpadding="2" cellspacing="2">
  <tr style="border:none">
    <td width="537"><p>To: <?php echo $row_Recordset2['vendorname']; ?><br />
    <?php echo $row_Recordset2['vendoraddress']; ?><br />
    Tel. <?php echo $row_Recordset2['officephone']; ?> Fax / Email :    <?php echo $row_Recordset2['email']; ?></p></td>
    <td>Order No.
      <br />
      Date <br />
      Req. No <br />
    P/C </td>
    <td>:<br />
      :<br />
      :<br />
      :</td>
    <td><?php echo $row_Recordset2['pono']; ?><br />
      <?php echo functddmmmyyyy($row_Recordset2['podate']); ?><br />
      <?php echo $row_Recordset2['nomr']; ?><br />
    <?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Ref :</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><em>Please supply the following goods in accordance with the terms &amp; Conditions and specifications enclosed along with this order</em></td>
  </tr>
</table>

<!--<div id="dialog" title="Input">
<p>
  <?php /* Div Input */ ?>
</p>!-->
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
