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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE p_bpb_core SET qty=%s, bpb_unit=%s, prod_code=%s, bpb_itemnote=%s WHERE bpb_idheader=%s AND id_item=%s",
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "int"),
                       GetSQLValueString($_POST['cmbprodcode'], "text"),
                       GetSQLValueString($_POST['bpb_itemnote'], "text"),
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['id_item'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_descr = "-1";
if (isset($_GET['datas'])) {
  $colname_descr = $_GET['datas'];
}
mysql_select_db($database_core, $core);
$query_descr = sprintf("SELECT * FROM m_master WHERE id_item = %s", GetSQLValueString($colname_descr, "int"));
$descr = mysql_query($query_descr, $core) or die(mysql_error());
$row_descr = mysql_fetch_assoc($descr);

mysql_select_db($database_core, $core);
$query_rsprodcode = "SELECT a_production_code.id, a_production_code.projectcode, a_production_code.productioncode, a_production_code.projecttitle FROM a_production_code";
$rsprodcode = mysql_query($query_rsprodcode, $core) or die(mysql_error());
$row_rsprodcode = mysql_fetch_assoc($rsprodcode);
$totalRows_rsprodcode = mysql_num_rows($rsprodcode);

mysql_select_db($database_core, $core);
$query_rscmbmstat = "SELECT * FROM m_status";
$rscmbmstat = mysql_query($query_rscmbmstat, $core) or die(mysql_error());
$row_rscmbmstat = mysql_fetch_assoc($rscmbmstat);
$totalRows_rscmbmstat = mysql_num_rows($rscmbmstat);

mysql_select_db($database_core, $core);
$query_rsitemstat = "SELECT * FROM m_masterndstatus";
$rsitemstat = mysql_query($query_rsitemstat, $core) or die(mysql_error());
$row_rsitemstat = mysql_fetch_assoc($rsitemstat);
$totalRows_rsitemstat = mysql_num_rows($rsitemstat);

mysql_select_db($database_core, $core);
$query_rsunit = "SELECT id_unit, unit FROM m_unit";
$rsunit = mysql_query($query_rsunit, $core) or die(mysql_error());
$row_rsunit = mysql_fetch_assoc($rsunit);
$totalRows_rsunit = mysql_num_rows($rsunit);

mysql_select_db($database_core, $core);
$query_descr = "SELECT m_master.*, m_e_model.mtrl_model FROM m_master, m_e_model WHERE m_master.id_mmodel = m_e_model.id_mmodel";
$descr = mysql_query($query_descr, $core) or die(mysql_error());
$row_descr = mysql_fetch_assoc($descr);
$totalRows_descr = mysql_num_rows($descr);

mysql_select_db($database_core, $core);
$id_item=$row_descr['id_item'];
$query_btb = "SELECT id_item, qty, unit FROM p_btb_core WHERE id_item = '.$id_item.'";
$btb = mysql_query($query_btb, $core) or die(mysql_error());
$row_btb = mysql_fetch_assoc($btb);
$totalRows_btb = mysql_num_rows($btb);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input BPB Detail</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function cekQty() {
	 if (document.form1.qty.value == "") {
		alert("Quantity may not Empty");
		document.form1.qty.focus();
		return false;
	} else {
		var q = document.getElementById("qty").value;
		var qstock = document.getElementById("qty_stock").value;
		if (q > qstock) {
			alert ("Qty Stock = " + qstock );
			document.getElementById("qty").value = q;
			return false;
		}
	}
}
</script>
</head>

<body class="General">
<p><b>Add BPB Detail</b></p>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td width="150" align="right" nowrap="nowrap">&nbsp;</td>
      <td width="20" align="right" nowrap="nowrap">&nbsp;</td>
      <td><input type="text" name="id_header" value="<?php echo $_GET['data']; ?>" size="10" />
      <input name="id_item" type="text" id="id_item" value="<?php echo $_GET['datas']; ?>" /></td>
    </tr>
    <tr>
      <td>Prod. Code</td>
      <td align="center">:</td>
      <td><select name="cmbprodcode" id="cmbprodcode" class="General">
        <option value="">-- Prod. Code --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsprodcode['id']?>"><?php echo $row_rsprodcode['projectcode']?> - <?php echo $row_rsprodcode['productioncode']?> - <?php echo $row_rsprodcode['projecttitle']; ?></option>
        <?php
} while ($row_rsprodcode = mysql_fetch_assoc($rsprodcode));
  $rows = mysql_num_rows($rsprodcode);
  if($rows > 0) {
      mysql_data_seek($rsprodcode, 0);
	  $row_rsprodcode = mysql_fetch_assoc($rsprodcode);
  }
