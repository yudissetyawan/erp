<?php require_once('../Connections/core.php'); ?>
<?php
//initialize the session
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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_core, $core);
$query_rsdocform = "SELECT d_sop.id, d_sop.id_dept, d_sop.doc_no, d_sop.rev, d_sop.efect_date, d_sop.title, d_sop.dsop_note, d_sop.retention_time, dms.idms, dms.fileupload, h_department.id, h_department.department, h_department.urutan FROM d_sop, dms, h_department WHERE h_department.id=d_sop.id_dept  AND d_sop.id=dms.idms AND dms.id_departemen=d_sop.id_dept AND dms.inisial_pekerjaan='form' ORDER BY h_department.urutan ASC";
$rsdocform = mysql_query($query_rsdocform, $core) or die(mysql_error());
$row_rsdocform = mysql_fetch_assoc($rsdocform);
$totalRows_rsdocform = mysql_num_rows($rsdocform);
$query_rsdocform = "SELECT d_sop.id, d_sop.id_dept, d_sop.doc_no, d_sop.rev, d_sop.efect_date, d_sop.title, d_sop.dsop_note, d_sop.retention_time, dms.idms, dms.fileupload, h_department.id, h_department.department, h_department.urutan FROM d_sop, dms, h_department WHERE h_department.id=d_sop.id_dept  AND d_sop.id=dms.idms AND dms.id_departemen=d_sop.id_dept AND dms.inisial_pekerjaan='form' ORDER BY h_department.urutan ASC";
$rsdocform = mysql_query($query_rsdocform, $core) or die(mysql_error());
$row_rsdocform = mysql_fetch_assoc($rsdocform);
$totalRows_rsdocform = mysql_num_rows($rsdocform);

$queryString_rsdocform = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsdocform") == false && 
        stristr($param, "totalRows_rsdocform") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsdocform = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsdocform = sprintf("&totalRows_rsdocform=%d%s", $totalRows_rsdocform, $queryString_rsdocform);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Form</title>
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

<body>

<?php
if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'dcc')) { // || ($_SESSION['userlvl'] == 'branchmanager')
?>
<p><a href="#" onclick="MM_openBrWindow('inputselection.php','','width=800,height=520')" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Form</a></p>
<?php } ?>

<table width="100%" border="0" class="table" id="celebs" >
  <thead>
    <tr class="tabel_header" height="40">
      <td width="30">No.</td>
      <td width="110">Department</td>
      <td width="80">Document No.</td>
      <td width="40">Rev.</td>
      <td width="350">Title</td>
      <td>Efektif Data</td>
      <td width="100">Retention<br />Time</td>
      <td width="70">Remark</td>
      <?php
if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'dcc')) { // || ($_SESSION['userlvl'] == 'branchmanager') 
?>
    <td width="70">&nbsp;</td>
    <?php } ?>
    </tr>
</thead>
<tbody>    
<?php
  { require_once "../dateformat_funct.php"; }
   do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td><?php echo $row_rsdocform['department']; ?></td>
      <td align="center"><?php echo $row_rsdocform['doc_no']; ?></td>
      <td align="center"><?php echo $row_rsdocform['rev']; ?></td>
      <td><a href="../dcc/upload/<?php echo $row_rsdocform['fileupload']; ?>" target="_blank"><?php echo $row_rsdocform['title']; ?></a></td>
      <td align="center"><?php echo functddmmyyyy($row_rsdocform['efect_date']); ?></td>
      <td align="center"><?php echo $row_rsdocform['retention_time']; ?></td>
      <td align="center"><?php echo $row_rsdocform['dsop_note']; ?></td>
      <?php
if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'dcc')) { // || ($_SESSION['userlvl'] == 'branchmanager') 
?>
      <td align="center"><a href="#" onclick="MM_openBrWindow('editForm.php?data=<?php echo $row_rsdocform['doc_no']; ?>','','scrollbars=yes,resizable=yes,width=520,height=480')">Edit</a> | <a href="#">Delete</a></td>
      <?php } ?>
    </tr>
<?php } while ($row_rsdocform = mysql_fetch_assoc($rsdocform)); ?>
</tbody>
</table>
</body>
</html>
<?php
mysql_free_result($rsdocform);
?>
