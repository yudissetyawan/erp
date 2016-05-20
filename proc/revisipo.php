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
  $insertSQL = sprintf("INSERT INTO c_po_header (pono, podate, vendor, mrno, revisi, termsofpayment, deliverytime, pc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['pono'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['mrno'], "text"),
                       GetSQLValueString($_POST['revisi'], "text"),
                       GetSQLValueString($_POST['termsofpayment'], "text"),
                       GetSQLValueString($_POST['deliverytime'], "text"),
                       GetSQLValueString($_POST['pc'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE c_po_header SET activeornot=%s WHERE id=%s",
                       GetSQLValueString($_POST['activeornot'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c_po_header.id, c_po_header.mrno, c_po_header.podate, c_po_header.revisi, c_po_header.termsofpayment, c_po_header.termsshipping, c_po_header.deliverytime, c_po_header.vendor, c_po_header.pono, p_mr_header.id AS mrheaderid, p_mr_header.nomr, c_vendor.id AS vendorid, c_vendor.vendorname, c_po_header.pc, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.nik, h_employee.id AS idemp FROM c_po_header LEFT JOIN p_mr_header ON  c_po_header.mrno=p_mr_header.id LEFT JOIN c_vendor ON  c_po_header.vendor= c_vendor.id LEFT JOIN h_employee ON c_po_header.pc=h_employee.id AND h_employee.userlevel='procurement' WHERE c_po_header.id = %s ", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $totalRows_Recordset1 = $_GET['data'];
}
$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c_po_header.id, c_po_header.mrno, c_po_header.podate, c_po_header.revisi, c_po_header.termsofpayment, c_po_header.termsshipping, c_po_header.deliverytime, c_po_header.vendor, c_po_header.pono, p_mr_header.id AS mrheaderid, p_mr_header.nomr, c_vendor.id AS vendorid, c_vendor.vendorname, c_po_header.pc, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.nik, h_employee.id AS idemp FROM c_po_header LEFT JOIN p_mr_header ON  c_po_header.mrno=p_mr_header.id LEFT JOIN c_vendor ON  c_po_header.vendor= c_vendor.id LEFT JOIN h_employee ON c_po_header.pc=h_employee.id AND h_employee.userlevel='procurement' WHERE c_po_header.pono = %s ", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT id, vendorname FROM c_vendor ORDER BY vendorname ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT id, nomr FROM p_mr_header ORDER BY id DESC";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT * FROM h_employee WHERE userlevel = 'procurement'";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$ceknomor=mysql_fetch_array(mysql_query("SELECT id, pono, revisi FROM c_po_header ORDER BY revisi DESC LIMIT 1"));
$cekQ=$ceknomor[revisi];
$cekQid=$ceknomor[id];
$next=$cekQ+1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Revise Purchase Order (PO)</title>
<style type="text/css">
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.datatables.js"></script>
<script type="text/javascript" src="/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="/js/jquery.blockui.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var table = $("#celebs");
	var oTable = table.dataTable({"sPaginationType": "full_numbers", "bStateSave": true});

	$(".editable", oTable.fnGetNodes()).editable("php/ajax.php?r=edit_celeb", {
		"callback": function(sValue, y) {
			var fetch = sValue.split(",");
			var aPos = oTable.fnGetPosition(this);
			oTable.fnUpdate(fetch[1], aPos[0], aPos[1]);
		},
		"submitdata": function(value, settings) {
			return {
				"row_id": this.parentNode.getAttribute("id"),
				"column": oTable.fnGetPosition(this)[2]
			};
		},
		"height": "14px"
	});

	$(document).on("click", ".delete", function() {
		var celeb_id = $(this).attr("id").replace("delete-", "");
		var parent = $("#"+celeb_id);
		$.ajax({
			type: "get",
			url: "php/ajax.php?r=delete_celeb&id="+celeb_id,
			data: "",
			beforeSend: function() {
				table.block({
					message: "",
					css: {
						border: "none",
						backgroundColor: "none"
					},
					overlayCSS: {
						backgroundColor: "#fff",
						opacity: "0.5",
						cursor: "wait"
					}
				});
			},
			success: function(response) {
				table.unblock();
				var get = response.split(",");
				if(get[0] == "success") {
					$(parent).fadeOut(200,function() {
						$(parent).remove();
					});
				}
			}
		});
	});
});
</script>


<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body class="General">

<p class="buatform"><b>Revise Purchase Order (PO)</b></p>
<?php { include "../date.php"; include "../dateformat_funct.php"; } ?>

<form action="<?php echo $editFormAction; ?>" method="POST" id="form1" name="form1" style="clear:right">
  <table width="503" border="0">
    <tr>
      <td>Revisi Ke 
      <input type="hidden" name="id" id="id" value="<?php echo $cekQid; ?>" /></td>
      <td>:</td>
      <td><input size="10" type="text" name="revisi" id="revisi" value="<?php echo $next; ?>" /> </td>
    </tr>
    <tr>
      <td>To</td>
      <td>:</td>
      <td><select name="vendor" id="vendor" class="required" title="Please select Vendor">
        <option value="<?php echo $row_Recordset1['vendorid']; ?>"><?php echo $row_Recordset1['vendorname']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['vendorname']?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select> <label for="revisi"></label>      <label for="id"></label></td>
    </tr>
    <tr>
      <td>PO No</td>
      <td>:</td>
      <td><label for="pono"></label>
        <input name="pono" type="text" class="required" id="pono" title="PO No is Required" value="<?php echo $row_Recordset1['pono']; ?>" style="border:thin" readonly="readonly" /></td>
    </tr>
    <tr>
      <td width="140">MR No</td>
      <td width="13">:</td>
      <td width="460"><select name="mrno" id="mrno" class="required" title="Please select MR No">
        <option value="<?php echo $row_Recordset1['mrheaderid']; ?>"><?php echo $row_Recordset1['nomr']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset3['id']?>"><?php echo $row_Recordset3['nomr']?></option>
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
      <td>Date</td>
      <td>:</td>
      <td><input name="date" type="text" class="required" id="tanggal1" title="Date is required" value="<?php echo $row_Recordset1['podate']; ?>" /></td>
    </tr>
    <tr>
      <td>P / C</td>
      <td>:</td>
      <td><select name="pc" id="pc">
        <option value="<?php echo $row_Recordset1['idemp']?>">(<?php echo $row_Recordset1['nik']; ?>) <?php echo $row_Recordset1['firstname']?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset4['id']?>">(<?php echo $row_Recordset4['nik']; ?>) <?php echo $row_Recordset4['firstname']?> <?php echo $row_Recordset4['midlename']; ?> <?php echo $row_Recordset4['lastname']; ?></option>
        <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
      </select></td>
    </tr>
    <!--<tr>
      <td>Revisi</td>
      <td>:</td>
      <td><input name="revisi" type="text" class="required" id="revisi" title="Revisi is required" value="<?php echo $row_Recordset1['revisi']; ?>"/></td>
    </tr>-->
    <tr>
      <td>Terms of Payment</td>
      <td>:</td>
      <td><input name="termsofpayment" type="text" class="required" id="termsofpayment" title="Term of Payment is required" value="<?php echo $row_Recordset1['termsofpayment']; ?>" /></td>
    </tr>
    <tr>
      <td>Shipping Terms</td>
      <td>:</td>
      <td><input name="shippingterms" type="text" class="required" id="shippingterms" title="Shipping Term is required" value="<?php echo $row_Recordset1['termsshipping']; ?>" /></td>
    </tr>
    <tr>
      <td>Delivery Time</td>
      <td>:</td>
      <td><label for="deliverytime2"></label>
        <input name="deliverytime" type="text" class="required" id="tanggal2" title="Delivery Time is required" value="<?php echo $row_Recordset1['deliverytime']; ?>" /></td>
    </tr>
    <tr>
      <td>Status Revisi</td>
      <td>:</td>
      <td><label for="activeornot">
        <input type="checkbox" name="activeornot" id="activeornot" value="0" />
      </label>
      <label for="tanggal_update"></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php {include "po_revisi.php";} ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
