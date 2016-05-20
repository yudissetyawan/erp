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

$colname_dwn_listofdwnnumb = "-1";
if (isset($_GET['data'])) {
  $colname_dwn_listofdwnnumb = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dwn_listofdwnnumb = sprintf("SELECT e_dwnlistofnodwn.* FROM e_dwnlistofnodwn WHERE e_dwnlistofnodwn.id_groupwork = %s", GetSQLValueString($colname_dwn_listofdwnnumb, "int"));
$dwn_listofdwnnumb = mysql_query($query_dwn_listofdwnnumb, $core) or die(mysql_error());
$row_dwn_listofdwnnumb = mysql_fetch_assoc($dwn_listofdwnnumb);
$totalRows_dwn_listofdwnnumb = mysql_num_rows($dwn_listofdwnnumb);

$colname_groupwork = "-1";
if (isset($_GET['data'])) {
  $colname_groupwork = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_groupwork = sprintf("SELECT * FROM e_dwngroupwork WHERE id = %s", GetSQLValueString($colname_groupwork, "int"));
$groupwork = mysql_query($query_groupwork, $core) or die(mysql_error());
$row_groupwork = mysql_fetch_assoc($groupwork);
$totalRows_groupwork = mysql_num_rows($groupwork);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
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
<p><a href="dwn_listofdwnnumb_input.php?data=<?php echo $_GET['data']; ?>" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>New Drawing Number</a></p>
<h2>Drawing Number of  <?php echo $row_groupwork['initial']; ?> - <?php echo $row_groupwork['description']; ?></h2>
<table width="850" border="0">
  <tr class="tabel_header">
    <td rowspan="2">No</td>
    <td rowspan="2">Drawing No.</td>
    <td rowspan="2">Description</td>
    <td rowspan="2">Handled By.</td>
    <td colspan="5">CRF Issued</td>
    <td rowspan="2">Owner</td>
    <td rowspan="2">Location/Area</td>
    <td rowspan="2">Project Code</td>
    <td rowspan="2">Binder Code</td>
  </tr>
  <tr class="tabel_header">
    <td>Rev.0</td>
    <td>Rev.1</td>
    <td>Rev.2</td>
    <td>Rev.3</td>
    <td>Rev.4</td>
  </tr>
  <tr class="tabel_body"><?php $a=$a+1; ?>
    <td><?php echo $a; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['drawing_no']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['description']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['handle_by']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['rev_0']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['rev_1']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['rev_2']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['rev_3']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['rev_4']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['owner']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['location']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['proj_code']; ?></td>
    <td><?php echo $row_dwn_listofdwnnumb['binder_code']; ?></td>
  </tr>
</table>
<p>
  <a href="dwn_groupwork.php"><input type="submit" name="BACK" id="BACK" value="BACK" /> </a>
</p>
</body>
</html>
<?php
mysql_free_result($dwn_listofdwnnumb);

mysql_free_result($groupwork);
?>
