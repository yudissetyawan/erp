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
$query_rsppereqheader = "SELECT p_ppereq_header.*, h_employee.firstname AS manfname, h_employee.midlename AS manmname, h_employee.lastname AS manlname FROM p_ppereq_header, h_employee WHERE p_ppereq_header.req_by_manager = h_employee.id";
$rsppereqheader = mysql_query($query_rsppereqheader, $core) or die(mysql_error());
$row_rsppereqheader = mysql_fetch_assoc($rsppereqheader);
$totalRows_rsppereqheader = mysql_num_rows($rsppereqheader);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View PPE Request</title>
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />

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
</head>

<body class="General">
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator')) {
		echo '<p><a href="ppereq_inputheader.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>New Request</a></p>';
	}
?>
<table border="0" width="100%" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
    <td width="15">No.</td>
    <td width="100">PPE Request No.</td>
    <td width="80">Date</td>
    <td width="150">Note</td>
    <td width="90">Requested by <br /> (Manager)</td>
    <td width="70">Requested <br /> Date</td>
    <td width="90">Passed by <br /> (HRD)</td>
    <td width="70">Passed <br /> Date</td>
    <td width="90">Distributed by</td>
    <td width="70">Distributed <br /> Date</td>
    <td width="40">&nbsp;</td>
  </tr>
 </thead>
 <tbody>
  <?php
  { require_once "../dateformat_funct.php"; }
  
  do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td align="center"><a href="ppereq_viewdetail.php?data=<?php echo $row_rsppereqheader['id']; ?>"><?php echo $row_rsppereqheader['ppereq_no']; ?></a></td>
      <td align="center"><?php echo functddmmmyyyy($row_rsppereqheader[ppereq_date]); ?></td>
         
      <td><?php echo $row_rsppereqheader['note']; ?></td>
      <td align="center"><?php echo $row_rsppereqheader[manfname]; ?> <?php echo $row_rsppereqheader[manmname]; ?> <?php echo $row_rsppereqheader[manlname]; ?></td>
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsppereqheader[req_sign_date]); ?></td>
      
      <td align="center">
	  <?php
      	$passedby = $row_rsppereqheader['passed_by'];
	  	mysql_select_db($database_core, $core);
		$query_rspassname = "SELECT h_employee.firstname AS passfname, h_employee.midlename AS passmname, h_employee.lastname AS passlname FROM h_employee WHERE h_employee.id = '$passedby'";
		$rspassname = mysql_query($query_rspassname, $core) or die(mysql_error());
		$row_rspassname = mysql_fetch_assoc($rspassname);
		$totalRows_rspassname = mysql_num_rows($rspassname);
		
		echo $row_rspassname[passfname]; ?> <?php echo $row_rspassname[passmname]; ?> <?php echo $row_rspassname[passlname];
	?>
      </td>
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsppereqheader[securitydate]); ?></td>
      
      <td align="center">
		<?php
		$distribby = $row_rsppereqheader['distrib_by'];
	  	mysql_select_db($database_core, $core);
		$query_rsdistribname = "SELECT h_employee.firstname AS distribfname, h_employee.midlename AS distribmname, h_employee.lastname AS distriblname FROM h_employee WHERE h_employee.id = '$distribby'";
		$rsdistribname = mysql_query($query_rsdistribname, $core) or die(mysql_error());
		$row_rsdistribname = mysql_fetch_assoc($rsdistribname);
		$totalRows_rsdistribname = mysql_num_rows($rsdistribname);
		
		echo $row_rsdistribname[distribfname]; ?> <?php echo $row_rsdistribname[distribmname]; ?> <?php echo $row_rsdistribname[distriblname]; ?>
      </td>
      
      <td width="80" align="center"><?php echo functddmmmyyyy($row_rsppereqheader[distrib_date]); ?></td>
      <td align="center"><a href="ppereq_editheader.php?data=<?php echo $row_rsppereqheader['id']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_rsppereqheader = mysql_fetch_assoc($rsppereqheader)); ?>
 </tbody>
</table>
</body>
</html>
<?php
	mysql_free_result($rsppereqheader);
	mysql_free_result($rspassname);
	mysql_free_result($rsdistribname);
?>