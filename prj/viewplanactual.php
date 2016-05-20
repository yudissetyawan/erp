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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT pr_wpr_corecomulative.id, pr_wpr_corecomulative.id_headerwpr, pr_wpr_corecomulative.id_jenis, pr_wpr_corecomulative.tanggal, pr_wpr_corecomulative.eng_services, pr_wpr_corecomulative.proj_services, pr_wpr_corecomulative.material_civ, pr_wpr_corecomulative.material_pip, pr_wpr_corecomulative.material_elect, pr_wpr_corecomulative.fab_act, pr_wpr_corecomulative.painting, pr_wpr_corecomulative.ndt, pr_wpr_corecomulative.inst_civ, pr_wpr_corecomulative.inst_pip, pr_wpr_corecomulative.inst_elect, pr_wpr_corecomulative.pers_dayrate, pr_wpr_corecomulative.equipt_dayrate, pr_wpr_corecomulative.landtransport, pr_jenis.id, pr_jenis.jenis, pr_wpr_tanggal.id, pr_wpr_tanggal.tanggal FROM pr_wpr_corecomulative, pr_jenis, pr_wpr_tanggal WHERE pr_wpr_corecomulative.id_headerwpr = %s AND pr_wpr_corecomulative.id_jenis=pr_jenis.id AND pr_wpr_tanggal.id=pr_wpr_corecomulative.tanggal", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM pr_weightfactor WHERE id_wpr_header = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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

<body>
<div class="container">
      <table width="1579" border="0" class="table" id="celebs">
      <thead>
        <tr class="tabel_header">
          <td width="30" rowspan="2">No</td>
          <td width="110" rowspan="2">Plan/Actual</td>
          <td width="106" rowspan="2">Tanggal</td>
          <td width="69">Engineering Services </td>
          <td width="55">Project Services </td>
          <td width="110">Material For Civil &amp; Structure</td>
          <td width="74">Material For Piping</td>
          <td width="131">Material For Electrical &amp; Instrument</td>
          <td width="71">Fabrication Activities</td>
          <td width="110">Painting &amp; Sand Blasting Activities</td>
          <td width="71">NDT </td>
          <td width="97">Installation For Civil &amp; Structure </td>
          <td width="82">Installation for Piping </td>
          <td width="136">Installation For Electrical &amp; Instrument </td>
          <td width="84">Personal Day Rate</td>
          <td width="91">Equipment Day Rate</td>
          <td width="82">Land Transportation </td>
        </tr>
        <tr class="tabel_header">
          <td><?php echo $row_Recordset2[wf_eng_services]; ?></td>
          <td width="55"><?php echo $row_Recordset2[wf_proj_services]; ?></td>
          <td width="110"><?php echo $row_Recordset2[wf_civ_structure]; ?></td>
          <td width="74"><?php echo $row_Recordset2[wf_piping]; ?></td>
          <td width="131"><?php echo $row_Recordset2[wf_electrical_inst]; ?></td>
          <td width="71"><?php echo $row_Recordset2[wf_fab_activities]; ?></td>
          <td width="110"><?php echo $row_Recordset2[wf_painting_sandblastactivities]; ?></td>
          <td width="71"><?php echo $row_Recordset2[wf_ndt]; ?></td>
          <td width="97"><?php echo $row_Recordset2[wf_inst_civil_structure]; ?></td>
          <td width="82"><?php echo $row_Recordset2[wf_inst_piping]; ?></td>
          <td width="136"><?php echo $row_Recordset2[wf_inst_electric_inst]; ?></td>
          <td width="84"><?php echo $row_Recordset2[wf_inst_electric_inst]; ?></td>
          <td width="91"><?php echo $row_Recordset2[wf_equip_dayrate]; ?></td>
          <td width="82"><?php echo $row_Recordset2[wf_land_transportation]; ?></td>
        </tr>
        </thead>
        <tbody>
        <?php do { ?>
          <tr class="tabel_body"><?php $a=$a+1 ?>
            <td><?php echo $a; ?></td>
            <td><?php echo $row_Recordset1[jenis]; ?></td>
            <td><?php echo $row_Recordset1[tanggal]; ?></td>
            <td><?php echo $row_Recordset1[eng_services]; ?> %</td>
            <td><?php echo $row_Recordset1[proj_services]; ?> %</td>
            <td><?php echo $row_Recordset1[material_civ]; ?> % </td>
            <td><?php echo $row_Recordset1[material_pip]; ?> % </td>
            <td><?php echo $row_Recordset1[material_elect]; ?> % </td>
            <td><?php echo $row_Recordset1[fab_act]; ?> % </td>
            <td><?php echo $row_Recordset1[painting]; ?> % </td>
            <td><?php echo $row_Recordset1[ndt]; ?> % </td>
            <td><?php echo $row_Recordset1[inst_civ]; ?> % </td>
            <td><?php echo $row_Recordset1[inst_pip]; ?> %</td>
            <td><?php echo $row_Recordset1[inst_elect]; ?> %</td>
            <td><?php echo $row_Recordset1[pers_dayrate]; ?> %</td>
            <td><?php echo $row_Recordset1[equipt_dayrate]; ?> % </td>
            <td><?php echo $row_Recordset1[landtransport]; ?> % </td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </tbody>
      </table>
</div>
	<p>
	  <input type="submit" name="back" id="back" value="Back" onclick="history.back(-1)" />
	</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
