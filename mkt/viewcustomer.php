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
$query_Recordset1 = "SELECT * FROM a_customer ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	color: #000;
	text-decoration: none;
}
a:hover {
	color: #000;
	text-decoration: underline;
}
a:active {
	color: #F00;
	text-decoration: none;
}
-->
</style>

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

<body class="General">
<p><a href="inputcustomer.php">Add New Customer</a></p>
<div class="container">
  <table width="371" border="0"  class="table" id="celebs">
  <thead>
    <tr class="tabel_header">
      
      <td width="25" align="center">No</td>
      <td width="336" align="center">Customer Name</td>
      
    </tr>
    </thead>
    <tbody>
<?php do { ?>
    <tr class="tabel_body">

      <form class="tabel_body">
        <td align="center"><?php echo $row_Recordset1[id]; ?></td>
        <td><a href="viewcustomerdetail.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['customername']; ?></a></td>
      </form>
  
    </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </tbody>
  </table>
  </div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
