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
if ($_GET['cmbxdoccatg'] != "") {
	$cmbcatg = $_GET['cmbxdoccatg'];
	$query_rsxdoc = "SELECT d_xdoc.*, d_xdoc_catg.xcatg_descr, dms.id AS id_dms, dms.fileupload FROM d_xdoc, d_xdoc_catg, dms WHERE d_xdoc.id_xdoc_catg = d_xdoc_catg.id AND dms.idms = d_xdoc.id AND dms.inisial_pekerjaan = 'XDOC' AND d_xdoc.xdoc_active = '1' AND d_xdoc_catg.id = '$cmbcatg' ORDER BY d_xdoc_catg.xcatg_descr, d_xdoc.issued_by DESC";
} else {
	$query_rsxdoc = "SELECT d_xdoc.*, d_xdoc_catg.xcatg_descr, dms.id AS id_dms, dms.fileupload FROM d_xdoc, d_xdoc_catg, dms WHERE d_xdoc.id_xdoc_catg = d_xdoc_catg.id AND dms.idms = d_xdoc.id AND dms.inisial_pekerjaan = 'XDOC' AND d_xdoc.xdoc_active = '1' ORDER BY d_xdoc_catg.xcatg_descr, d_xdoc.issued_by DESC";
}
$rsxdoc = mysql_query($query_rsxdoc, $core) or die(mysql_error());
$row_rsxdoc = mysql_fetch_assoc($rsxdoc);
$totalRows_rsxdoc = mysql_num_rows($rsxdoc);

if (isset($_GET['cmbxdoccatg'])) {
	$catg = $_GET['cmbxdoccatg'];
	mysql_select_db($database_core, $core);
	$query_rsxdoccatg1 = "SELECT * FROM d_xdoc_catg WHERE id = '$catg'";
	$rsxdoccatg1 = mysql_query($query_rsxdoccatg1, $core) or die(mysql_error());
	$row_rsxdoccatg1 = mysql_fetch_assoc($rsxdoccatg1);
	$totalRows_rsxdoccatg1 = mysql_num_rows($rsxdoccatg1);
	
	if ($_GET['cmbxdoccatg'] != "") {
		$tekscatg = "Category : ".$row_rsxdoccatg1['xcatg_descr'];
	}
}

mysql_select_db($database_core, $core);
$query_rsxdoccatg = "SELECT * FROM d_xdoc_catg";
$rsxdoccatg = mysql_query($query_rsxdoccatg, $core) or die(mysql_error());
$row_rsxdoccatg = mysql_fetch_assoc($rsxdoccatg);
$totalRows_rsxdoccatg = mysql_num_rows($rsxdoccatg);
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
<form method="get" action="" name="xdoc_view.php">
	<b>Category &nbsp;&nbsp; : &nbsp;&nbsp;</b>
	<select id="cmbxdoccatg" name="cmbxdoccatg" class="General">
    <option value="">All</option>
	  <?php
	do {  
	?>
	  <option value="<?php echo $row_rsxdoccatg['id']?>"><?php echo $row_rsxdoccatg['xcatg_descr']?></option>
	  <?php
	} while ($row_rsxdoccatg = mysql_fetch_assoc($rsxdoccatg));
	  $rows = mysql_num_rows($rsxdoccatg);
	  if($rows > 0) {
		  mysql_data_seek($rsxdoccatg, 0);
		  $row_rsxdoccatg = mysql_fetch_assoc($rsxdoccatg);
	  }
	?>
	</select>
  <input type="submit" value="Go" style="cursor:pointer" class="General" />
</form>

	<table width="100%" border="0" class="General">
		<tr>
		<td colspan="31" align="center"><h3>External Document</h3></td>
	  </tr>
	  <tr>
		<td colspan="31" align="center"><b><?php echo $tekscatg; ?></b></td>
	  </tr>
	</table>
	
<?php
	if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
<p><a href="#" onclick="MM_openBrWindow('xdoc_input.php?data=<?php echo $row_rsxdoccatg1['id']; ?>','','width=620,height=520')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Document</a></p>
<?php } ?>
    
<table width="100%" class="table" id="celebs">
	  <thead>
      <tr class="tabel_header" height="40">
		<td width="30">No.</td>
		<td width="50">Doc. Code</td>
		<td width="105">Document No.</td>
		<td width="30">Rev.</td>
		<td width="50">Year<br />of<br />Edition</td>
		<td width="180">Title of Document</td>
		<td width="120">Issued by</td>
		<td width="50">Location<br />(Dept.)</td>
		<td width="40">Rack<br />Code</td>
		<td width="120">Category</td>
		<td width="70">Effective<br />Date</td>
        <td>Remark</td>
     <?php if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
		<td width="50">Edit | Delete</td>
     <?php } ?>
	  </tr>
  </thead>
  <tbody> 
    <?php
	{ require_once "../dateformat_funct.php"; }
    do { ?>
		<tr class="tabel_body">
		  <td align="center"><?php $a = $a + 1; echo $a; ?></td>
		  <td align="center"><?php echo $row_rsxdoc[xdoc_code]; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['xdoc_no']; ?></td>
		  <td align="center"><?php echo $row_rsxdoc[xdoc_rev]; ?></td>
		  <td align="center"><?php echo $row_rsxdoc[edition_year]; ?></td>
		  <td><a href=upload_xdoc/<?php echo $row_rsxdoc['fileupload']; ?> target="_blank"><?php echo $row_rsxdoc['xdoc_title']; ?></a></td>
		  <td><?php echo $row_rsxdoc['issued_by']; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['loc_dept']; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['loc_rackcode']; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['xcatg_descr']; ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsxdoc['effective_date']); ?></td>
          <td><?php echo $row_rsxdoc['note']; ?></td>
		
		<?php if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
          <td align="center" valign="middle">
          	<a href="#" onclick="MM_openBrWindow('xdoc_edit.php?data=<?php echo $row_rsxdoc['id']; ?>','','scrollbars=yes,resizable=yes,width=625,height=650')" title="Edit Data"><img src="images/icedit.png" width="15" height="15"></a>
            &nbsp;
          	<a href="xdoc_del.php?data=<?php echo $row_rsxdoc['id']; ?>" onclick="return confirm('Delete Document No. <?php echo $row_rsxdoc['xdoc_no']; ?> ?')" title="Delete Data"><img src="images/icdel.png" width="15" height="15"></a>
          </td>
       	<?php } ?>
        
	    </tr>
    <?php } while ($row_rsxdoc = mysql_fetch_assoc($rsxdoc)); ?>
      </tbody>
	</table>
    
</body>
</html>
<?php
	mysql_free_result($rsxdoc);
	mysql_free_result($rsxdoccatg);
	mysql_free_result($rsxdoccatg1);
?>