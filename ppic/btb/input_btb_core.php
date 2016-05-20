<?php require_once('../../Connections/core.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO p_btb_core (id_header, id_item, qty, unit) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_header'], "int"),
                       GetSQLValueString($_POST['iditem'], "int"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_btb_core.php?data=" . $_GET ['data'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$idbtb = $_GET['data'];
mysql_select_db($database_core, $core);
$query_descr = "SELECT m_master.*, m_e_model.mtrl_model, c_po_core.id AS id_pocore
FROM c_po_core
INNER JOIN m_master ON c_po_core.itemno = m_master.id_item
INNER JOIN m_e_model ON m_e_model.id_mmodel = m_master.id_mmodel
INNER JOIN p_btb_header ON p_btb_header.id_po = c_po_core.poheader
WHERE c_po_core.btb_status = '1' AND p_btb_header.id = '$idbtb'";
$descr = mysql_query($query_descr, $core) or die(mysql_error());
$row_descr = mysql_fetch_assoc($descr);
$totalRows_descr = mysql_num_rows($descr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

<script type="text/javascript">
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
	xmlhttp.open("GET", "getUnit_btbdetail.php?q=" + str, true);
	xmlhttp.send();
}

function cekItem() {
	if (document.form1.id_item.value == "") {
		alert("Please select item");
		document.form1.id_item.focus();
		return false;
	} else {
		var q = document.getElementById("qty").value;
		var qpo = document.getElementById("poqty").value;
		var qbtb = document.getElementById("btbqty").value;
		var sisa = qpo - qbtb
		if (q > sisa) {
			alert ("Qty PO = " + sisa + "\nQty BTB is can't more than Qty PO");
			document.getElementById("qty").value = sisa;
			return false;
		}
	}
}
</script>

</head>

<body>
<h2>Add Item to BTB</h2>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="700">
    <tr>
      <td width="180">Code and Name of Item
        <input type="hidden" name="id_header" value="<?php echo $_GET['data']; ?>" size="10" /></td>
      <td width="10">:</td>
      <td>
      	<select name="id_item" id="id_item" onchange="showData(this.value)">
        <option value="">-- Select Item --</option>
        <?php
		do {  
		?>
        	<option value="<?php echo $row_descr['id_pocore']?>"><?php echo $row_descr['item_code']; ?> - <?php echo $row_descr[mtrl_model]; ?> (<?php echo $row_descr['descr_name']; ?>) <?php echo $row_descr['id_type']; ?> <?php echo $row_descr['brand']; ?></option>
        <?php
		} while ($row_descr = mysql_fetch_assoc($descr));
		  $rows = mysql_num_rows($descr);
		  if($rows > 0) {
			  mysql_data_seek($descr, 0);
			  $row_descr = mysql_fetch_assoc($descr);
		  }
		?>
      </select>
      </td>
    </tr>
    </table>
 
 <div id="txtHint">
    <table width="700">
    <tr>
      <td width="180">Qty</td>
      <td width="10">:</td>
      <td>
      	<input type="text" name="qty" value="" size="5" disabled="disabled" />
      </td>
    </tr>
    </table>
</div>
  
  <table width="700">  
    <tr>
      <td width="180">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td>&nbsp;</td>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td><input type="submit" value="Add to BTB" onclick="return cekItem();" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($descr);
?>