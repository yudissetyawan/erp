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
$query_cm = "SELECT dms.id, dms.inisial_pekerjaan, dms.date, dms.fileupload, dms.keterangan FROM dms WHERE inisial_pekerjaan = 'MOMcm' ORDER BY dms.`date` DESC";
$cm = mysql_query($query_cm, $core) or die(mysql_error());
$row_cm = mysql_fetch_assoc($cm);
$totalRows_cm = mysql_num_rows($cm);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MR / DCC - MOM General Meeting</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">
<link href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<table width="624" border="0" class="table" id="celebs">
  <thead>
    <tr class="tabel_header" align="left" height="30">
      <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=1','','scrollbars=yes,resizable=yes,width=450,height=300')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add New</a></td>
    </tr>
    <tr class="tabel_header" height="30">
      <td width="34">No.</td>
      <td width="100">Date</td>
      <td width="388">Title of File</td>
      <td width="70">&nbsp;</td>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
      <tr class="tabel_body">
        <?php $a=$a+1; ?>
        <td align="center"><?php echo $a ?></td>
        <td align="center"><?php
				include "../../dateformat_funct.php";
				echo functddmmmyyyy($row_cm['date']);
			?></td>
        <td><a href="../MOM_/uploadmom/<?php echo $row_cm[fileupload]; ?>" target="_blank"></a><a href="../MOM_/uploadmom/<?php echo $row_cm[fileupload]; ?>" target="_blank"><?php echo $row_cm['keterangan']; ?></a></td>
        <td align="center">&nbsp;</td>
      </tr>
      <?php } while ($row_cm = mysql_fetch_assoc($cm)); ?>
  </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($cm);
?>