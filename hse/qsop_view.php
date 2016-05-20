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
if ($_GET['cmbplatform'] != "") {
	$cmbcatg = $_GET['cmbplatform'];
	$query_rsqsop = "SELECT s_qsop.*, f_site_platform.PlatformName FROM s_qsop, f_site_platform WHERE f_site_platform.PlatformID = s_qsop.loc_orplatform AND f_site_platform.PlatformID = '$cmbcatg'";
} else {
	$query_rsqsop = "SELECT s_qsop.*, f_site_platform.PlatformName FROM s_qsop, f_site_platform WHERE f_site_platform.PlatformID = s_qsop.loc_orplatform";
}
$rsqsop = mysql_query($query_rsqsop, $core) or die(mysql_error());
$row_rsqsop = mysql_fetch_assoc($rsqsop);
$totalRows_rsqsop = mysql_num_rows($rsqsop);

if (isset($_GET['cmbplatform'])) {
	$catg = $_GET['cmbplatform'];
	mysql_select_db($database_core, $core);
	$query_rsplatform1 = "SELECT f_site_platform.PlatformID, f_site_platform.AreaID, f_site_platform.PlatformName, f_site_platform.PlatformCode FROM f_site_platform WHERE id = '$catg'";
	$rsplatform1 = mysql_query($query_rsplatform1, $core) or die(mysql_error());
	$row_rsplatform1 = mysql_fetch_assoc($rsplatform1);
	$totalRows_rsplatform1 = mysql_num_rows($rsplatform1);
	
	if ($_GET['cmbplatform'] != "") {
		$tekscatg = "Category : ".$row_rsplatform1['PlatformName']."  (".$row_rsplatform1['PlatformCode'].")";
	}
}

mysql_select_db($database_core, $core);
$query_rsplatform = "SELECT f_site_platform.PlatformID, f_site_platform.AreaID, f_site_platform.PlatformName, f_site_platform.PlatformCode FROM f_site_platform WHERE f_site_platform.HasQSOP = 1";
$rsplatform = mysql_query($query_rsplatform, $core) or die(mysql_error());
$row_rsplatform = mysql_fetch_assoc($rsplatform);
$totalRows_rsplatform = mysql_num_rows($rsplatform);

mysql_select_db($database_core, $core);
$query_rsarea = "SELECT f_site.id, f_site.kode_lokasi, f_site.AreaName, f_site.lokasi FROM f_site";
$rsarea = mysql_query($query_rsarea, $core) or die(mysql_error());
$row_rsarea = mysql_fetch_assoc($rsarea);
$totalRows_rsarea = mysql_num_rows($rsarea);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>External Document</title>
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

<?php if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
    <!-- **************************************************** -->
    <!-- ------------------ COMBOBOX AREA ------------------- -->
    <!-- **************************************************** -->
	<b>Area &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp;&nbsp;</b>
	<select id="cmbarea" name="cmbarea" class="General">
    	<option value="">All</option>
	<?php
	do {  ?>
	  <option value="<?php echo $row_rsarea['id']; ?>"><?php echo $row_rsarea['AreaName']; ?></option>
	  <?php
	} while ($row_rsarea = mysql_fetch_assoc($rsarea));
	  $rows = mysql_num_rows($rsarea);
	  if($rows > 0) {
		  mysql_data_seek($rsarea, 0);
		  $row_rsarea = mysql_fetch_assoc($rsarea);
	}
	?>
    </select>
<?php } ?>

<form method="get" action="" name="qsop_view.php">

    <!-- **************************************************** -->
    <!-- ---------------- COMBOBOX PLATFORM ----------------- -->
    <!-- **************************************************** -->
	<b>Platform &nbsp;&nbsp; : &nbsp;&nbsp;</b>
  <select id="cmbplatform" name="cmbplatform" class="General">
		<option value="">All</option>
    <?php 
	do {  ?>
    <option value="<?php echo $row_rsplatform['PlatformID']; ?>"><?php echo $row_rsplatform['PlatformName']; ?></option>
	  <?php
	} while ($row_rsplatform = mysql_fetch_assoc($rsplatform));
	  $rows = mysql_num_rows($rsplatform);
	  if($rows > 0) {
		  mysql_data_seek($rsplatform, 0);
		  $row_rsplatform = mysql_fetch_assoc($rsplatform);
	  }
	?>
  </select>
  
  <input type="submit" value="Go" style="cursor:pointer" class="General" />
</form>



	<table width="100%" border="0" class="General">
		<tr>
		<td colspan="31" align="center"><h3>Standard Operating Procedure (SOP) - Project</h3></td>
	  </tr>
	  <tr>
		<td colspan="31" align="center"><b><?php echo $tekscatg; ?></b></td>
	  </tr>
	</table>
	
<?php
	if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
<p><a href="#" onclick="MM_openBrWindow('qsop_input.php?data=<?php echo $row_rsplatform1['id']; ?>','','width=600,height=600')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Document</a></p>
<?php } ?>
    
<table width="1600" class="table" id="celebs">
	  <thead>
      <tr class="tabel_header" height="40">
		<td width="30">No.</td>
		<td width="90">Location <br /> (Platform Name, or etc)</td>
		<td width="120">Project Name</td>
		<td width="150">SOP No.</td>
		<td width="150">PPHA No.</td>
		<td width="350">Title of Document</td>
		<td width="70">Draft Issued</td>
		<td width="70">Sent Draft to USER</td>
		<td width="70">Review on</td>
		<td width="70">Sent Final Workshop to USER</td>
		<td width="70">Revision <br /> Add Comment</td>
		<td width="70">Approved by Chevron</td>
		<td width="70">Socialized by Bukaka</td>
        <td>Remark</td>
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
		  <td align="center"><?php echo $row_rsqsop['PlatformName']; ?></td>
		  <td><?php echo $row_rsqsop['project_name']; ?></td>
		  <td><?php echo $row_rsqsop['qsop_no']; ?></td>
		  <td><?php echo $row_rsqsop['ppha_no']; ?></td>
		  <td><?php echo $row_rsqsop['qsop_title']; ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['draft_issued']); ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['sentdraft_tocvx']); ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['review_on']); ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['sentfinal_tocvx']); ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['rev_addcomment']); ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['apprv_bycvx']); ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsqsop['soclz_bybkk']); ?></td>
          <td><?php echo $row_rsqsop['remark']; ?></td>
		
		<?php if ($_SESSION['userlvl'] == 'administrator') { ?>
        
          <td align="center">
          	<a href="#" onclick="MM_openBrWindow('qsop_edit.php?data=<?php echo $row_rsqsop['qsop_id']; ?>','','scrollbars=yes,resizable=yes,width=600,height=650')" title="Edit Data"><img src="../dcc/images/icedit.png" width="15" height="15"></a>
          &nbsp;
          	<a href="qsop_del.php?data=<?php echo $row_rsqsop['qsop_id']; ?>" onclick="return confirm('Delete Document No. <?php echo $row_rsqsop['qsop_no']; ?> ?')"><img src="../dcc/images/icdel.png" width="15" height="15"></a>
          </td>
       	<?php } ?>
        
	    </tr>
    <?php } while ($row_rsqsop = mysql_fetch_assoc($rsqsop)); ?>
      </tbody>
	</table>
    
</body>
</html>
<?php
	mysql_free_result($rsplatform);
mysql_free_result($rsarea);
mysql_free_result($rsqsop);
	mysql_free_result($rsplatform1);
?>