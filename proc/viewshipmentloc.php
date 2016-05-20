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

mysql_select_db($database_core, $core);
$query_rsshipmentloc = "SELECT * FROM pc_shipmentloc WHERE pc_shipmentloc.activeYN ='1'";
$rsshipmentloc = mysql_query($query_rsshipmentloc, $core) or die(mysql_error());
$row_rsshipmentloc = mysql_fetch_assoc($rsshipmentloc);
$totalRows_rsshipmentloc = mysql_num_rows($rsshipmentloc);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Shipment Location</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
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

</head>

<body class="General">
<?php
	if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<p><a href="addshipmentloc.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Shipment Location</a></p>';
	} ?>
    
<table border="0" width="500" class="table" id="celebs">
  <thead>
  <tr class="tabel_header">
    <td height="20" width="30" align="center" class="tabel_header">No.</td>
    <td width="400" align="center" class="tabel_header">Shipment Location</td>
    <td width="80" class="tabel_header">&nbsp;</td>
    </tr>
</thead>
<tbody>  
  <?php do { ?>
  <tr class="tabel_body"><?php $a=$a+1 ?>
    <td align="center"><?php echo $a; ?></td>
    <td><?php echo $row_rsshipmentloc['shipmentloc_descr']; ?></td>
    <td align="center"><a href="editshipmentloc.php?data=<?php echo $row_rsshipmentloc['id_sloc']; ?>">Edit</a> | <a href="delshipmentloc.php?data=<?php echo $row_rsshipmentloc['id_sloc']; ?>">Delete</a></td>
  </tr>
  <?php } while ($row_rsshipmentloc = mysql_fetch_assoc($rsshipmentloc)); ?>
</tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rsshipmentloc);
	
?>