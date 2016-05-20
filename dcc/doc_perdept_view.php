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
$usrlevel = $_SESSION['userlvl'];

if (isset($_GET['vcat'])) { 
	$vcatg = $_GET['vcat'];
	
	if (($usrlevel == 'hrd') && ($vcatg == 'qo')) {
		$s_where = "h_department.userlevel = 'hrd' AND d_orgdoc_catg.initial_catg = 'QO' AND";
	} else if (($usrlevel == 'hrd') && ($vcatg == 'adt')) {
		$s_where = "h_department.userlevel = 'hrd' AND d_orgdoc_catg.initial_catg = 'IAR' AND";
	} else if (($usrlevel == 'hrd') && ($vcatg == 'org')) {
		$s_where = "d_orgdoc_catg.initial_catg <> 'QO' AND d_orgdoc_catg.initial_catg <> 'IAR' AND";
		$s_where_catg = "WHERE d_orgdoc_catg.initial_catg <> 'QO' AND d_orgdoc_catg.initial_catg <> 'IAR'";
	}
	
	else if (($usrlevel <> 'hrd') && ($vcatg == 'qo')) {
		$s_where = "h_department.userlevel = '$usrlevel' AND d_orgdoc_catg.initial_catg = 'QO' AND";
	} else if (($usrlevel <> 'hrd') && ($vcatg == 'adt')) {
		$s_where = "h_department.userlevel = '$usrlevel' AND d_orgdoc_catg.initial_catg = 'IAR' AND";
	} else if (($usrlevel <> 'hrd') && ($vcatg == 'org')) {
		$s_where = "h_department.userlevel = '$usrlevel' AND d_orgdoc_catg.initial_catg <> 'QO' AND d_orgdoc_catg.initial_catg <> 'IAR' AND";
		$s_where_catg = "WHERE d_orgdoc_catg.initial_catg <> 'QO' AND d_orgdoc_catg.initial_catg <> 'IAR'";
	}
	
} else {
	$s_where = '';
	$s_where_catg = '';
}

/* if (($usrlevel == 'administrator') || ($usrlevel == 'branchmanager') || ($usrlevel == 'hrd')) {
	$s_where = '';
} else if ($usrlevel == 'hrd') {
	$s_where = "d_orgdoc_catg.initial_catg <> 'QO' AND d_orgdoc_catg.initial_catg <> 'IAR' AND";
} else {
	$s_where = "h_department.userlevel = '$usrlevel' AND";
} */

mysql_select_db($database_core, $core);
if ($_GET['cmbxdoccatg'] != "") {
	$cmbcatg = $_GET['cmbxdoccatg'];
	$query_rsxdoc = "SELECT d_org_chart.*, d_orgdoc_catg.doccatg_name, h_department.department, h_department.urutan, dms.id AS id_dms, dms.fileupload FROM d_org_chart, d_orgdoc_catg, h_department, dms
		WHERE
		d_org_chart.id_doccatg = d_orgdoc_catg.id_doccatg AND
		d_org_chart.id_dept = h_department.id AND
		dms.idms = d_org_chart.id AND
		dms.inisial_pekerjaan = 'DDOC' AND
		$s_where
		d_org_chart.active = 1 AND
		d_orgdoc_catg.id_doccatg = '$cmbcatg'
		ORDER BY h_department.urutan, d_orgdoc_catg.id_doccatg, d_org_chart.doc_no ASC";
} else {
	$query_rsxdoc = "SELECT d_org_chart.*, d_orgdoc_catg.doccatg_name, h_department.department, h_department.urutan, dms.id AS id_dms, dms.fileupload FROM d_org_chart, d_orgdoc_catg, h_department, dms
		WHERE
		d_org_chart.id_doccatg = d_orgdoc_catg.id_doccatg AND
		d_org_chart.id_dept = h_department.id AND
		dms.idms = d_org_chart.id AND
		dms.inisial_pekerjaan = 'DDOC' AND
		$s_where
		d_org_chart.active = 1
		ORDER BY h_department.urutan, d_orgdoc_catg.id_doccatg, d_org_chart.doc_no ASC";

/* $query_rsxdoc = "SELECT d_org_chart.*, d_orgdoc_catg.doccatg_name, d_orgdoc_catg.initial_catg, h_department.department, h_department.urutan, dms.id AS id_dms, dms.fileupload FROM d_org_chart, d_orgdoc_catg, h_department, dms
		WHERE
		d_org_chart.id_doccatg = d_orgdoc_catg.id_doccatg AND
		d_org_chart.id_dept = h_department.id AND
		dms.idms = d_org_chart.id AND
		dms.inisial_pekerjaan = d_orgdoc_catg.initial_catg AND
		d_org_chart.active = 1
		ORDER BY h_department.urutan ASC"; */
}
$rsxdoc = mysql_query($query_rsxdoc, $core) or die(mysql_error());
$row_rsxdoc = mysql_fetch_assoc($rsxdoc);
$totalRows_rsxdoc = mysql_num_rows($rsxdoc);