?>
      </select></td>
    </tr>
    
    <tr>
      <td>Qty Stock</td>
      <td align="center">:
      <?php
	mysql_select_db($database_core, $core);
$query_qty = "SELECT SUM(p_btb_core.qty) AS jml FROM p_btb_core WHERE p_btb_core.id_item = ". $_GET['datas'] . "";
$qty = mysql_query($query_qty, $core) or die(mysql_error());
$row_qty = mysql_fetch_assoc($qty);
$totalRows_qty = mysql_num_rows($qty);
	

	mysql_select_db($database_core, $core);
$query_qtyout = "SELECT SUM(p_bpb_core.qty) AS jml_out FROM p_bpb_core WHERE p_bpb_core.id_item = ". $_GET['datas'] . "";
$qtyout = mysql_query($query_qtyout, $core) or die(mysql_error());
$row_qtyout = mysql_fetch_assoc($qtyout);
$totalRows_qtyout = mysql_num_rows($qtyout);
?></td>
      <td><strong>
        <input name="qty_stock" type="text"  value="
      <?php $quantity= $row_qty['jml']-$row_qtyout['jml_out']; echo $quantity; ?>"/>
      </strong></td>
    </tr>
    <tr>
      <td>Qty</td>
      <td align="center">:      </td>
      <td><input type="text" name="qty" size="10" class="General"  value="" />
        <select name="unit" id="unit" class="General">
          <option value="">-- Unit --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rsunit['id_unit']?>"><?php echo $row_rsunit['unit']?></option>
          <?php
} while ($row_rsunit = mysql_fetch_assoc($rsunit));
  $rows = mysql_num_rows($rsunit);
  if($rows > 0) {
      mysql_data_seek($rsunit, 0);
	  $row_rsunit = mysql_fetch_assoc($rsunit);
  }
?>
      </select></td>
    </tr>
    
    <tr>
      <td>Note</td>
      <td align="center">:</td>
      <td><textarea name="bpb_itemnote" id="bpb_itemnote" cols="45" rows="2" class="General"></textarea></td>
    </tr>
    <tr class="General">
      <td class="General">Status of Item</td>
      <td align="center">:</td>
      <td><select name="cmbmstat" id="cmbmstat" disabled="disabled">
        <option value="">- Choose Status of Item -</option>
        <?php
		do {  
		?>
        <option value="<?php echo $row_rscmbmstat['id_mstat']?>"><?php echo $row_rscmbmstat['m_status']?></option>
        <?php
		} while ($row_rscmbmstat = mysql_fetch_assoc($rscmbmstat));
		  $rows = mysql_num_rows($rscmbmstat);
		  if($rows > 0) {
			  mysql_data_seek($rscmbmstat, 0);
			  $row_rscmbmstat = mysql_fetch_assoc($rscmbmstat);
		  }
		?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Add Item to BPB" onclick="return cekQty();"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsprodcode);
	mysql_free_result($rscmbmstat);

mysql_free_result($rsitemstat);

mysql_free_result($rsunit);

mysql_free_result($descr);

mysql_free_result($qty);

mysql_free_result($qtyout);

mysql_free_result($btb);
?>