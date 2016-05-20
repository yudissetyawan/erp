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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM p_mr_header WHERE id_prodcode = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View M/S Request per Project</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.datatables.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/jquery.blockui.js"></script>
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>
<!-- onfocus="MM_openBrWindow('edit_headermrsr.php?data=','E','scrollbars=yes,resizable=yes,width=0,height=0')" !-->
<body>
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator')) {
		echo '<p><a href="/ppic/inputmaterialrequest.php?data='.$row_Recordset2[id].'" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Input Material / Service Request (M/S R)</a></p>';
	}
?>
<p class="buatform"></p>
<table border="0" width="" id="celebs">
  <tr class="tabel_header">
    <td colspan="11">
        <p>Material / Service Request (M/S R) <br /> of
            <br /> Project Code - Project Title &nbsp;&nbsp; : &nbsp;&nbsp;<?php echo $row_Recordset2['projectcode']; ?> - <?php echo $row_Recordset2['projecttitle']; ?></p>
    </td> 
  </tr>
  <tr height="30" class="tabel_header">
    <td width="23">No</td>
    <td width="110">No. M/SR</td>
    <td width="90">Date</td>
    <td width="90">Prod. Code</td>
    <td width="120">Status</td>
    <td>Reference</td>
    <td colspan="2">Note</td>
  </tr>
  <?php
  include "../dateformat_funct.php";
  
  do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><a href="/ppic/view_detailmrsr.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1[nomr]; ?></a></td>
      
      <td align="center"><?php echo functddmmmyyyy($row_Recordset1['date']); ?></td>
      <td align="center"><?php echo $row_Recordset1['prodcode']; ?></td>
     
      <td><?php echo $row_Recordset1['status']; ?></td>
      <td width="177"><? if ($row_Recordset1['referencetype']=='') {echo "----";} else {echo  "<a href=upload/refmr/$row_Recordset1[referencetype]>$row_Recordset1[referencetype]</a>";} ?></td>
      <td width="178"><?php echo $row_Recordset1['note']; ?></td>
      <td width="44" align="center"><a href="edit_headermrsr.php?data=<?php echo $row_Recordset1['id']; ?>">EDIT</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
