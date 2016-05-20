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
$query_Recordset1 = "SELECT * FROM h_employee WHERE h_employee.firstname <> 'Administrator' AND h_employee.code='K' ORDER BY h_employee.nik ASC";
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
<title>Data Employee</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="Description" content="Learn to create paginated, editable, and sortable tables in jQuery." />
<meta name="Keywords" content="jquery, datatables, jeditable, paginated tables, table sorting, akshitsethi" />
<meta name="Owner" content="Akshit Sethi" />

<link rel="shortcut icon" href="img/favicon.ico">
<link href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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
<p><a href="inputkaryawan.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add New Employee</a></p>

	<div class="container">
	  <table width="100%" class="table" id="celebs">
      <thead>
	  <tr class="tabel_header" height="40">
	      <td width="35">No.</td>
	      <td width="135">Department</td>
	      <td width="135">Position</td>
	      <td width="50">N I K</td>
	      <td width="165">Name of Employee</td>
	      <td width="75">Status</td>
	      <td width="45">*Code</td>
	      <td width="50">Clothing Size</td>
	      <td width="100">Username</td>
	      <td width="85">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
	 <?php do { ?>
	    <tr class="tabel_body">
	      <td align="center"><?php $n=$n+1; echo $n ; ?></td>
	      <td align="center"><?php echo $row_Recordset1['department']; ?></td>
	      <td><?php echo $row_Recordset1['jabatan']; ?></td>
	      <td><?php echo $row_Recordset1[nik]; ?></td>
	      <td><?php echo $row_Recordset1[firstname]; ?> <?php echo $row_Recordset1[midlename]; ?> <?php echo $row_Recordset1[lastname]; ?></td>
	      <td align="center"><?php echo $row_Recordset1[status]; ?></td>
	      <td align="center"><?php echo $row_Recordset1[code]; ?></td>
	      
          <td align="center">
		  <?php
		  	$idemp = $row_Recordset1['id'];
			mysql_select_db($database_core, $core);
		  	$query_Recordset2 = "SELECT h_datapribadi.ukuran_baju FROM h_datapribadi WHERE id_h_employee = '$idemp'";
			$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
			$row_Recordset2 = mysql_fetch_assoc($Recordset2);
			$totalRows_Recordset2 = mysql_num_rows($Recordset2);
		  
		  	echo $row_Recordset2['ukuran_baju'];
		  ?>
          </td>
	      
          <td align="center"><?php echo $row_Recordset1['username']; ?></td>
	      <td align="center"><a href="viewdata_karyawan.php?data=<?php echo $row_Recordset1['id']; ?>" target="_blank"><strong>Detail </strong></a>| <strong><a href="#" onClick="MM_openBrWindow('edit_employee.php?data=<?php echo $row_Recordset1['id']; ?>','','width=600,height=550')">Edit</a></strong></td>
        </tr>
     <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </tbody>
      </table>
	</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
