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
$query_q_cpar = "SELECT q_cpar.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_cpar, h_employee WHERE h_employee.id = q_cpar.kepada";
$q_cpar = mysql_query($query_q_cpar, $core) or die(mysql_error());
$row_q_cpar = mysql_fetch_assoc($q_cpar);
$totalRows_q_cpar = mysql_num_rows($q_cpar);

mysql_select_db($database_core, $core);
$query_penanggung_jawab = "SELECT  h_employee.firstname, h_employee.midlename, h_employee.lastname FROM q_cpar, h_employee WHERE h_employee.id = q_cpar.penanggung_jawab";
$penanggung_jawab = mysql_query($query_penanggung_jawab, $core) or die(mysql_error());
$row_penanggung_jawab = mysql_fetch_assoc($penanggung_jawab);
$totalRows_penanggung_jawab = mysql_num_rows($penanggung_jawab);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css">
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<table width="849" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td>No.</td>
    <td>Kepada</td>
    <td>Dari</td>
    <td>Masalah</td>
    <td>Tanggal</td>
    <td>Penanggung Jawab</td>
    <td>Target Selesai</td>
    <td>&nbsp;</td>
  </tr>
</thead>  
<tbody>
  <?php
  require_once "../dateformat_funct.php";
  
  do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td><?php echo $row_q_cpar['firstname']; ?> <?php echo $row_q_cpar['midlename']; ?> <?php echo $row_q_cpar['lastname']; ?></td>
      <td><?php echo $row_q_cpar['dari']; ?></td>
      <td><a href="#" onclick="MM_openBrWindow('cpar_viewcore.php?data=<?php echo $row_q_cpar['id']; ?>','','scrollbars=yes,resizable=yes,width=1050,height=1000')"><?php echo $row_q_cpar['masalah']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_q_cpar['tanggal']); ?></td>
      <td><?php echo $row_penanggung_jawab['firstname']; ?> <?php echo $row_penanggung_jawab['midlename']; ?> <?php echo $row_penanggung_jawab['lastname']; ?></td>
      <td align="center"><?php echo $row_q_cpar['target_selesai']; ?></td>
      <td align="center"><a href="cpar_edit.php?data=<?php echo $row_q_cpar['id']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_q_cpar = mysql_fetch_assoc($q_cpar)); ?>    
</tbody>    
</table>
</body>
</html>
<?php
mysql_free_result($q_cpar);

mysql_free_result($penanggung_jawab);
?>
