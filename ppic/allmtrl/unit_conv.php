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
$query_rsunitconv = "SELECT m_unit_conv.*, m_unit.unit FROM m_unit, m_unit_conv WHERE m_unit_conv.id_unit = m_unit.id_unit OR m_unit_conv.to_idunit = m_unit.id_unit";
$rsunitconv = mysql_query($query_rsunitconv, $core) or die(mysql_error());
$row_rsunitconv = mysql_fetch_assoc($rsunitconv);
$totalRows_rsunitconv = mysql_num_rows($rsunitconv);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Terms of Payment</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
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

<body class="General">
<h3>Unit Converter</h3>

<?php
	if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<p><a href="#" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Unit Converter</a></p>';
	} ?>
<table width="650" border="0" class="table" id="celebs">
  <thead>
  <tr class="tabel_header">
    <td height="20" width="30" align="center" class="tabel_header">No.</td>
    <td width="100" class="tabel_header">from Unit</td>
    <td width="80" class="tabel_header">Operator</td>
    <td width="80" class="tabel_header">Factor</td>
    <td width="100" class="tabel_header">to Unit</td>
    <td width="150" class="tabel_header">Note</td>
    <td width="95" class="tabel_header">&nbsp;</td>
    </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td align="center"><?php echo $row_rsunitconv['unit']; ?></td>
      <td align="center"><?php echo $row_rsunitconv['operator']; ?></td>
      <td align="center"><?php echo $row_rsunitconv['nominal_conv']; ?></td>
      <td align="center"><?php echo $row_rsunitconv['unitdesc']; ?></td>
      <td align="center"><?php echo $row_rsunitconv['conv_note']; ?></td>
      <td align="center"><a href="#">Edit</a> | <a href="#">Delete</a></td>
    </tr>
    <?php } while ($row_rsunitconv = mysql_fetch_assoc($rsunitconv)); ?>
</tbody>
</table>

<br /><br />
<p><a href="#" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-calculator"></span>Process Convert</a></p>
    
</body>

</html>
<?php
	mysql_free_result($row_rsunitconv);
?>