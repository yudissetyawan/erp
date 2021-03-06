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

$idsubcatg = $_GET['data'];
//$vidmcatg = $_GET['data1'];
//$vidmod = $_GET['data2'];
//$query_rsitem = "SELECT m_master_2.* FROM m_master_2 WHERE m_master_2.id_mcatg = '1' AND m_master_2.id_mmodel = m_e_model.id_mmodel AND m_master_2.id_mmodel = '$vidmod'";

//$query_rsitem = "SELECT m_master.*, m_unit.unit, m_status.m_status, m_e_model.mtrl_model FROM m_master, m_unit, m_status, m_e_model WHERE m_master.id_unit = m_unit.id_unit AND  m_master.id_mstat = m_status.id_mstat AND m_e_model.id_mmodel = m_master.id_mmodel AND m_e_model.id_subcatg = '$idsubcatg' AND m_master.s_active = '1' AND m_status.stat_active = '1'";

mysql_select_db($database_core, $core);
$query_rsitem = "SELECT m_master.*, m_unit.unit, m_e_model.mtrl_model, m_master_catg.mcatg_descr, m_master_subcatg.msubcatg_descr, m_masterndstatus.id_mr, m_masterndstatus.id_bpb, m_masterndstatus.id_mstat, p_mr_header.nomr, m_status.m_status, m_masterndstatus.note_status FROM m_master, m_unit, m_e_model, m_master_subcatg, m_master_catg, m_masterndstatus, m_status, p_mr_header WHERE m_master.id_unit = m_unit.id_unit AND m_e_model.id_mmodel = m_master.id_mmodel AND m_e_model.id_subcatg = m_master_subcatg.id_msubcatg AND m_master_catg.id_mcatg = m_master_subcatg.id_mcatg AND m_master.s_active = '1' AND m_masterndstatus.id_item = m_master.id_item AND m_masterndstatus.id_mstat = m_status.id_mstat AND p_mr_header.id = m_masterndstatus.id_mr ORDER BY m_master.id_item";
$rsitem = mysql_query($query_rsitem, $core) or die(mysql_error());
$row_rsitem = mysql_fetch_assoc($rsitem);
$totalRows_rsitem = mysql_num_rows($rsitem);

$vusr = $row_rsitem['updated_by'];
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
<title>List of Items</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
<table width="1500" class="table" id="celebs">
<thead>
  <tr class="tabel_header" height="40">
  	<td width="10" class="tabel_header">No.</td>
    <td width="70" class="tabel_header">Item ID</td>
    <td class="tabel_header">Name of Item</td>
    <td class="tabel_header">Descr.</td>
    <td class="tabel_header">Spec.</td>
    <td class="tabel_header" title="Bahan">Material</td>
    <td width="60" class="tabel_header">Brand</td>
    <td class="tabel_header">Unit</td>
    <td width="60" class="tabel_header">Status</td>
    <td width="120" class="tabel_header">MR No.</td>
    <td width="120" class="tabel_header">BPB No.</td>
    <td class="tabel_header">Remark</td>
    <td>Category</td>
    <td>SubCategory</td>
    <!--
    <td class="tabel_header"><i>Last Updated</i></td>
    <td class="tabel_header"><i>Updated By</i></td>
    -->
    <?php // if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager')) { echo '<td class="tabel_header">&nbsp;</td>'; } ?>
  </tr>
</thead>
<tbody>  
  <?php
  do {
	$i = $i + 1; ?>
    <tr class="tabel_body" onclick="this.style.fontWeight='bold';" ondblclick="this.style.fontWeight='normal';" title="click data for 'highlight', and Double click to remove highlight">
    	<td align="center"><?php echo $i; ?></td>
      <td align="center"><?php echo $row_rsitem[item_code]; ?></td>
      <td><?php echo $row_rsitem[mtrl_model]; ?></td>
      <td><?php echo $row_rsitem['descr_name']; ?></td>
      <td><?php echo $row_rsitem['id_mstd']; ?> <?php echo $row_rsitem['descr_spec']; ?></td>
      <td><?php echo $row_rsitem['id_type']; ?></td>
      <td><?php echo $row_rsitem['brand']; ?></td>
      <td align="center"><?php echo $row_rsitem[unit]; ?></td>
      <td align="center"><?php echo $row_rsitem['m_status']; ?></td>
      <td align="center"><?php echo $row_rsitem['nomr']; ?></td>
      <td align="center">-</td>
      <td align="center"><?php echo $row_rsitem['note_status']; ?></td>
      <td><?php echo $row_rsitem['mcatg_descr']; ?></td>
      <td><?php echo $row_rsitem[msubcatg_descr]; ?></td>
      
      <!--
      <td align="center"><i><?php /* echo functddmmmyyyy($row_rsitem['last_updated']); ?></i></td>
      <td align="center"><i><?php echo $row_rsusr[fname]; ?> <?php echo $row_rsusr[mname]; ?> <?php echo $row_rsusr[lname]; ?></i></td>
      <?php
		if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
          <td align="center">
            <a href="edit_item.php?data=<?php echo $row_rsitem['id_item']; ?>">Edit</a> | <a href="delete_item.php?data=<?php echo $row_rsitem['id_item']; ?>" onclick="return confirm('Delete <?php echo $row_rsitem['mtrl_model']; ?> <?php echo $row_rsitem['descr_name']; ?> , Item ID : <?php echo $row_rsitem['item_code']; ?> ?')">Delete</a>       
          </td>
       
      <?php } */ ?>
      -->
      
    </tr>
    <?php } while ($row_rsitem = mysql_fetch_assoc($rsitem)); ?>
</tbody>    
</table>

<a href="viewstat_mr.php">MR</a>

</body>
</html>
<?php
mysql_free_result($rsitem);
?>