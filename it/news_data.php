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
$query_rsnews = "SELECT i_news.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM i_news, h_employee WHERE h_employee.id = i_news.issued_by";
$rsnews = mysql_query($query_rsnews, $core) or die(mysql_error());
$row_rsnews = mysql_fetch_assoc($rsnews);
$totalRows_rsnews = mysql_num_rows($rsnews);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bukaka News</title>
<link rel="stylesheet" type="text/css" href="/css/induk.css" />
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

<p><a href="news_input.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add News</a></p>

<table width="1050" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td width="40">No.</td>
    <td width="180">Title</td>
    <td width="145">Date</td>
    <td>Contents</td>
    <td width="130">Issued by</td>
    <td width="50"><i>Visible</i></td>
    <td width="70">&nbsp;</td>
  </tr>
 </thead>
 <tbody> 
  <?php
  { require_once "../dateformat_funct.php"; }
  do { ?>
    <tr class="tabel_body">
      <td align="center" width="30"><?php $j = $j+1; echo $j; ?></td>
      <td><?php echo $row_rsnews['news_title']; ?></td>
      <td align="center">
	  	<?php echo $row_rsnews['day_of_news']; ?>, <?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?>
      </td>
      <td><?php echo $row_rsnews['news_content']; ?></td>
      <td><?php echo $row_rsnews[firstname]; ?> <?php echo $row_rsnews[midlename]; ?> <?php echo $row_rsnews[lastname]; ?></td>
      
      <?php
      if (($row_rsnews['news_active'] == '1') && ($row_rsnews['news_active'] != '')) {
			echo '<td align="center">Yes</td>';
      } else if (($row_rsnews['news_active'] == '0') && ($row_rsnews['news_active'] != '')) {
			echo '<td align="center" bgcolor="#FF0">No</td>';
      } else {
			echo '<td align="center">&nbsp;</td>';
	  } ?>
      
      <td align="center"><a href="news_edit.php?data=<?php echo $row_rsnews['id']; ?>">Edit</a> | <a href="news_deactivate.php?data=<?php echo $row_rsnews['id']; ?>" onclick="return confirm('Delete News about <?php echo $row_rsnews['news_title']; ?> on <?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?> ?')">Delete</a></td>
    </tr>
    <?php } while ($row_rsnews = mysql_fetch_assoc($rsnews)); ?>
 </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rsnews);
?>