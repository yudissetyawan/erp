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

mysql_select_db($database_core, $core);
$query_rsvendor = "SELECT c_vendor.*, c_vendorcatg.category FROM c_vendor, c_vendorcatg WHERE c_vendor.vendorcategory = c_vendorcatg.id AND c_vendor.vendoractive = '1'";
$rsvendor = mysql_query($query_rsvendor, $core) or die(mysql_error());
$row_rsvendor = mysql_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysql_num_rows($rsvendor);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List Vendor</title>
</head>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
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
	function showUser(str) {
		if (str == ""){
		  document.getElementById("txtHint").innerHTML = "";
		  return;
		} if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
		  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","../fileajax/getvendor.php?q="+str,true);
		xmlhttp.send();
	}
</script>

<body class="General">
<p><a href="inputvendor.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Register Vendor</a></p>

<table width="1800" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="30">
  	<td width="20">No.</td>
  	<td width="50">Code</td>
    <td width="170">Vendor Name</td>
    <td width="270">Vendor Address</td>
    <td width="80">City</td>
    <td width="50">Zip</td>
    <td width="95">Phone</td>
    <td width="95">Fax</td>
    <td width="110">Email</td>
    <td width="120">Contact<br />Person</td>
    <td width="120">Contact<br />Person 2</td>
    <td width="200">Product / Service</td>
    <td width="80">Evaluation<br />Date</td>
    <td width="110">Remark</td>
    <td>Vendor Class</td>
    <td>Vendor Category</td>
    <td width="40">&nbsp;</td>
  </tr>
</thead>
<tbody>
  <?php
  	{ include "../dateformat_funct.php"; }
	do { ?>
    <tr class="tabel_body" ondblclick="this.style.fontWeight='bold';" onclick="this.style.fontWeight='normal';" title="Double click data for 'highlight', and one click to remove highlight"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_rsvendor['recordno']; ?></td>
      <td title="View Detail of Vendor"><a href="viewvendordetail.php?data=<?php echo $row_rsvendor['id']; ?>"><?php echo $row_rsvendor['vendorname']; ?></a></td>
      <td><?php echo $row_rsvendor['vendoraddress']; ?></td>
      <td align="center"><?php echo $row_rsvendor['city']; ?></td>
      <td align="center"><?php echo $row_rsvendor['zip']; ?></td>
      <td align="center"><?php echo $row_rsvendor['officephone']; ?></td>
      <td align="center"><?php echo $row_rsvendor['fax']; ?></td>
      <td><?php echo $row_rsvendor['email']; ?> <?php echo $row_rsvendor['email_2']; ?></td>
      <td align="center"><?php echo $row_rsvendor['contactperson']; ?></td>
      <td align="center"><?php echo $row_rsvendor['contactperson_2']; ?></td>
      <td><?php echo $row_rsvendor['product_service']; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rsvendor['evaluationdate']); ?></td>
      <td><?php echo $row_rsvendor['remark']; ?></td>
      <td><?php echo $row_rsvendor['vendorclass']; ?></td>
      <td><?php echo $row_rsvendor['category']; ?></td>
      <td align="center"><a href="delvendor.php?data=<?php echo $row_rsvendor['id']; ?>">Delete</a></td>
    </tr>
    <?php } while ($row_rsvendor = mysql_fetch_assoc($rsvendor)); ?>
</tbody>
</table>

<!--
<br />
<form>
  <select name=nota onChange="showUser(this.value)">     
    <option value="">- Select Category -</option>
    <option value="5">Tools</option>
    <option value="6">Spare Parts</option>
  </select>
</form>
<div id="txtHint"><b>Part info will be listed here.</b></div>
-->

</body>
</html>
<?php
	mysql_free_result($rsvendor);
?>