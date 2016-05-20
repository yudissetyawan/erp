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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		include "../dateformat_funct.php";
  $updateSQL = sprintf("UPDATE c_po_header SET pono=%s, podate=%s, budgetcode=%s, vendor=%s, `ref`=%s, mrno=%s, revisi=%s, termsofpayment=%s, termsshipping=%s, shipmentloc=%s, deliverytime=%s, pc=%s, note=%s, orderedby=%s, checkedby=%s, financeby=%s, approvedby=%s, discount=%s, tax=%s, cur=%s, other_pay=%s, value_other_pay=%s WHERE id=%s",
                       GetSQLValueString($_POST['pono'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "date"),
                       GetSQLValueString($_POST['budgetcode'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['ref'], "text"),
                       GetSQLValueString($_POST['mrno'], "text"),
                       GetSQLValueString($_POST['revisi'], "text"),
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
                       GetSQLValueString($_POST['value_other_pay'], "int"),
                       GetSQLValueString($_POST['idpo'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "viewpoheader.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsdatapo = "-1";
if (isset($_GET['data'])) {
  $colname_rsdatapo = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsdatapo = sprintf("SELECT c_po_header.*, p_mr_header.id AS mrheaderid, p_mr_header.nomr, c_vendor.id AS vendorid, c_vendor.vendorname, c_po_header.pc, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.nik, h_employee.id AS idemp FROM c_po_header LEFT JOIN p_mr_header ON  c_po_header.mrno=p_mr_header.id LEFT JOIN c_vendor ON  c_po_header.vendor= c_vendor.id LEFT JOIN h_employee ON c_po_header.pc=h_employee.id AND h_employee.userlevel='procurement' WHERE c_po_header.id = %s ", GetSQLValueString($colname_rsdatapo, "int"));
$rsdatapo = mysql_query($query_rsdatapo, $core) or die(mysql_error());
$row_rsdatapo = mysql_fetch_assoc($rsdatapo);
$totalRows_rsdatapo = mysql_num_rows($rsdatapo);

mysql_select_db($database_core, $core);
$query_rsvendor = "SELECT id, vendorname FROM c_vendor ORDER BY vendorname ASC";
$rsvendor = mysql_query($query_rsvendor, $core) or die(mysql_error());
$row_rsvendor = mysql_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysql_num_rows($rsvendor);

mysql_select_db($database_core, $core);
$query_rsmrheader = "SELECT id, nomr FROM p_mr_header ORDER BY id DESC";
$rsmrheader = mysql_query($query_rsmrheader, $core) or die(mysql_error());
$row_rsmrheader = mysql_fetch_assoc($rsmrheader);
$totalRows_rsmrheader = mysql_num_rows($rsmrheader);

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
$query_rsfinanceby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'finance'";
$rsfinanceby = mysql_query($query_rsfinanceby, $core) or die(mysql_error());
$row_rsfinanceby = mysql_fetch_assoc($rsfinanceby);
$totalRows_rsfinanceby = mysql_num_rows($rsfinanceby);

mysql_select_db($database_core, $core);
$query_rsapprovedby = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE userlevel = 'branchmanager'";
$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_employee WHERE userlevel = 'procurement' AND level='0'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rsorderedby = "SELECT * FROM h_employee WHERE userlevel = 'procurement'";
$rsorderedby = mysql_query($query_rsorderedby, $core) or die(mysql_error());
$row_rsorderedby = mysql_fetch_assoc($rsorderedby);
$totalRows_rsorderedby = mysql_num_rows($rsorderedby);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Purchase Order (PO)</title>
<style type="text/css">
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p class="buatform"><b>Edit Purchase Order (PO)</b></p>
<?php { include "../date.php"; include "../dateformat_funct.php"; } ?>

<form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1" >
  <table width="1000" border="0">
    <tr>
      <td width="110">Date</td>
      <td width="10">:</td>
      <td width="330"><input name="date" type="text" class="required" id="tanggal8" title="Date is required" value="<?php echo functddmmmyyyy($row_rsdatapo['podate']); ?>" /></td>
      <td width="100">To</td>
      <td width="10">:</td>
      <td colspan="4">
      <select name="vendor" id="vendor" class="required" title="Please select Vendor">
        <?php
		do {  
		?>
        <option value="<?php echo $row_rsvendor['id']?>" <?php if ($row_rsvendor['id'] == $row_rsdatapo['vendor']) { ?> selected="selected" <?php } ?>><?php echo $row_rsvendor['vendorname']?></option>
        <?php
		} while ($row_rsvendor = mysql_fetch_assoc($rsvendor));
		  $rows = mysql_num_rows($rsvendor);
		  if($rows > 0) {
			  mysql_data_seek($rsvendor, 0);
			  $row_rsvendor = mysql_fetch_assoc($rsvendor);
		  }
		?>
      </select>
      </td>
    </tr>
    <tr>
      <td>PO No.</td>
      <td>:</td>
      <td><label for="pono"></label>
        <input name="pono" type="text" class="required" id="pono" title="PO No is Required" value="<?php echo $row_rsdatapo['pono']; ?>" style="border:thin" readonly="readonly" />
        <input type="hidden" name="idpo" value="<?php echo $_GET['data'] ?>" /></td>
      <td>Ref</td>
      <td>:</td>
      <td colspan="4"><input type="text" name="ref" id="ref" value="<?php echo $row_rsdatapo['ref']; ?>" /></td>
    </tr>
    <tr>
      <td>MR No.</td>
      <td>:</td>
      <td><select name="mrno" id="mrno" class="required" title="Please select MR No">
        <?php
		do {  
		?>
        <option value="<?php echo $row_rsmrheader['id']?>" <?php if ($row_rsmrheader['id'] == $row_rsdatapo['mrno']) { ?> selected="selected" <?php } ?>><?php echo $row_rsmrheader['nomr']?></option>
        <?php
		} while ($row_rsmrheader = mysql_fetch_assoc($rsmrheader));
		  $rows = mysql_num_rows($rsmrheader);
		  if($rows > 0) {
			  mysql_data_seek($rsmrheader, 0);
			  $row_rsmrheader = mysql_fetch_assoc($rsmrheader);
		  }
		?>
      </select></td>
      <td>Budget Code</td>
      <td>:</td>
      <td colspan="4"><input type="text" name="budgetcode" id="budgetcode" value="<?php echo $row_rsdatapo['budgetcode']; ?>" /></td>
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
        <option value="">- Select P/ C -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id']?>" <?php if ($row_Recordset1['id'] == $row_rsdatapo['pc']) { ?> selected="selected" <?php } ?>><?php echo $row_Recordset1['firstname']?> <?php echo $row_Recordset1['midlename']?> <?php echo $row_Recordset1['lastname']?></option>
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
    <!--<tr>
      <td>Revisi</td>
      <td>:</td>
      <td><input name="revisi" type="text" class="required" id="revisi" title="Revisi is required" value="<?php echo $row_rsdatapo['revisi']; ?>"/></td>
    </tr>-->
    <tr>
      <td>Terms of Payment</td>
      <td>:</td>
      <td colspan="7"><select name="termsofpayment" id="termsofpayment" class="required" title="Terms of Payment is required">
        <option value="">- Select Terms of Payment -</option>
        <?php
		do {  
		?>
        <option value="<?php echo $row_rspayterms['id_pterm']?>" <?php if ($row_rspayterms['id_pterm'] == $row_rsdatapo['termsofpayment']) { ?> selected="selected" <?php } ?>><?php echo $row_rspayterms['termosfpay_descr']?></option>
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
      <td>Shipping Terms</td>
      <td>:</td>
      <td><select name="shippingterms" id="shippingterms" class="required" title="Shipping Term is required">
          <option value="">- Select Shipment Terms -</option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsshipmentterms['id_sterm']?>" <?php if ($row_rsshipmentterms['id_sterm'] == $row_rsdatapo['termsshipping']) { ?> selected="selected" <?php } ?>><?php echo $row_rsshipmentterms['shipment_term']?></option>
          <?php
			} while ($row_rsshipmentterms = mysql_fetch_assoc($rsshipmentterms));
			  $rows = mysql_num_rows($rsshipmentterms);
			  if($rows > 0) {
				  mysql_data_seek($rsshipmentterms, 0);
				  $row_rsshipmentterms = mysql_fetch_assoc($rsshipmentterms);
			  }
			?>
      </select>
      </td>
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
        <option value="<?php echo $row_rsshipmentloc['id_sloc']?>" <?php if ($row_rsshipmentloc['id_sloc'] == $row_rsdatapo['shipmentloc']) { ?> selected="selected" <?php } ?>><?php echo $row_rsshipmentloc['shipmentloc_descr']?></option>
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
      <td>
        <input name="deliverytime" type="text" class="required" id="tanggal9" title="Delivery Time is required" value="<?php echo $row_rsdatapo['deliverytime']; ?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="4" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="General">Discount</td>
      <td class="General">:</td>
      <td class="General"><input name="discount" type="text" id="discount" style="text-align:right" value="<?php echo $row_rsdatapo['discount']; ?>" size="3" />
        %</td>
      <td class="General">Currency</td>
      <td class="General">:</td>
      <td class="General">
          <select name="cur" id="cur">
            <option value="1">Rp</option>
            <option value="2">USD</option>
          </select>
      </td>
    </tr>
    <tr>
      <td>Ordered by</td>
      <td>:</td>
      <td><select name="orderedby" id="orderedby">
        <option value="">- Select Ordered by -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsorderedby['id']?>" <?php if ($row_rsorderedby['id'] == $row_rsdatapo['orderedby']) { ?> selected="selected" <?php } ?>><?php echo $row_rsorderedby['firstname']?> <?php echo $row_rsorderedby['midlename']?> <?php echo $row_rsorderedby['lasstname']?></option>
        <?php
} while ($row_rsorderedby = mysql_fetch_assoc($rsorderedby));
  $rows = mysql_num_rows($rsorderedby);
  if($rows > 0) {
      mysql_data_seek($rsorderedby, 0);
	  $row_rsorderedby = mysql_fetch_assoc($rsorderedby);
  }
?>
      </select></td>
      <td class="General">Tax</td>
      <td class="General">:</td>
      <td colspan="4" class="General"><input name="tax" type="text" id="tax" style="text-align:right" value="<?php echo $row_rsdatapo['tax']; ?>" size="3" />
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
        <option value="<?php echo $row_Recordset1['id']?>" <?php if ($row_Recordset1['id'] == $row_rsdatapo['checkedby']) { ?> selected="selected" <?php } ?>><?php echo $row_Recordset1['firstname']?> <?php echo $row_Recordset1['midlename']?> <?php echo $row_Recordset1['lastname']?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
      <td class="General">Other Payment</td>
      <td class="General">:</td>
      <td colspan="4" class="General"><label for="other_pay"></label>
        <input name="other_pay" type="text" id="other_pay" value="<?php echo $row_rsdatapo['other_pay']; ?>" />
  &nbsp; nominal &nbsp;
  <input name="value_other_pay" type="text" id="value_other_pay" value="<?php echo $row_rsdatapo['value_other_pay']; ?>" /></td>
    </tr>
    <tr>
      <td>Finance Confirmed by</td>
      <td>:</td>
      <td><select name="financeby" id="financeby">
        <option value="">- Select Finance -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsfinanceby['id']?>" <?php if ($row_rsfinanceby['id'] == $row_rsdatapo['financeby']) { ?> selected="selected" <?php } ?>><?php echo $row_rsfinanceby['firstname']?> <?php echo $row_rsfinanceby['midlename']?> <?php echo $row_rsfinanceby['lastname']?></option>
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
      <td colspan="4" rowspan="5" valign="top"><textarea name="note" id="note" cols="60" rows="10"><?php echo $row_rsdatapo['note']; ?></textarea></td>
    </tr>
    <tr>
      <td>Approved by</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby">
        <option value="">- Select Approved by -</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsapprovedby['id']?>" <?php if ($row_rsapprovedby['id'] == $row_rsdatapo['approvedby']) { ?> selected="selected" <?php } ?>><?php echo $row_rsapprovedby['firstname']?> <?php echo $row_rsapprovedby['midlename']?> <?php echo $row_rsapprovedby['lastname']?></option>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Update" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rsdatapo);

mysql_free_result($rsvendor);

mysql_free_result($rsmrheader);

mysql_free_result($rsorderedby);

mysql_free_result($rspayterms);

mysql_free_result($rsshipmentterms);

mysql_free_result($rsshipmentloc);

mysql_free_result($rsfinanceby);

mysql_free_result($rsapprovedby);

mysql_free_result($Recordset1);
?>
