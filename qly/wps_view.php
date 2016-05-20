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

$usrid = $_SESSION['empID'];

mysql_select_db($database_core, $core);
if ($_GET['cmbstdcode'] != "") {
	$cmbcatg = $_GET['cmbstdcode'];
	$query_rswps = "SELECT * FROM q_wps WHERE wps_std_code = '$cmbcatg'";
} else {
	$query_rswps = "SELECT * FROM q_wps";
}
$rswps = mysql_query($query_rswps, $core) or die(mysql_error());
$row_rswps = mysql_fetch_assoc($rswps);
$totalRows_rswps = mysql_num_rows($rswps);

if (isset($_GET['cmbstdcode'])) {
	$tekscatg = "WPS (Standard / Code : ".$_GET['cmbstdcode'].")";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welding Procedure Specification (WPS)</title>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

</head>

<body class="General">
<!--
<form method="get" action="" name="wps_view.php">

    <!-- **************************************************** -->
    <!-- ---------------- COMBOBOX STANDARD / CODE ----------------- -->
    <!-- **************************************************** 
	<b>Category of Standard&nbsp;&nbsp; : &nbsp;&nbsp;</b>
    <select id="wps_std" name="wps_std" class="General">
		<option value="">All</option>
    	<option value="API 1104">API 1104</option>
        <option value="ASME IX">ASME IX</option>
        <option value="AWS D1.1">AWS D1.1</option>
        <option value="BS EN">BS EN</option>
  </select>
  
  <input type="submit" value="Go" style="cursor:pointer" class="General" />
</form>
-->


<br /><br />
<?php
	if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
<p><a href="#" onclick="MM_openBrWindow('wps_input.php?data=<?php echo $_GET['cmbstdcode']; ?>','','width=600,height=600')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Document</a></p>
<?php } ?>
    
<table width="100%" class="table" id="celebs">
	  <thead>
      <tr class="tabel_header" height="40">
		<td width="30">No.</td>
		<td width="160">WPS No.</td>
		<td width="160">Supporting PQR No.</td>
		<td width="150">Standard / Code</td>
		<td width="40">Rev.</td>
		<td width="80">Date</td>
		<td width="100">Welding Process</td>
		<td width="80">Type</td>
		<td>Remark</td>
		<td width="40">PDF</td>
     <?php if ($_SESSION['userlvl'] == 'administrator') { ?>
		<td width="50">Edit | Delete</td>
     <?php } ?>
	  </tr>
  </thead>
  <tbody> 
    <?php
	{ require_once "../dateformat_funct.php"; }
    do { ?>
		<tr class="tabel_body" onclick="this.style.fontWeight='bold';" ondblclick="this.style.fontWeight='normal';" title="Once click data for 'highlight', and double click to remove highlight">
		  <td align="center"><?php $a = $a + 1; echo $a; ?></td>
		  <td><?php echo $row_rswps['wps_no']; ?></td>
		  <td><?php echo $row_rswps['supp_pqrno']; ?></td>
		  <td><?php echo $row_rswps['wps_std_code']; ?></td>
		  <td align="center"><?php echo $row_rswps['wps_rev']; ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rswps['wps_date']); ?></td>
		  <td><?php echo $row_rswps['welding_process']; ?></td>
		  <td><?php echo $row_rswps['welding_type']; ?></td>
		  <td><?php echo $row_rswps['wps_remark']; ?></td>
		  <td align="center"><a href="upload/wps/<?php echo $row_rswps['wps_attc_pdf']; ?>">View</a></td>
		
		<?php if ($_SESSION['userlvl'] == 'administrator') { ?>
        
          <td align="center">
          	<a href="#" onclick="MM_openBrWindow('qsop_edit.php?data=<?php echo $row_rswps['wps_id']; ?>','','scrollbars=yes,resizable=yes,width=600,height=650')" title="Edit Data"><img src="../dcc/images/icedit.png" width="15" height="15"></a>
          &nbsp;
          	<a href="wps_del.php?data=<?php echo $row_rswps['wps_id']; ?>" onclick="return confirm('Delete Document No. <?php echo $row_rsqsop['qsop_no']; ?> ?')"><img src="../dcc/images/icdel.png" width="15" height="15"></a>
          </td>
       	<?php } ?>
        
	    </tr>
    <?php } while ($row_rswps = mysql_fetch_assoc($rswps)); ?>
      </tbody>
	</table>
    
</body>
</html>
<?php
	mysql_free_result($rswps);
?>