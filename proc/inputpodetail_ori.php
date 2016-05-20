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
  $insertSQL = sprintf("INSERT INTO c_po_core (poheader, itemno, `desc`, qty, unit, unitprice, totalprice) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['poheader'], "text"),
                       GetSQLValueString($_POST['itemno'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "int"),
                       GetSQLValueString($_POST['unitprice'], "text"),
                       GetSQLValueString($_POST['totalprice'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}


$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM c_po_header WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['datas'])) {
  $colname_Recordset2 = $_GET['datas'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT c_material.id,c_material.materialname FROM p_mr_core, c_material WHERE p_mr_core.mrheader = %s AND c_material.id = p_mr_core.itemmr", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM c_unit ORDER BY id ASC";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form1").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<script type="text/javascript">
function Total(){
					//var a =document.getElementById("qty1").value;
					var b =document.getElementById("qty").value;
					var c =document.getElementById("unitprice").value;
					var d;
					d = b * c;
					document.getElementById("totalprice").value = d;
					var zz = formatCurrency(d);
					document.getElementById("totalprice").innerHTML = zz;
				}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
						
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body class="General">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="802" border="0">
    <tr>
      <td width="112">Item Name</td>
      <td width="31">&nbsp;</td>
      <td colspan="2"><label for="itemno2"></label>
        <select name="itemno" id="itemno2">
          <option value="">-- Item Name --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['materialname']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td>Description</td>
      <td>&nbsp;</td>
      <td colspan="2"><label for="description"></label>
        <textarea name="description" id="description" cols="45" rows="5" class="required" title="Description is required"></textarea></td>
    </tr>
    <tr>
      <td>QTY</td>
      <td>&nbsp;</td>
      <td width="286"><label for="qty"></label>
        <input type="text" name="qty" id="qty" class="required" title="Qty is required" onKeyUp="Total()" />
        <label for="unit"></label>
        <select name="unit" id="unit" class="required" title="Please select unit">
          <option value="">-- Unit --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['id']?>"><?php echo $row_Recordset3['unit']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select></td>
      <td width="355"><a href="#" onClick="MM_openBrWindow('../ppic/inputunit.php','','toolbar=yes,width=600,height=400')">Add Unit</a></td>
    </tr>
    <tr>
      <td>Price per Unit</td>
      <td>&nbsp;</td>
      <td colspan="2"><label for="unitprice"></label>
        <input type="text" name="unitprice" id="unitprice" class="required" title="Unit Price is required" onKeyUp="Total()" />
        <input type="text" name="totalprice" id="totalprice" size="20"><div id="totalprice"></div></td>
    </tr>
    <tr>
      <td><input name="poheader" type="hidden" id="poheader" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      <td></td>
      <td colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
