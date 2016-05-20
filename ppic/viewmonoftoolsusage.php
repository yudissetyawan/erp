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
$query_rstoolusage = "SELECT p_monoftoolsusage.id_usage, p_monoftoolsusage.id_inctools, p_mon_tools.name_of_tools, p_mon_tools.id_tools, p_mon_tools.brand, p_mon_tools.spec, p_mon_tools.descr, p_mon_tools.unit, p_monoftoolsusage.outgoing_date, p_monoftoolsusage.outgoing_qty, p_monoftoolsusage.incoming_date, p_monoftoolsusage.incoming_qty, p_mon_location.location_of_tools, p_monoftoolsusage.TBorSCMorRC, p_monoftoolsusage.proj_code, p_monoftoolsusage.remarks, p_monoftoolsusage.last_update, p_monoftoolsusage.update_by FROM p_monoftoolsusage, p_mon_tools, p_mon_location  WHERE p_mon_tools.id_inctools = p_monoftoolsusage.id_inctools AND p_mon_location.id_location = p_monoftoolsusage.id_location";
$rstoolusage = mysql_query($query_rstoolusage, $core) or die(mysql_error());
$row_rstoolusage = mysql_fetch_assoc($rstoolusage);
$totalRows_rstoolusage = mysql_num_rows($rstoolusage);

$vusr = $row_rstoolusage['update_by'];
mysql_select_db($database_core, $core);
$query_rsusr = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vusr'";
$rsusr = mysql_query($query_rsusr, $core) or die(mysql_error());
$row_rsusr = mysql_fetch_assoc($rsusr);
$totalRows_rsusr = mysql_num_rows($rsusr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<p><b><a href="monoftoolsusage_input.php">Add Data Monitoring of Tools Usage</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="#monoftools_input.php">Data of Tools</a> &nbsp;&nbsp; | &nbsp;&nbsp; <a href="#monoflocation_input.php">Data of Location</a></b></p>';
	}
?>
<br />

<table width="1200" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td align="center" height="50">No.</td>
    <td align="center" width="120">Name</td>
    <td align="center" width="40">Brand</td>
    <td align="center">Spec.</td>
    <td align="center" width="20">ID</td>
    <td align="center">Descr.</td>
    <td align="center">Unit</td>
    <td align="center" width="70">Outgoing Date</td>
    <td align="center">Outgoing Qty</td>
    <td align="center" width="60">Incoming Date</td>
    <td align="center">Incoming Qty</td>
    <td align="center" width="140">Location</td>
    <td align="center" width="70">TB / SCM / RC</td>
    <td align="center" width="70">Proj. Code / User</td>
    <td align="center" width="70">Remarks</td>
    <td align="center" width="70">Update</td>
    <td align="center" width="100">Issued by</td>
    <?php if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<td align="center" width="70">Edit | Delete</td>';
	} ?>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
    <tr class="tabel_body" ondblclick="this.style.fontWeight='bold';" onclick="this.style.fontWeight='normal';" title="Double click data for 'highlight', and one click to remove highlight"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td><?php echo $row_rstoolusage['name_of_tools']; ?></td>
      <td align="center"><?php echo $row_rstoolusage[brand]; ?></td>
      <td align="center"><?php echo $row_rstoolusage[spec]; ?></td>
      <td align="center"><?php echo $row_rstoolusage[id_tools]; ?></td>
      <td><?php echo $row_rstoolusage['descr']; ?></td>
      <td align="center"><?php echo $row_rstoolusage[unit]; ?></td>
      <td align="center"><?php { include "../dateformat_funct.php"; } echo functddmmmyyyy($row_rstoolusage['outgoing_date']); ?></td>
      <td align="center"><?php echo $row_rstoolusage[outgoing_qty]; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rstoolusage['incoming_date']); ?></td>
      <td align="center"><?php echo $row_rstoolusage[incoming_qty]; ?></td>
      <td><?php echo $row_rstoolusage['location_of_tools']; ?></td>
      <td align="center"><?php echo $row_rstoolusage[TBorSCMorRC]; ?></td>
      <td align="center"><?php echo $row_rstoolusage[proj_code]; ?></td>
      <td><?php echo $row_rstoolusage[remarks]; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rstoolusage[last_update]); ?></td>
      <td><?php echo $row_rsusr[fname]; ?> <?php echo $row_rsusr[mname]; ?> <?php echo $row_rsusr[lname]; ?></td>
      <?php
		if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
			<td align="center"><a href="monoftoolsusage_edit.php?data=<?php echo $row_rstoolusage['id_usage']; ?>">Edit</a> | <a href="monoftoolsusage_delete.php?data=<?php echo $row_rstoolusage['id_usage']; ?>" onclick="return confirm('Are you sure to delete data monitoring of <?php echo $row_rstoolusage['name_of_tools']; ?> at <?php echo $row_rstoolusage['location_of_tools']; ?> ?')">Delete</a></td>
		<?php } ?>
    </tr>
    <?php } while ($row_rstoolusage = mysql_fetch_assoc($rstoolusage)); ?>
</tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rstoolusage);
?>