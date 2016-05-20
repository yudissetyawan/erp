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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$selisih = $_POST['mrqty'] - $_POST['poqty'] - $_POST['qty'];
	$idmrcore = $_POST['itemno'];
	$dt = $_GET['data'];
	
  $insertSQL = sprintf("INSERT INTO c_po_core (poheader, itemno, qty, unit, unitprice, totalprice, popriceafterdisc, remark_pocore) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['poheader'], "text"),
                       GetSQLValueString($_POST['iditem'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "int"),
                       GetSQLValueString($_POST['unitprice'], "text"),
                       GetSQLValueString($_POST['totalprice'], "int"),
                       GetSQLValueString($_POST['subtotalafterdisc'], "double"),
                       GetSQLValueString($_POST['remark'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

	if ($selisih == 0) {
	  $updateSQL = "UPDATE p_mr_core SET po_status='0' WHERE id='$idmrcore'";
	  $Result2 = mysql_query($updateSQL, $core) or die(mysql_error());
	}

  	echo "<script>
  	alert(\"New Item has been added\");
	self.close();

    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
	</script>";
	/* echo "<script>document.location=\"viewpodetail_ready.php?data=$dt\";</script>"; */
}

$idpoheader = $_GET['data'];
mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT m_master.*, m_e_model.mtrl_model, p_mr_core.id AS id_mrcore
FROM p_mr_core
INNER JOIN m_master ON p_mr_core.itemmr = m_master.id_item
INNER JOIN m_e_model ON m_e_model.id_mmodel = m_master.id_mmodel
INNER JOIN c_po_header ON c_po_header.mrno = p_mr_core.mrheader
WHERE p_mr_core.po_status = '1' AND c_po_header.id = '$idpoheader'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//INNER JOIN c_po_core ON p_mr_core.itemmr = c_po_core.itemno
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry M/S Request Detail</title>

<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<head>

<script type="text/javascript">
function Total(){
	//var a =document.getElementById("qty1").value;
	var b =document.getElementById("qty").value;
	var c =document.getElementById("unitprice").value;
	var qmr = document.getElementById("mrqty").value;
	var d;
	d = b * c;
	document.getElementById("totalprice").value = d;
	document.getElementById("subtotalafterdisc").value = d;
	var zz = formatCurrency(d);
	document.getElementById("totalprice").innerHTML = zz;
	document.getElementById("subtotalafterdisc").innerHTML = zz;
}

function cekQty() {
	if (document.form1.itemno.value == "") {
		alert("Please select item");
		document.form1.itemno.focus();
		return false;
	} else if (document.form1.totalprice.value == "") {
		alert("Total Price may not Empty, click on Qty, then press Down cross");
		document.form1.totalprice.focus();
		return false;
	} else {
		var q = document.getElementById("qty").value;
		var qmr = document.getElementById("mrqty").value;
		var qpo = document.getElementById("poqty").value;
		var sisa = qmr - qpo
		if (q > sisa) {
			alert ("Qty MR = " + sisa + "\nQty PO is not allowed more than Qty MR. You must revise MR.");
			document.getElementById("qty").value = sisa;
			return false;
		}
	}
}

function showData(str) {
	//alert (str);
	if (str=="") {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status == 200) {
			document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
			document.getElementById("qty").focus();
		}
	}
	xmlhttp.open("GET", "getPrice_podetail.php?q=" + str, true);
	xmlhttp.send();
}
</script>

</head>

<body class="General">

<?php { include "../date.php"; }
    // requires the class
    require "../menu_assets/class.datepicker.php";
    
    // instantiate the object
    $db=new datepicker();
    
    // uncomment the next line to have the calendar show up in german
    //$db->language = "dutch";
    
    $db->firstDayOfWeek = 1;

    // set the format in which the date to be returned
    $db->dateFormat = "Y-m-d";
?>

<p class="buatform"><b>Add Item to Purchase Order (PO)</b></p>

<form action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="650" border="0" class="General">
    <tr>
      <td width="160" class="General">Name of Item [ Description ]</td>
      <td width="10">:</td>
      <td><select name="itemno" id="itemno" onchange="showData(this.value)">
        <option value="">-- Name of Item --</option>
        <?php
		do {  
		?>
        <option value="<?php echo $row_Recordset1['id_mrcore']; ?>"><?php echo $row_Recordset1['item_code']; ?> <?php echo $row_Recordset1['mtrl_model']; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></option>
        <?php
        } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
          $rows = mysql_num_rows($Recordset1);
          if($rows > 0) {
              mysql_data_seek($Recordset1, 0);
              $row_Recordset1 = mysql_fetch_assoc($Recordset1);
          }
		?>
      </select></td>
    </tr>
  </table>
    
<div id="txtHint">    
    <table width="650" border="0" class="General">
    <tr>
      <td width="160">Price per Unit</td>
      <td width="10">:</td>
      <td colspan="2">
        <span id="sprytextfield2">
        	<input type="text" name="unitprice" id="unitprice" class="required" title="Unit Price is required" onKeyUp="Total()" disabled="disabled" />
        </span>
      </td>
    </tr>    
    <tr>
      <td>Qty</td>
      <td>:</td>
      <td>
        <span id="sprytextfield1">
            <input type="text" name="qty" id="qty" size="5" class="required" title="Qty is required" onKeyUp="Total()" disabled="disabled" />
        </span>
      </td>  
    </tr>
    </table>
</div>
    
    <table width="650" border="0" class="General">
    <tr>
      <td width="160" class="General">Subtotal Price </td>
      <td width="10">:</td>
      <td><input type="text" name="totalprice" id="totalprice" size="20" readonly="readonly" style="border:thin; text-align:right"/></td>
    </tr>
    <tr>
      <td class="General">Subtotal After Discount</td>
      <td>:</td>
      <td><input type="text" name="subtotalafterdisc" id="subtotalafterdisc" style="text-align:right" /></td>
    </tr>
    
    <tr>
      <td class="General">Remark</td>
      <td>:</td>
      <td><textarea name="remark" id="remark" cols="50" rows="4" class="required" title="Remark is required"></textarea></td>
    </tr>
    
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="General">&nbsp;</td>
      <td class="General">
      <input name="poheader" type="hidden" id="poheader" value="<?php echo $_GET['data']; ?>" />
      <input type="submit" name="submit" id="submit" value="Add" onclick="return cekQty();" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
	var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
	var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>

</html>
<?php
	mysql_free_result($Recordset1);
?>