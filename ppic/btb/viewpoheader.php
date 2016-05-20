<?php require_once('../../Connections/core.php'); ?>
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

mysql_select_db($database_core, $core);
$query_rspoheader = "SELECT c.*, o.nomr, d.vendorname FROM c_po_header c, p_mr_header o, c_vendor d WHERE c.mrno=o.id and c.vendor=d.id  AND c.activeornot = '1' ORDER BY c.podate DESC";
$rspoheader = mysql_query($query_rspoheader, $core) or die(mysql_error());
$row_rspoheader = mysql_fetch_assoc($rspoheader);
$totalRows_rspoheader = mysql_num_rows($rspoheader);

mysql_select_db($database_core, $core);
$query_rspocore = "SELECT c_po_core.*, c_po_header.pono, m_e_model.mtrl_model, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.id_type, m_unit.unit AS itemunit FROM c_po_core, c_po_header, m_master, m_e_model, m_unit WHERE c_po_header.id = c_po_core.poheader AND c_po_core.itemno = m_master.id_item AND m_master.id_mmodel = m_e_model.id_mmodel AND m_master.id_unit = m_unit.id_unit ORDER BY c_po_core.poheader DESC LIMIT 1";
$rspocore = mysql_query($query_rspocore, $core) or die(mysql_error());
$row_rspocore = mysql_fetch_assoc($rspocore);
$totalRows_rspocore = mysql_num_rows($rspocore);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>List of Purchase Order (PO)</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../../css/table.css" rel="stylesheet" type="text/css">
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
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "getview_podetail.php?data=" + str, true);
	xmlhttp.send();
}
</script>
</head>

<body class="General">
<p class="buatform"><b>List of Purchase Order (PO)</b></p>
<?php { require_once "../../dateformat_funct.php"; } ?>

<table width="800" border="0" class="table" id="celebs">
  <thead>
  <tr class="tabel_header" height="30">
    <td width="12">No.</td>
    <td width="110">PO No.</td>
    <td width="75">PO Date</td>
    <td>Vendor</td>
    <td width="110">MR No.</td>
    <td width="60">Revision</td>
    <td width="100">Delivery Time</td>
    <td width="70">&nbsp;</td>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr class="tabel_body" onclick="showData(<?php echo $row_rspoheader['id']; ?>)" style="cursor:pointer" title="Click to view Item of PO">
      <td align="center"><?php $a = $a + 1; echo $a; ?></td>
      <td align="center"><a href="view_btb_header.php?data=<?php echo $row_rspoheader['id']; ?>" title="View BTB of PO No. <?php echo $row_rspoheader['pono']; ?>"><?php echo $row_rspoheader['pono']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_rspoheader['podate']); ?></td>
      <td><?php echo $row_rspoheader['vendorname']; ?></td>
      <td align="center"><?php echo $row_rspoheader['nomr']; ?></td>
      <td align="center">0<?php echo $row_rspoheader[revisi]; ?></td>
      <td align="center"><?php echo $row_rspoheader['deliverytime']; ?></td>
      <td align="center"><a href="../input_btb_header.php?data=<?php echo $row_rspoheader['id']; ?>"><b>New BTB</b></a></td>
    </tr>
    <?php } while ($row_rspoheader = mysql_fetch_assoc($rspoheader)); ?>
  </tbody>
</table>

<br /><br /><br />

<!-- <p class="buatform">Item of Material / Service Request (M/S R)</p> -->
<div id="txtHint">
    <p>Item of PO No. : <b><?php echo $row_rspocore['pono']; ?></b></p>
    
    <table width="1000" class="table">
        <tr align="center" class="tabel_header" height="30">
          <td width="20"><b>No.</b></td>
          <td width="263"><b>Description</b></td>
          <td width="145"><b>Spec.</b></td>
          <td width="48"><b>Qty</b></td>
          <td width="86"><b>Total Price</b></td>
          <td width="170"><b>Price After Discount</b></td>
          <td width="70"><b>Currency</b></td>
          <td><b>Remark</b></td>
        </tr>
        <?php do { ?>
          <tr class="tabel_body">
            <td align="center"><?php $b=$b+1; echo $b; ?></td>
            <td><?php echo $row_rspocore['mtrl_model']; ?> (<?php echo $row_rspocore['descr_name']; ?>) <?php echo $row_rspocore['id_type']; ?> <?php echo $row_rspocore['brand']; ?></td>
            <td><?php echo $row_rspocore['descr_spec']; ?></td>
            <td align="center"><?php echo $row_rspocore[qty]; ?> <?php echo $row_rspocore[itemunit]; ?></td>
            <td align="center"><?php echo $row_rspocore['totalprice']; ?></td>
            <td align="center"><?php echo $row_rspocore['popriceafterdisc']; ?></td>
            <td align="center"><?php echo $row_rspocore['cur']; ?></td>
            <td width="142"><?php echo $row_rspocore['remark_pocore']; ?></td>
          </tr>
          <?php } while ($row_rspocore = mysql_fetch_assoc($rspocore)); ?>
    </table>
</div>

</body>
</html>
<?php
	mysql_free_result($rspoheader);
	mysql_free_result($rspocore);
?>