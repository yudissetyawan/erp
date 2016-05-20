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

$colname_p_btb_header = "-1";
if (isset($_GET['data'])) {
  $colname_p_btb_header = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_p_btb_header = sprintf("SELECT p_btb_header.*, c_vendor.vendorname, c_po_header.pono, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_btb_header, c_po_header, c_vendor, h_employee WHERE p_btb_header.id_po = %s AND c_po_header.vendor = c_vendor.id AND c_po_header.id = p_btb_header.id_po AND h_employee.id = p_btb_header.diserahkan_by", GetSQLValueString($colname_p_btb_header, "int"));
$p_btb_header = mysql_query($query_p_btb_header, $core) or die(mysql_error());
$row_p_btb_header = mysql_fetch_assoc($p_btb_header);
$totalRows_p_btb_header = mysql_num_rows($p_btb_header);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receiving Goods (BTB) per PO</title>

<link href="../../css/table.css" rel="stylesheet" type="text/css">
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery.datatables.js"></script>
<script type="text/javascript" src="../../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../../js/jquery.blockui.js"></script>
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

</head>

<body>
<h3>Receiving Goods (BTB) per PO No.</h3>
<table width="900" border="0" class="table" id="celebs">
 <thead>
  <tr class="tabel_header" height="40">
    <td width="20">No</td>
    <td width="100">BTB No.</td>
    <td>Supplier</td>
    <td width="100">PO No.</td>
    <td width="70">BTB Date</td>
    <td width="90">Submitted by</td>
    <td width="90">Received by</td>
    <td width="90">Checked by</td>
    <td width="90">Accounting</td>
    <td width="40">&nbsp;</td>
  </tr>
 </thead>
 <tbody>
  <?php do { 
	require_once "../../dateformat_funct.php";
	
	$terima = $row_p_btb_header['diterima_by'];
	mysql_select_db($database_core, $core);
	$query_diterima_by = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.id = '$terima'";
	$diterima_by = mysql_query($query_diterima_by, $core) or die(mysql_error());
	$row_diterima_by = mysql_fetch_assoc($diterima_by);
	$totalRows_diterima_by = mysql_num_rows($diterima_by);
	
	$periksa = $row_p_btb_header['diperiksa_by'];
	mysql_select_db($database_core, $core);
	$query_diperiksa_by = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.id = '$periksa'";
	$diperiksa_by = mysql_query($query_diperiksa_by, $core) or die(mysql_error());
	$row_diperiksa_by = mysql_fetch_assoc($diperiksa_by);
	$totalRows_diperiksa_by = mysql_num_rows($diperiksa_by);
	
	$keuangan = $row_p_btb_header['accounting'];
	mysql_select_db($database_core, $core);
	$query_accounting = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE h_employee.id = '$keuangan'";
	$accounting = mysql_query($query_accounting, $core) or die(mysql_error());
	$row_accounting = mysql_fetch_assoc($accounting);
	$totalRows_accounting = mysql_num_rows($accounting);
  ?>
  
    <tr class="tabel_body">
      <td align="center"><?php $a = $a + 1; echo $a; ?></td>
      <td align="center"><a href="view_btb_core.php?data=<?php echo $row_p_btb_header['id']; ?>" title="Click to view detail BTB"><?php echo $row_p_btb_header['no_btb']; ?></a></td>
      <td><?php echo $row_p_btb_header['vendorname']; ?></td>
      <td align="center"><?php echo $row_p_btb_header['pono']; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_p_btb_header['tanggal']); ?></td>
      <td align="center"><?php echo $row_p_btb_header['firstname']; ?> <?php echo $row_p_btb_header['midlename']; ?> <?php echo $row_p_btb_header['lastname']; ?></td>
      <td align="center"><?php echo $row_diterima_by['firstname']; ?> <?php echo $row_diterima_by['midlename']; ?> <?php echo $row_diterima_by['lastname']; ?></td>
      <td align="center"><?php echo $row_diperiksa_by['firstname']; ?> <?php echo $row_diperiksa_by['midlename']; ?> <?php echo $row_diperiksa_by['lastname']; ?></td>
      <td align="center"><?php echo $row_accounting['firstname']; ?> <?php echo $row_accounting['midlename']; ?> <?php echo $row_accounting['lastname']; ?></td>
      <td align="center"><a href="#">Edit</a></td>
    </tr>
    <?php } while ($row_p_btb_header = mysql_fetch_assoc($p_btb_header)); ?>
 </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($p_btb_header);
	mysql_free_result($diterima_by);
	mysql_free_result($diperiksa_by);
	mysql_free_result($accounting);
?>