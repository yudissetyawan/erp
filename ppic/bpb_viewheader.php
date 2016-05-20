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
$query_rsbpbheader = "SELECT p_bpb_header.*, h_employee.firstname AS reqfname, h_employee.midlename AS reqmname, h_employee.lastname AS reqlname FROM p_bpb_header, h_employee WHERE h_employee.id = p_bpb_header.request_by";
$rsbpbheader = mysql_query($query_rsbpbheader, $core) or die(mysql_error());
$row_rsbpbheader = mysql_fetch_assoc($rsbpbheader);
$totalRows_rsbpbheader = mysql_num_rows($rsbpbheader);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View BPB</title>
<link href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
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
</script>

<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>

<p><a href="bpb_inputheader.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>New BPB</a></p>
<br />
<table width="800" border="0" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td width="20">No.</td>
    <td width="100">BPB No.</td>
    <td width="80">BPB Date</td>
    <td width="90">WO No. / SPK</td>
    <td>Request by </td>
    <td>Approved by </td>
    <td>&nbsp;</td>
  </tr>
  </thead>
  <tbody>
  <?php
  { include "../dateformat_funct.php"; }
  do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a = $a + 1; echo $a; ?></td>
      <td align="center"><a href="bpb_viewcore.php?data=<?php echo $row_rsbpbheader['id']; ?>"><?php echo $row_rsbpbheader['bpb_no']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_rsbpbheader['bpb_date']); ?></td>
      <td align="center"><?php echo $row_rsbpbheader['wo_number_or_spk']; ?></td>
      <td>
		<?php
		$approvedby = $row_rsbpbheader['approved_by'];
		mysql_select_db($database_core, $core);
		$query_rsapprovedby = "SELECT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, p_bpb_header WHERE h_employee.id = p_bpb_header.approved_by AND p_bpb_header.approved_by = '$approvedby'";
		$rsapprovedby = mysql_query($query_rsapprovedby, $core) or die(mysql_error());
		$row_rsapprovedby = mysql_fetch_assoc($rsapprovedby);
		$totalRows_rsapprovedby = mysql_num_rows($rsapprovedby);
		
		$receivedby = $row_rsbpbheader['received_by'];
		

$vaccounting = $row_rsbpbheader['accounting'];
		

echo $row_rsbpbheader['reqfname']; ?> <?php echo $row_rsbpbheader['reqmname']; ?> <?php echo $row_rsbpbheader['reqlname']; ?></td>
      <td><?php echo $row_rsapprovedby['firstname']?> <?php echo $row_rsapprovedby['midlename']; ?> <?php echo $row_rsapprovedby['lastname']; ?></td>
      <td align="center"><a href="bpb_editheader.php?data=<?php echo $row_rsbpbheader['id']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_rsbpbheader = mysql_fetch_assoc($rsbpbheader)); ?>
    </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rsbpbheader);
	mysql_free_result($rsapprovedby);
	
?>