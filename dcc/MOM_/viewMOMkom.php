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
$query_kom = "SELECT * FROM dms WHERE dms.inisial_pekerjaan = 'MOMkom' ORDER BY dms.`date` DESC";
$kom = mysql_query($query_kom, $core) or die(mysql_error());
$row_kom = mysql_fetch_assoc($kom);
$totalRows_kom = mysql_num_rows($kom);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MR / DCC - MOM General Meeting</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<table width="624" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td colspan="4"><a href="#" onclick="MM_openBrWindow('../addmom.php?data=7','','scrollbars=yes,resizable=yes,width=450,height=300')">Add New</a></td>
  </tr>
  <tr class="tabel_header">
      <td width="34">No.</td>
      <td width="100">Date</td>
      <td width="388">Title of File</td>
      <td width="70">&nbsp;</td>
  </tr>
  </thead>
  <tbody>
  <?php do { ?>
  <tr class="tabel_body">
    <?php $n=$n+1 ?>
    <td align="center"><?php echo $n ?></td>
    <td align="center"><?php include "../../dateformat_funct.php";
                		echo functddmmmyyyy($row_kom['date']); ?></td>
    <td><a href="../MOM_/uploadmom/<?php echo $row_kom['fileupload']; ?>"><?php echo $row_kom['keterangan']; ?></a></td>
    <td align="center">&nbsp;</td>
  </tr>
  <?php } while ($row_kom = mysql_fetch_assoc($kom)); ?>
  </tbody>
</table>
</body>
</html>
<?php
mysql_free_result($kom);
?>
