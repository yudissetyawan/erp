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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO c_po_header (pono, podate, budgetcode, vendor, `ref`, mrno, termsofpayment, termsshipping, shipmentloc, deliverytime, pc, note, orderedby, checkedby, financeby, approvedby, discount, tax, cur, other_pay, value_other_pay) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['pono'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "date"),
                       GetSQLValueString($_POST['budgetcode'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['hfidmr'], "text"),
                       GetSQLValueString($_POST['termsofpayment'], "text"),
                       GetSQLValueString($_POST['shippingterms'], "text"),
                       GetSQLValueString($_POST['shipmentloc'], "int"),
                       GetSQLValueString($_POST['deliverytime'], "text"),
                       GetSQLValueString($_POST['pc'], "int"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['orderedby'], "int"),
                       GetSQLValueString($_POST['checkedby'], "int"),
                       GetSQLValueString($_POST['financeby'], "int"),
                       GetSQLValueString($_POST['approvedby'], "int"),
					   GetSQLValueString($_POST['discount'], "int"),
					   GetSQLValueString($_POST['tax'], "int"),
					   GetSQLValueString($_POST['cur'], "int"),
					   GetSQLValueString($_POST['other_pay'], "text"),
					   GetSQLValueString($_POST['value_other_pay'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

	$q = mysql_fetch_array(mysql_query("SELECT id FROM c_po_header ORDER BY id DESC LIMIT 1"));
	$cekID = $q['id'];
	echo "<script>document.location=\"viewpodetail_ready.php?data=$cekID\";</script>";
}

$idmr = $_GET['data'];
mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT p_mr_header.id, p_mr_header.nomr, p_mr_header.prodcode, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_mr_header, h_employee WHERE p_mr_header.id = '$idmr' AND p_mr_header.requestby = h_employee.id";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT id, vendorname FROM c_vendor ORDER BY vendorname ASC";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_rspayterms = "SELECT * FROM pc_termsofpay WHERE activeYN = '1'";
$rspayterms = mysql_query($query_rspayterms, $core) or die(mysql_error());
$row_rspayterms = mysql_fetch_assoc($rspayterms);
$totalRows_rspayterms = mysql_num_rows($rspayterms);

mysql_select_db($database_core, $core);
$query_rsshipmentterms = "SELECT * FROM pc_shipment_term WHERE pc_shipment_term.activeYN = '1'";
$rsshipmentterms = mysql_query($query_rsshipmentterms, $core) or die(mysql_error());
$row_rsshipmentterms = mysql_fetch_assoc($rsshipmentterms);
$totalRows_rsshipmentterms = mysql_num_rows($rsshipmentterms);

mysql_select_db($database_core, $core);
$query_rsshipmentloc = "SELECT * FROM pc_shipmentloc WHERE pc_shipmentloc.activeYN = '1'";
$rsshipmentloc = mysql_query($query_rsshipmentloc, $core) or die(mysql_error());
$row_rsshipmentloc = mysql_fetch_assoc($rsshipmentloc);
$totalRows_rsshipmentloc = mysql_num_rows($rsshipmentloc);

mysql_select_db($database_core, $core);
$query_rsorderedby = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.`initial` FROM h_employee WHERE userlevel = 'procurement'";
$rsorderedby = mysql_query($query_rsorderedby, $core) or die(mysql_error());
$row_rsorderedby = mysql_fetch_assoc($rsorderedby);
$totalRows_rsorderedby = mysql_num_rows($rsorderedby);

mysql_select_db($database_core, $core);
$query_rsfinanceby = "SELECT id, firstname, midlename, lastname, `initial`, level FROM h_employee WHERE department = 'finance' AND level='0'";
$rsfinanceby = mysql_query($query_rsfinanceby, $core) or die(mysql_error());
$row_rsfinanceby = mysql_fetch_assoc($rsfinanceby);
$totalRows_rsfinanceby = mysql_num_rows($rsfinanceby);

mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT id, firstname, midlename, lastname, `initial`, level FROM h_employee WHERE userlevel = 'branchmanager'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.`initial`, level FROM h_employee WHERE userlevel = 'procurement' AND level='0'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$year=date(y);
$month=date(m);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM c_po_header ORDER BY pono DESC LIMIT 1"));
$cekQ=$ceknomor[pono];
#menghilangkan huruf
$awalQ=substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;

if($next <10){
// pengecekan nilai increment
$nextString = "000" . $next; // jadinya J0005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J0005
//
}
else {
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J0005
//
}
$nextnopo=sprintf ('P.BPN'.'/'.$year.'/'.$month.'/'.$nextString);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry Purchase Order (PO)</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

<script type="text/javascript">
function cekInput() {
	if (document.form1.vendor.value == "") {
		alert("Please select Vendor");
		document.form1.vendor.focus();
		return false;
	} else if (document.form1.termsofpayment.value == "") {
		alert("Please select Terms of Payment");
		document.form1.termsofpayment.focus();
		return false;
	} else if (document.form1.discount.value > 100) {
		alert("Discount can't more than 100%. Contact your Purchase Coordinator");
		document.form1.discount.focus();
		return false;
	} else if (document.form1.tax.value > 100) {
		alert("Tax can't more than 100%. Contact your Purchase Coordinator");
		document.form1.tax.focus();
		return false;
	}
}
</script>

</head>

<body class="General">
<p class="buatform"><b>Entry Purchase Order (PO)</b></p>
<?php { include "../date.php"; } ?>

<form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1" >
  <table width="1050" border="0" class="General">
    <tr>
      <td width="118">Date</td>
      <td width="13">:</td>
      <td width="288"><input type="text" name="date" id="tanggal8" class="required" title="Date is required" value="<?php echo date("d M Y")?>" size="12" /></td>
      <td width="108">PO No.</td>
      <td width="13">:</td>
      <td colspan="4"><input type="text" name="pono" style="border:thin" readonly="readonly" id="pono" class="required" title="PO No is Required" value="<?php echo $nextnopo; ?>" /></td>
    </tr>
    <tr>
      <td>MR No.</td>
      <td>:</td>
      <td>
      <input name="mrno" type="text" style="border:thin" readonly="readonly" id="mrno" value="<?php echo $row_Recordset2['nomr']; ?>" />
      <input name="hfidmr" type="hidden" id="hfidmr" value="<?php echo $row_Recordset2['id']; ?>" /></td>
      <td width="108">To</td>
      <td width="13">:</td>
      <td colspan="4"><select name="vendor" id="vendor" class="required" title="Please select Vendor">
        <option value="">- Select Vendor -</option>
        <?php
		do {  
		?>
        <option value="<?php echo $row_Recordset3['id']?>"><?php echo $row_Recordset3['vendorname']?></option>
        <?php
		} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
		  $rows = mysql_num_rows($Recordset3);
		  if($rows > 0) {
			  mysql_data_seek($Recordset3, 0);
			  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
		  }
		?>
      </select></td>
    </tr>
    <tr>
      <td>Prod. Code</td>
      <td>:</td>
      <td><input name="prodcode" type="text" id="prodcode" value="<?php echo $row_Recordset2['prodcode']; ?>" size="12" /></td>
      <td>Ref</td>
      <td>:</td>
      <td colspan="4"><input type="text" name="ref" id="ref" size="40" /></td>
    </tr>
    <tr>
      <td>Request by</td>
      <td>:</td>
      <td><input name="requestby" type="text" style="border:thin" readonly="readonly" id="requestby" value="<?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?>" /> </td>
      <td>Budget Code</td>
      <td>:</td>
      <td colspan="4"><input type="text" name="budgetcode" id="budgetcode" size="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Person in Charge</td>
      <td>:</td>
      <td><select name="pc" id="pc">
        <option value="">- Select P/C -</option>
        <?php
			do {
			?>
        <option value="<?php echo $row_Recordset1['id']?>"<?php if ($row_Recordset1['level'] == '0') { ?> selected="selected" <?php } ?>><?php echo $row_Recordset1['firstname']?> <?php echo $row_Recordset1['midlename']?> <?php echo $row_Recordset1['lastname']?></option>
        <?php
			} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
			  $rows = mysql_num_rows($Recordset1);
			  if($rows > 0) {
				  mysql_data_seek($Recordset1, 0);
				  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
			  }
			?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Terms of Payment</td>
      <td>:</td>
      <td colspan="7"><select name="termsofpayment" id="termsofpayment" class="required" title="Terms of Payment is required">
        <option value="">- Select Terms of Payment -</option>
        <?php
		do {  
		?>
        <option value="<?php echo $row_rspayterms['id_pterm']?>"><?php echo $row_rspayterms['termosfpay_descr']?></option>
        <?php
		} while ($row_rspayterms = mysql_fetch_assoc($rspayterms));
		  $rows = mysql_num_rows($rspayterms);
		  if($rows > 0) {
			  mysql_data_seek($rspayterms, 0);
			  $row_rspayterms = mysql_fetch_assoc($rspayterms);
		  }
		?>
      </select></td>
    </tr>
    <tr>
      <td>Shipment Terms</td>
      <td>:</td>
      <td><select name="shippingterms" id="shippingterms" class="required" title="Shipping Term is required">
        <option value="">- Select Shipment Terms -</option>
        <?php
			do {  
			?>
        <option value="<?php echo $row_rsshipmentterms['id_sterm']?>"><?php echo $row_rsshipmentterms['shipment_term']?></option>
        <?php
			} while ($row_rsshipmentterms = mysql_fetch_assoc($rsshipmentterms));
			  $rows = mysql_num_rows($rsshipmentterms);
			  if($rows > 0) {
				  mysql_data_seek($rsshipmentterms, 0);
				  $row_rsshipmentterms = mysql_fetch_assoc($rsshipmentterms);
			  }
			?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Shipment Location</td>
      <td>:</td>
      <td colspan="7"><select name="shipmentloc" id="shipmentloc" class="required" title="Shipment Location is required">
        <option value="">- Select Shipment Location -</option>
        <?php
			do {  
			?>
        <option value="<?php echo $row_rsshipmentloc['id_sloc']?>"><?php echo $row_rsshipmentloc['shipmentloc_descr']?></option>
        <?php
			} while ($row_rsshipmentloc = mysql_fetch_assoc($rsshipmentloc));
			  $rows = mysql_num_rows($rsshipmentloc);
			  if($rows > 0) {
				  mysql_data_seek($rsshipmentloc, 0);
				  $row_rsshipmentloc = mysql_fetch_assoc($rsshipmentloc);
			  }
			?>
      </select></td>
    </tr>
    <tr>
      <td>Delivery Time</td>
      <td>:</td>
      <td><input type="text" name="deliverytime" id="tanggal9" class="required" title="Delivery Time is required" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4"><label for="disc"></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Discount</td>
      <td>:</td>
      <td width="120"><input type="text" name="discount" id="discount" size="3" value="0" style="text-align:right" /> %</td>
      <td width="20">Currency</td>
      <td width="10">:</td>
      <td><select name="cur" id="cur">
        <option value="1">Rp</option>
        <option value="2">USD</option>
      </select></td>
    </tr>
    <tr>
      <td>Ordered by</td>
      <td>:</td>
      <td><select name="orderedby" id="orderedby">
        <option value="">- Select Ordered by -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsorderedby['id']?>" <?php if ($row_rsorderedby['id'] == $_SESSION['empID']) { ?> selected="selected" <?php } ?>><?php echo $row_rsorderedby['initial']?></option>
        <?php
} while ($row_rsorderedby = mysql_fetch_assoc($rsorderedby));
  $rows = mysql_num_rows($rsorderedby);
  if($rows > 0) {
      mysql_data_seek($rsorderedby, 0);
	  $row_rsorderedby = mysql_fetch_assoc($rsorderedby);
  }
?>
      </select></td>
      <td>Tax</td>
      <td>:</td>
      <td colspan="4"><input type="text" name="tax" id="tax" size="3" value="0" style="text-align:right" /> 
        %</td>
    </tr>
    <tr>
      <td>Checked by</td>
      <td>:</td>
      <td><select name="checkedby" id="checkedby">
        <option value="">- Select Checked by -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>" <?php if ($row_Recordset1['level'] == '0') { ?> selected="selected" <?php } ?>><?php echo $row_Recordset1['initial']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
      <td>Other Payment</td>
      <td>:</td>
      <td colspan="4"><label for="other_pay"></label>
        <input type="text" name="other_pay" id="other_pay" /> 
        &nbsp; nominal &nbsp;
        <input type="text" name="value_other_pay" id="value_other_pay" /></td>
    </tr>
    <tr>
      <td>Finance Confirmed by</td>
      <td>:</td>
      <td><select name="financeby" id="financeby">
        <option value="">- Select Finance -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsfinanceby['id']?>" <?php if ($row_rsfinanceby['level'] == '0') { ?> selected="selected" <?php } ?>><?php echo $row_rsfinanceby['initial']?></option>
        <?php
} while ($row_rsfinanceby = mysql_fetch_assoc($rsfinanceby));
  $rows = mysql_num_rows($rsfinanceby);
  if($rows > 0) {
      mysql_data_seek($rsfinanceby, 0);
	  $row_rsfinanceby = mysql_fetch_assoc($rsfinanceby);
  }
?>
      </select></td>
      <td>Note</td>
      <td>:</td>
      <td colspan="4" rowspan="5" valign="top"><textarea name="note" id="note" cols="60" rows="10"></textarea></td>
    </tr>
    <tr>
      <td>Approved by</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby">
        <option value="">- Select Approved by -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsapprovedby['id']?>" <?php if ($row_rsapprovedby['id'] == '24') { ?> selected="selected" <?php } ?>><?php echo $row_rsapprovedby['initial']?></option>
        <?php
} while ($row_rsapprovedby = mysql_fetch_assoc($rsapprovedby));
  $rows = mysql_num_rows($rsapprovedby);
  if($rows > 0) {
      mysql_data_seek($rsapprovedby, 0);
	  $row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Submit" onclick="return cekInput();" /></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset2);

	mysql_free_result($Recordset2);
	mysql_free_result($Recordset3);
	mysql_free_result($Recordset1);
	mysql_free_result($rspayterms);
	mysql_free_result($rsshipmentterms);
	mysql_free_result($rsshipmentloc);
	mysql_free_result($rsorderedby);
	mysql_free_result($rsfinanceby);
	mysql_free_result($rsapprovedby);
?>
