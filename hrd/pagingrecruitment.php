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
$query_Recordset1 = "SELECT * FROM h_recruitment WHERE h_recruitment.viewornot = '1'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/*
	@! Creating perfect tables using jQuery
-----------------------------------------------------------------------------	
	# author: @akshitsethi
	# web: http://www.akshitsethi.me
	# email: ping@akshitsethi.me
	# mobile: (91)9871084893
-----------------------------------------------------------------------------
	@@ The biggest failure is failing to try.
*/
?>
<!doctype html>
<html lang="en">
<head>
<title>Data Applicant</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="Learn to create paginated, editable, and sortable tables in jQuery." />
<meta name="Keywords" content="jquery, datatables, jeditable, paginated tables, table sorting, akshitsethi" />
<meta name="Owner" content="Akshit Sethi" />

<link rel="shortcut icon" href="img/favicon.ico">
<link href="/css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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

<body>
<p><a href="input_cv.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add New Applicant</a></p>

<div class="container">
	<table width="560" class="table" id="celebs">
	<thead>
		<tr class="tabel_header" height="40">
			<td width="65">No</td>
			<td width="160">Nama</td>
			<td width="75">Status</td>
			<td width="85">Date of Entry</td>
			<td width="140">View</td>
		</tr>
    </thead>
    <tbody>
    <?php do { ?>
      <tr class="tabel_body">
        <td align="center"><?php echo $row_Recordset1[no_pelamar] . ' '; ?></td>
        <td ><?php echo $row_Recordset1[firstname] . ' ' .$row_Recordset1[midlename] . ' '. $row_Recordset1[lastname]; ?></td>
        <td align="center"><?php if ($row_Recordset1['status']==1) {echo "Baru";} else {echo "Pernah Dipanggil";} ?></td>
        <td align="center" width="130" ><?php echo $row_Recordset1['date']; ?></td>
        <td align="center"><a href="/hrd/viewcvdetail.php?data=<?php echo $row_Recordset1['id']; ?>" target="_blank"><b>Detail</b></a> | <a href='#' onClick="MM_openBrWindow('edit_recruitment.php?data=<?php echo $row_Recordset1['id']; ?>','','scrollbars=yes,width=600,height=300')"><b>Edit</b></a>
          <?php // | <a href='deleterecruitment.php?id=echo $row_Recordset1['id'];' onclick="return confirm('Apa anda yakin akan menghapus pelamar bernama echo $row_Recordset1['firstname']; echo $row_Recordset1['midlename']; echo $row_Recordset1['lastname'];  ?? ')"> <strong>Delete</strong></a> ?> | <a href="#" onClick="MM_openBrWindow('recruit.php?data=<?php echo $row_Recordset1['id']; ?>','','scrollbars=yes,width=400,height=500')"><b>Recruit</b></a></td>
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