if (isset($_GET['cmbxdoccatg'])) {
	$catg = $_GET['cmbxdoccatg'];
	mysql_select_db($database_core, $core);
	$query_rsdoccatg1 = "SELECT id_doccatg, doccatg_name FROM d_orgdoc_catg WHERE id_doccatg = '$catg'";
	$rsdoccatg1 = mysql_query($query_rsdoccatg1, $core) or die(mysql_error());
	$row_rsdoccatg1 = mysql_fetch_assoc($rsdoccatg1);
	$totalRows_rsdoccatg1 = mysql_num_rows($rsdoccatg1);

if ($_GET['cmbxdoccatg'] != "") {
		$tekscatg = "Category : ".$row_rsdoccatg1['doccatg_name'];
	}
}

mysql_select_db($database_core, $core);
$query_rsdoccatg = "SELECT id_doccatg, doccatg_name FROM d_orgdoc_catg $s_where_catg";
$rsdoccatg = mysql_query($query_rsdoccatg, $core) or die(mysql_error());
$row_rsdoccatg = mysql_fetch_assoc($rsdoccatg);
$totalRows_rsdoccatg = mysql_num_rows($rsdoccatg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Organization Document</title>
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

<?php if (($_GET['vcat'] != 'qo') && ($_GET['vcat'] != 'adt')) { ?>
<form method="get" action="" name="xdoc_view.php">
	<b>Category &nbsp;&nbsp; : &nbsp;&nbsp;</b>
	<select id="cmbxdoccatg" name="cmbxdoccatg" class="General">
    <option value="">All</option>
	  <?php
	do {  
	?>
	  <option value="<?php echo $row_rsdoccatg['id_doccatg']?>"><?php echo $row_rsdoccatg['doccatg_name']?></option>
	  <?php
	} while ($row_rsdoccatg = mysql_fetch_assoc($rsdoccatg));
	  $rows = mysql_num_rows($rsdoccatg);
	  if($rows > 0) {
		  mysql_data_seek($rsdoccatg, 0);
		  $row_rsdoccatg = mysql_fetch_assoc($rsdoccatg);
	  }
	?>
	</select>
  <input type="submit" value="Go" style="cursor:pointer" class="General" />
</form>
<?php } ?>

	<table width="100%" border="0" class="General">
		<tr>
		<td colspan="31" align="center"><h3>Department Document</h3></td>
	  </tr>
	  <tr>
		<td colspan="31" align="center"><b><?php echo $tekscatg; ?></b></td>
	  </tr>
	</table>
	
<?php
	if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager'))  ?>
<p><a href="#" onclick="MM_openBrWindow('doc_perdept_input.php?data=<?php echo $row_rsdoccatg1['id_doccatg']; ?>','','width=650,height=450')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Document</a></p>
<?php } ?>
    
<table width="100%" class="table" id="celebs">
	  <thead>
      <tr class="tabel_header" height="40">
		<td width="30">No.</td>
		<td width="105">Department</td>
		<td width="140">Document No.</td>
		<td width="35">Rev.</td>
		<td width="250">Title of Document</td>
		<td width="150">Category</td>
		<td width="80">Date</td>
		<td>Remark</td>
     <?php if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
		<td width="60">Edit | Delete</td>
     <?php } ?>
	  </tr>
  </thead>
  <tbody> 
    <?php
	{ require_once "../dateformat_funct.php"; }
    do { 
    
    	if ($row_rsxdoc['fileupload'] == "") {
			$f_italic = 'style="font-style:italic"'; 
		} else {
			$f_italic = "";
		} ?>
    
		<tr class="tabel_body" onclick="this.style.fontWeight='bold';" ondblclick="this.style.fontWeight='normal';" title="Once click data for 'highlight', and double click to remove highlight" <?php echo $f_italic; ?>>
		  <td align="center"><?php $a = $a + 1; echo $a; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['department']; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['doc_no']; ?></td>
		  <td align="center"><?php echo $row_rsxdoc['rev']; ?></td>
		  <td><a href=upload_deptdoc/<?php echo $row_rsxdoc['fileupload']; ?> target="_blank"><?php echo $row_rsxdoc['title']; ?></a></td>
		  <td align="center"><?php echo $row_rsxdoc['doccatg_name']; ?></td>
		  <td align="center"><?php echo functddmmmyyyy($row_rsxdoc['date']); ?></td>
		  <td><?php echo $row_rsxdoc['remark']; ?></td>
		
		<?php if ($_SESSION['userlvl'] == 'administrator') { // || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
          <td align="center">
			<a href="#" onclick="MM_openBrWindow('doc_perdept_edit.php?data=<?php echo $row_rsxdoc['id']; ?>','','scrollbars=yes,resizable=yes,width=570,height=520')" title="Edit Data"><img src="images/icedit.png" width="15" height="15"></a>
            &nbsp;
          	<a href="doc_perdept_del.php?data=<?php echo $row_rsxdoc['id']; ?>" onclick="return confirm('Delete Document No. <?php echo $row_rsxdoc['title']; ?> ?')" title="Delete Data"><img src="images/icdel.png" width="15" height="15"></a>
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
	mysql_free_result($rsdoccatg);
	mysql_free_result($rsdoccatg1);
?>