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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}

mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c.*, o.descr_name, o.descr_spec, o.item_code, o.id_mstd, o.brand,  d.unit, e.mtrl_model 
FROM c_po_core c, m_master o, m_unit d, m_e_model e WHERE c.itemno=o.id_item AND o.id_mmodel=e.id_mmodel AND c.qty=d.id_unit and poheader = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT c_po_header.*, c_vendor.vendorname, c_vendor.vendoraddress, c_vendor.officephone, c_vendor.email, p_mr_header.nomr, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM c_po_header, c_vendor, p_mr_header, h_employee WHERE c_po_header.id = %s AND c_vendor.id = c_po_header.vendor AND c_po_header.mrno=p_mr_header.id AND h_employee.id=c_po_header.pc", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c_po_core.*, m_master.descr_name, m_master.id_mstd, m_master.descr_spec, m_master.id_type, m_master.brand, m_master.item_code, m_e_model.mtrl_model, m_unit.unit AS units FROM c_po_core, m_master, m_e_model, m_unit WHERE c_po_core.poheader = %s AND c_po_core.itemno = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND c_po_core.unit = m_unit.id_unit", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$data=$_GET['data'];
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
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">/*
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
}*/
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
</script>

</head>

<body  id="printarea" class="General">
<link href="../css/layoutforprint.css" type="text/css" />
<table width="987" border="0">
  <tr class="tabel_header">
    <td width="23">No</td>
    <td width="550">Description &amp; Specification </td>
    <td width="41">QTY</td>
    <td width="92">U/M</td>
    <td width="150">Unit Price</td>
    <td width="150"> Total Price</td>
    <td width="149">Inv. Code</td>
    <td width="60">&nbsp;</td>
  </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="post" action="">
  <tr class="tabel_body"><?php $a=$a+1; ?>
    <td align="center"><?php echo $a; ?></td>
    <td><?php echo $row_Recordset1['mtrl_model']; ?> <?php echo $row_Recordset1['descr_name']; ?> <?php echo $row_Recordset1['descr_spec']; ?> <?php echo $row_Recordset1['brand']; ?></td>
    <td align="center"><?php echo $row_Recordset1[qty]; ?></td>
    <td><?php echo $row_Recordset1['units']; ?></td>
    <td valign="top"> 
      <div align="right"><?php
	  if($row_Recordset2[cur]==1) {
		echo "Rp."." ". (number_format($row_Recordset1['unitprice'],2,',','.'));
		} else { 
			echo "$"." ". (number_format($row_Recordset1['unitprice'],2));
			} ?></div></td>
    <td>
      <div align="right"><?php
	  if($row_Recordset2[cur]==1) {
		echo "Rp."." ".(number_format($row_Recordset1['totalprice'],2,',','.'));
		} else { 
			echo "$"." ".(number_format($row_Recordset1['totalprice'],2));
			} ?></div></td>
    <td align="center"><?php echo $row_Recordset1['item_code']; ?></td>
    <td align="center"><a href="delpocore.php?data=<?php echo $row_Recordset1['id']; ?>&data2=<?php echo $row_Recordset1['poheader']; ?>">Cancel</a></td>
  </tr>
  
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  
  
  <tr>
    <td colspan="4" rowspan="5">&nbsp;</td>
    <td><strong>Subtotal</strong></td>
    <td> <div align="right"><?php 
	if($row_Recordset2[cur]==1) {
		echo "Rp."." ". (number_format($panjang,2,',','.'));
		} else { 
			echo "$"." ".(number_format($panjang,2));
			}?></div></td>
    <td rowspan="5">&nbsp;</td>
    <td rowspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Discount</strong></td>
    <td> <div align="right"><?php $disc=$row_Recordset2['discount']/100*$panjang; 
	 if($row_Recordset2[cur]==1) {
		echo "Rp."." ". (number_format($disc,2,',','.'));
		} else { 
			echo "$"." ".(number_format($disc,2));
			} ?></div></td>
  </tr>
  <tr>
    <td><strong>Tax</strong></td>
    <td><div align="right"><?php $tax = $row_Recordset2['tax']/100*$panjang; 
	 if($row_Recordset2[cur]==1) {
		echo "Rp."." ". (number_format($tax,2,',','.'));
		} else { 
			echo "$"." ".(number_format($tax,2));
			} ?></div>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row_Recordset2['other_pay']; ?></td>
    <td align="right"><?php if($row_Recordset2[cur]==1) {
		echo "Rp."." ". (number_format($row_Recordset2['value_other_pay'],2,',','.'));
		} else { 
			echo "$"." ".(number_format($row_Recordset2['value_other_pay'],2));
			} ?></td>
  </tr>
  <tr>
    <td bgcolor="#FF9900"><strong>Total</strong></td>
    <td bgcolor="#FF9900"><div align="right"><?php $total=$panjang-$disc+$tax+$row_Recordset2['value_other_pay']; 
	if($row_Recordset2[cur]==1) {
		echo "Rp."." ". (number_format($total,2,',','.'));
		} else { 
			echo "$"." ".(number_format($total,2));
			}   ?></div></td>
  </tr>
  <tr>
    <td colspan="8">Notes : 
      <form id="form2" name="form2" method="post" action="">
        <label for="textarea"></label>
        
        <textarea class="General" name="textarea" id="textarea" style="border:thin" cols="45" rows="10"><?php echo $row_Recordset2['note']; ?></textarea>
    </form></td>
  </tr>
</table>
<!--<p><a href="viewpodetail_ready.php?data=<?php // echo $row_Recordset1['poheader']; ?>"><img src="/images/icon_printpw.gif" alt="" width="24" height="25" class="btn" /></a></p>!-->
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
