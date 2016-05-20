<?php require_once('Connections/core.php'); ?>
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
$query_info = "SELECT * FROM contact_us WHERE type = '1'";
$info = mysql_query($query_info, $core) or die(mysql_error());
$row_info = mysql_fetch_assoc($info);
$totalRows_info = mysql_num_rows($info);

mysql_select_db($database_core, $core);
$query_suggest = "SELECT * FROM contact_us WHERE type = '2'";
$suggest = mysql_query($query_suggest, $core) or die(mysql_error());
$row_suggest = mysql_fetch_assoc($suggest);
$totalRows_suggest = mysql_num_rows($suggest);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM contact_us WHERE type = '3'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />

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


</head>

<body class="General">
<p><strong>Information</strong></p>
<table width="" border="0" class="table" id="celebs">
  <tr class="tabel_header">
    <td width="25">No</td>
    <td width="180">Time</td>
    <td width="180">Name</td>
    <td width="138">Email</td>
    <td width="141">Phone Number</td>
    <td width="247">Comment</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td><?php echo $row_info['timeofcomment']; ?></td>
      <td><?php echo $row_info['name']; ?></td>
      <td><?php echo $row_info['email']; ?></td>
      <td><?php echo $row_info['ph']; ?></td>
      <td><?php echo $row_info['comment']; ?></td>
    </tr>
    <?php } while ($row_info = mysql_fetch_assoc($info)); ?>
</table>
<p><hr width="800" align="left" /></p>
<p><strong>Suggestion</strong></p>
<table width="" border="0" class="table" id="celebs">
  <tr class="tabel_header">
    <td width="25">No</td>
    <td width="180">Time</td>
    <td width="180">Name</td>
    <td width="138">Email</td>
    <td width="141">Phone Number</td>
    <td width="247">Comment</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $b=$b+1 ?>
      <td align="center"><?php echo $b; ?></td>
      <td><?php echo $row_suggest['timeofcomment']; ?></td>
      <td><?php echo $row_suggest['name']; ?></td>
      <td><?php echo $row_suggest['email']; ?></td>
      <td><?php echo $row_suggest['ph']; ?></td>
      <td><?php echo $row_suggest['comment']; ?></td>
    </tr>
    <?php } while ($row_suggest = mysql_fetch_assoc($suggest)); ?>
</table>
<p><hr width="800" align="left" /></p>
<p><strong>Complaints</strong></p>
<table width="" border="0" class="table" id="celebs">
  <tr class="tabel_header">
    <td width="25">No</td>
    <td width="180">Time</td>
    <td width="180">Name</td>
    <td width="138">Email</td>
    <td width="141">Phone Number</td>
    <td width="247">Comment</td>
    <td width="">&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $c=$c+1 ?>
      <td align="center"><?php echo $c; ?></td>
      <td><?php echo $row_Recordset1['timeofcomment']; ?></td>
      <td><?php echo $row_Recordset1['name']; ?></td>
      <td><?php echo $row_Recordset1['email']; ?></td>
      <td><?php echo $row_Recordset1['ph']; ?></td>
      <td><?php echo $row_Recordset1['comment']; ?></td>
      <td><a href="respond.php?data=<?php echo $row_Recordset1['id']; ?>">Respond</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($info);

mysql_free_result($suggest);

mysql_free_result($Recordset1);
?>
