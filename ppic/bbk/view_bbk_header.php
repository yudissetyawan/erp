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
$query_diketahui = "SELECT p_bbk_header.id, p_bbk_header.diketahui_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_bbk_header, h_employee WHERE h_employee.id=p_bbk_header.diketahui_by";
$diketahui = mysql_query($query_diketahui, $core) or die(mysql_error());
$row_diketahui = mysql_fetch_assoc($diketahui);
$totalRows_diketahui = mysql_num_rows($diketahui);

mysql_select_db($database_core, $core);
$query_diserahkan = "SELECT p_bbk_header.id, p_bbk_header.diserahkan_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM p_bbk_header, h_employee WHERE h_employee.id=p_bbk_header.diserahkan_by";
$diserahkan = mysql_query($query_diserahkan, $core) or die(mysql_error());
$row_diserahkan = mysql_fetch_assoc($diserahkan);
$totalRows_diserahkan = mysql_num_rows($diserahkan);

mysql_select_db($database_core, $core);
$query_p_bbk_header = "SELECT p_bbk_header.*, h_employee.firstname AS dtrmfname, h_employee.midlename AS dtrmmname, h_employee.lastname AS dtrmlname, p_bpb_header.bpb_no FROM p_bbk_header, h_employee, p_bpb_header WHERE h_employee.id = p_bbk_header.diterima_by AND p_bbk_header.id_bpb=p_bpb_header.id";
$p_bbk_header = mysql_query($query_p_bbk_header, $core) or die(mysql_error());
$row_p_bbk_header = mysql_fetch_assoc($p_bbk_header);
$totalRows_p_bbk_header = mysql_num_rows($p_bbk_header);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View BBK Header</title>
<link type="text/css" href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
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
</head>

<body>
<h3>List of Return Goods ( BBK )</h3>
<br />

<p><a href="../input_bbk_header.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>New BBK</a></p>

<table border="0" width="520" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td width="20">No</td>
    <td width="100">BBK No.</td>
    <td width="80">BBK Date</td>
    <td width="100">BPB No.</td>
    <td>Received by</td>
    <td width="40">&nbsp;</td>
  </tr>
</thead>
<tbody>
  <?php
  require_once "../../dateformat_funct.php";
  do { ?>
    <tr class="tabel_body"><?php $a=$a+1; ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><a href="view_bbk_core.php?data=<?php echo $row_p_bbk_header['id']; ?>"><?php echo $row_p_bbk_header['no_bbk']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_p_bbk_header['tanggal']); ?></td>
      <td align="center"><?php echo $row_p_bbk_header['bpb_no']; ?></td>
      <td><?php echo $row_p_bbk_header['dtrmfname']; ?> <?php echo $row_p_bbk_header['dtrmmname']; ?><?php echo $row_p_bbk_header['dtrmlname']; ?></td>
      <td align="center"><a href="../edit_bbkheader.php?data=<?php echo $row_p_bbk_header['id']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_p_bbk_header = mysql_fetch_assoc($p_bbk_header)); ?>
 </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($diketahui);

mysql_free_result($diserahkan);

mysql_free_result($p_bbk_header);
?>