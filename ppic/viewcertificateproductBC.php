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
$query_Recordset1 = "SELECT p_certificate_product.*, dms.idms, dms.id, dms.fileupload, h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM p_certificate_product, dms, h_employee WHERE p_certificate_product.id_category_product='9' AND dms.keterangan=p_certificate_product.name_of_equipment AND dms.id_departemen = 'QC'  AND p_certificate_product.id_certificate=dms.idms AND p_certificate_product.activeYN = '1' AND h_employee.id=p_certificate_product.issued_user";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Certificate of Beam Clamp</title>
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css" />

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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<style type="text/css">
	.table_codecolor {
		font-family: Tahoma, Geneva, sans-serif;
		font-size: 11px;
		text-align: center;
		color: #000;
		background-color:#79baec;
		font-weight: bold;
		border-top-width: medium;
		border-right-width: medium;
		border-bottom-width: medium;
		border-left-width: medium;
		border-top-style: none;
		border-right-style: none;
		border-bottom-style: none;
		border-left-style: none;
		vertical-align: middle;
	}
	
	.isi_tabel {
		font-family: Tahoma, Geneva, sans-serif;
		font-size: 11px;
		text-align: left;
		vertical-align: middle;
	}
</style>

</head>

<body>
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) {
		echo '<p><a href="inputcertificateproductBC.php?data=9" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item</a></p>';
	}
?>
<table width="1350" border="0" cellpadding="2" cellspacing="2" id="celebs">
  <thead>
  <tr class="tabel_header">
    <td rowspan="2">No</td>
    <td rowspan="2" width="167">Name Of Equipment</td>
    <td rowspan="2" width="93">Tag Serial Number</td>
    <td align="center" colspan="3">Specification</td>
    <td align="center" colspan="2">Validation Date</td>
    <td rowspan="2" title="Code color now (<?php echo date("F Y");?>)">Status</td>
    <td rowspan="2">Day Remaining</td>
    <td rowspan="2" width="190">Location</td>
    <td rowspan="2" width="146">Certificate No.</td>
    <td rowspan="2" width="86">Certificated by</td>
    <td width="100" rowspan="2">Updated by</td>
    <td width="95" rowspan="2">Update</td>  
    <?php if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) { echo '<td width="95" rowspan="2">&nbsp;</td>'; } ?>
    </tr>
  <tr class="tabel_header">
    <td class="tabel_header" width="44">Brand</td>
    <td class="tabel_header" width="44">Range (mm)</td>
    <td class="tabel_header" width="44">WLL (tons)</td>
    
    <td class="tabel_header" width="95">Inspection Date</td>
    <td class="tabel_header" width="95">Expired Date</td>
  </tr>
  </thead>
  <tbody>
    <?php 
	{ include "../dateformat_funct.php"; include "func_color_code.php"; }
	list($vbgcolor, $fcolor) = colorcode(date("Y-m-d"));
	
	do {
		//include "func_color_code.php";
    	//list($vbgcolor, $fcolor) = colorcode(date("Y-m-d"));
		//echo '<tr class="isi_tabel" bgcolor = "'.$vbgcolor.'" style="color:#'.$fcolor.'">';
	?>
      	<tr class="tabel_body" ondblclick="this.style.fontWeight='bold';" onclick="this.style.fontWeight='normal';" title="Double click data for 'highlight', and one click to remove highlight"><?php $a = $a + 1 ?>
        <td align="center"><?php echo $a; ?></td>
        <td><?php echo $row_Recordset1['name_of_equipment']; ?></td>
        <td><?php echo $row_Recordset1['tag_serial_number']; ?></td>
        <td align="center"><?php echo $row_Recordset1['brand']; ?></td>
        <td align="center"><?php echo $row_Recordset1['range_mm']; ?></td>
        <td align="center"><?php echo $row_Recordset1['WLL_tons']; ?></td>
        <td align="center"><?php echo functddmmmyyyy($row_Recordset1['inspection_date']); ?></td>
        <td align="center"><?php echo functddmmmyyyy($row_Recordset1['expired_date']); ?></td>
        
        <?php if ($row_Recordset1['status'] == 0) {
				echo '<td align="center" bgcolor = "'.$vbgcolor.'" style="color:#F00"><b>Expired</b></td>';
			} else if ($row_Recordset1['status'] == 1) {
				echo '<td align="center" bgcolor = "'.$vbgcolor.'" style="color:#'.$fcolor.'"><b>Valid</b></td>';
			} ?>
      <td align="center"><?php { include "msg_expired.php"; } ?></td>
      
        <td><?php echo $row_Recordset1['location']; ?></td>
        
        <td align="center">
			<?php if ($row_Recordset1['fileupload'] == "") {
                    echo $row_Recordset1['no_certificate'];
            } else { ?>
                <a href=upload/<?php echo $row_Recordset1['fileupload']; ?> target="_blank"><?php echo $row_Recordset1['no_certificate']; ?></a>
            <?php } ?>
      </td>
      <td><?php echo $row_Recordset1['issued_by']; ?></td>
      
      <td><?php echo $row_Recordset1[fname]; ?> <?php echo $row_Recordset1[mname]; ?> <?php echo $row_Recordset1[lname]; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_Recordset1[exist_date]); ?></td>
    
       <?php
       if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) { ?>
       		<td align="center"><a href="editcertificateproductBC.php?data=<?php echo $row_Recordset1['id']; ?>">Edit</a> | <a href="deletecertificateproduct.php?data=<?php echo $row_Recordset1['id_certificate']; ?>&data1=9&data2=<?php echo $row_Recordset1['tag_serial_number']; ?>" onclick="return confirm('Delete <?php echo $row_Recordset1['name_of_equipment']; ?> with tag serial number <?php echo $row_Recordset1['tag_serial_number']; ?> ?')">Delete</a></td>
	   <?php } ?>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </tbody>
</table>
<table>
  <tr>
    <td><a href="#"><img src="/images/icon_printpw.gif" alt="" width="24" height="25" class="btn" onclick="MM_openBrWindow('viewcertificateproductBC_print.php','','scrollbars=yes,resizable=yes,width=1200,height=500')"/></a></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>