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
$query_Recordset1 = "SELECT * FROM m_master_catg WHERE catg_stat = '1'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Category of Item</title>
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>

<body>
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<p><a href="inputcatg.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Category</a></p>';
	}
?>

<table width="700" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td width="25">No.</td>
    <td width="60">Category Code</td>
    <td width="150">Category</td>
    <td width="400">Descr.</td>
    <td width="80">&nbsp;</td>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body"><?php $a = $a + 1; ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><?php echo $row_Recordset1[mcatg_code]; ?></td>
      
      <td>
      	<?php
		$idmcatg = $row_Recordset1['id_mcatg'];
		mysql_select_db($database_core, $core);
		$query_rssubcatg = "SELECT id_msubcatg, id_mcatg FROM m_master_subcatg WHERE id_mcatg = '$idmcatg'";
		$rssubcatg = mysql_query($query_rssubcatg, $core) or die(mysql_error());
		$row_rssubcatg = mysql_fetch_assoc($rssubcatg);
		$totalRows_rssubcatg = mysql_num_rows($rssubcatg);
		?>
      		<a href="view_master_subcatg.php?data=<?php echo $row_Recordset1['id_mcatg']; ?>" title="Click to ADD or VIEW <?php echo $totalRows_rssubcatg; ?> SubCategory"><?php echo $row_Recordset1['mcatg_descr']; ?></a>
      </td>
      
      <td><?php echo $row_Recordset1['catg_notes']; ?></td>
      <td align="center">
          <a href="edit_master_catg.php?data=<?php echo $row_Recordset1['id_mcatg']; ?>">Edit</a> |
          <a href="delete_master_catg.php?data=<?php echo $row_Recordset1['id_mcatg']; ?>">Delete</a>
      </td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</tbody>    
</table>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($rssubcatg);
?>
