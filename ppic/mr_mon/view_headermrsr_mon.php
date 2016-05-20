<?php require_once('../../Connections/core.php'); ?>
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
$query_Recordset1 = "SELECT p_mr_header.*, a_production_code.projectcode, a_production_code.projecttitle, p_mr_header.prodcode FROM p_mr_header, a_production_code WHERE p_mr_header.id_prodcode = a_production_code.id ORDER BY p_mr_header.date DESC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View M/S Request per Project</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../../css/table.css" rel="stylesheet" type="text/css" />

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
<p class="buatform"><b>Material / Service Request</b></p>
<table border="0" width="100%" id="celebs">
<thead>
  <tr class="tabel_header">
    <td height="40" width="25">No.</td>
    <td width="100">M/S R No.</td>
    <td width="80">Date</td>
    <td>Project - Project Title</td>
    <td width="80">Prod. Code</td>
    <td>Note</td>
    <td width="100">Request By</td>
    <td width="100">Passed By</td>
    <td width="100">Approved By</td>
    <td width="100">Status</td>
  </tr>
</thead>
<tbody>
  <?php
  { include "../../dateformat_funct.php"; }
  
  do { ?>
    <tr class="tabel_body"><?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td align="center"><a href="view_detailmrsr_mon.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['nomr']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_Recordset1['date']); ?></td>
      <td><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['projecttitle']; ?></td>
      <td align="center"><?php echo $row_Recordset1['prodcode']; ?></td>
      <td><?php echo $row_Recordset1['note']; ?></td>
      
	  <?php
	  $userreq = $row_Recordset1['requestby'];
      mysql_select_db($database_core, $core);
	  $query_rsreqby = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.requestby AND p_mr_header.requestby = '$userreq'";
	  $rsreqby = mysql_query($query_rsreqby, $core) or die(mysql_error());
	  $row_rsreqby = mysql_fetch_assoc($rsreqby);
	  $totalRows_rsreqby = mysql_num_rows($rsreqby);

	$userpass = $row_Recordset1['passedby'];
	mysql_select_db($database_core, $core);
	$query_rsuserppic = "SELECT h_employee.id, h_employee.nik, h_employee.firstname AS pfname, h_employee.midlename AS pmname, h_employee.lastname AS plname FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.passedby AND p_mr_header.passedby = '$userpass'";
	$rsuserppic = mysql_query($query_rsuserppic, $core) or die(mysql_error());
	$row_rsuserppic = mysql_fetch_assoc($rsuserppic);
	$totalRows_rsuserppic = mysql_num_rows($rsuserppic);
	
	$userapprover = $row_Recordset1['approvedby'];
	mysql_select_db($database_core, $core);
	$query_rsapprover = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM h_employee, p_mr_header WHERE h_employee.id = p_mr_header.approvedby AND p_mr_header.approvedby = '$userapprover'";
	$rsapprover = mysql_query($query_rsapprover, $core) or die(mysql_error());
	$row_rsapprover = mysql_fetch_assoc($rsapprover);
	$totalRows_rsapprover = mysql_num_rows($rsapprover);
	?>
      <td><?php echo $row_rsreqby['firstname']; ?> <?php echo $row_rsreqby['midlename']; ?> <?php echo $row_rsreqby['lastname']; ?></td>
      <td><?php echo $row_rsuserppic['pfname']; ?> <?php echo $row_rsuserppic['pmname']; ?> <?php echo $row_rsuserppic['plname']; ?></td>
      <td><?php echo $row_rsapprover['firstname']; ?> <?php echo $row_rsapprover['midlename']; ?> <?php echo $row_rsapprover['lastname']; ?></td>
      <td><?php echo $row_Recordset1['status']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
 </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($Recordset2);
?>