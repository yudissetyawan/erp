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

if (isset($_GET['data'])) {
	$colname_rsdatapo = "-1";
	if (isset($_GET['data'])) {
	  $colname_rsdatapo = $_GET['data'];
	}
	mysql_select_db($database_core, $core);
	$query_rsdatapo = sprintf("SELECT c_po_header.id, c_po_header.pono, c_po_header.podate, c_po_header.deliverytime, c_po_header.revisi, p_mr_header.nomr, c_vendor.vendorname FROM c_po_header, p_mr_header, c_vendor WHERE p_mr_header.id = c_po_header.mrno AND c_po_header.vendor=c_vendor.id AND p_mr_header.id = %s", GetSQLValueString($colname_rsdatapo, "int"));
	$rsdatapo = mysql_query($query_rsdatapo, $core) or die(mysql_error());
	$row_rsdatapo = mysql_fetch_assoc($rsdatapo);
	$totalRows_rsdatapo = mysql_num_rows($rsdatapo);
	$theader = "Purchase Order (PO) per MR No.";
}
else {
	mysql_select_db($database_core, $core);
	$query_rsdatapo = "SELECT c_po_header.id, c_po_header.pono, c_po_header.podate, c_po_header.deliverytime, c_po_header.revisi, p_mr_header.nomr, c_vendor.vendorname FROM c_po_header, p_mr_header, c_vendor WHERE p_mr_header.id = c_po_header.mrno AND c_po_header.vendor=c_vendor.id";
	$rsdatapo = mysql_query($query_rsdatapo, $core) or die(mysql_error());
	$row_rsdatapo = mysql_fetch_assoc($rsdatapo);
	$totalRows_rsdatapo = mysql_num_rows($rsdatapo);
	$theader = "Purchase Order (PO)";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<title>List of PO</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php { include "../dateformat_funct.php"; }
	/* if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		?><p><a href="inputpo.php?data=<?php echo $_GET['data']; ?>">+ Create Purchase Order</a></p>
	<?php } */ ?>
<h3><?php echo $theader; ?></h3>
<table width="876" border="0" class="table" id="celebs">
  <thead>
  <tr class="tabel_header">
    <td height="30" width="19" align="center" class="tabel_header">No.</td>
    <td width="116" class="tabel_header">PO No.</td>
    <td width="61" class="tabel_header">Revision</td>
    <td width="116" class="tabel_header">MR No.</td>
    <td width="103" class="tabel_header">PO Date</td>
    <td width="181" class="tabel_header">Vendor</td>
    <td width="127" class="tabel_header">Delivery Time</td>
    <?php
    	if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<td width="64" class="tabel_header">&nbsp;</td>';
	} ?>
    </tr>
</thead>
<tbody>  
  <?php do { ?>
  <tr class="tabel_body"><?php $a=$a+1 ?>
    <td align="center"><?php echo $a; ?></td>
    <td align="center"><a href="viewpodetail_ready.php?data=<?php echo $row_rsdatapo['id']; ?>"><?php echo $row_rsdatapo['pono']; ?></a></td>
    <td align="center">0<?php echo $row_rsdatapo[revisi]; ?></td>
    <td align="center"><?php echo $row_rsdatapo['nomr']; ?></td>
    <td align="center"><?php echo functddmmmyyyy($row_rsdatapo['podate']); ?></td>
    <td><?php echo $row_rsdatapo['vendorname']; ?></td>
    <td align="center"><?php echo $row_rsdatapo['deliverytime']; ?></td>
    
	<?php
    	if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		?> <td align="center"><a href="editpoheader.php?data=<?php echo $row_rsdatapo['id']; ?>">Edit </a>| <a href="revisipo.php?data=<?php echo $row_rsdatapo['pono']; ?>">Revise</a></td>
	<?php } ?>
    
  </tr>
  <?php } while ($row_rsdatapo = mysql_fetch_assoc($rsdatapo)); ?>
</tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rsdatapo);
?>