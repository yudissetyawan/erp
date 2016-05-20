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

mysql_select_db($database_core, $core);
$query_header_SI = "SELECT id, no_si, `date`, `to`, dest, ship, contract_no, schedule_dlv FROM pr_si_header";
$header_SI = mysql_query($query_header_SI, $core) or die(mysql_error());
$row_header_SI = mysql_fetch_assoc($header_SI);
$totalRows_header_SI = mysql_num_rows($header_SI);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of Shipping Instruction (SI)</title>
<link href="../../css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>

<body>
<p class="buatform"><b>List of Shipping Instruction (SI)</b></p>
<?php { include "../../dateformat_funct.php"; } ?>

<table width="840" border="0" class="table" id="celebs">
  <thead>
  <tr class="tabel_header" height="40">
    <td>No.</td>
    <td>Shipping Instruction<br />No.</td>
    <td width="80">Date</td>
    <td width="100">To</td>
    <td width="100">Destination</td>
    <td width="100">Shipped</td>
    <td width="90">Contract No.</td>
    <td width="80">Schedule<br />Delivery</td>
    <td width="100">&nbsp;</td>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><a href="/ppic/pkg_list/view_pl_header.php?data=<?php echo $row_header_SI['id']; ?>"><?php echo $row_header_SI['no_si']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_header_SI['date']); ?></td>
      <td><?php echo $row_header_SI['to']; ?></td>
      <td><?php echo $row_header_SI['dest']; ?></td>
      <td><?php echo $row_header_SI['ship']; ?></td>
      <td align="center"><?php echo $row_header_SI['contract_no']; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_header_SI['schedule_dlv']); ?></td>
      <td align="center"><b><a href="../input_pl_header.php?data=<?php echo $row_header_SI['id']; ?>">Add Packing List</a></b></td>
    </tr>
    <?php } while ($row_header_SI = mysql_fetch_assoc($header_SI)); ?>
    </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($header_SI);
?>