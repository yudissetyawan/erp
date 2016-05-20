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
$query_Recordset1 = "SELECT p_certificate_product.*, dms.idms, dms.fileupload, dms.id FROM p_certificate_product, dms WHERE p_certificate_product.id_category_product='1'  AND dms.keterangan=p_certificate_product.name_of_equipment AND dms.id_departemen = 'QC'  AND p_certificate_product.id_certificate=dms.idms AND p_certificate_product.activeYN = '1'";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Certificate Sand Basket</title>
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
</script>

<script type="text/javascript">
var myRow=2;
  var myCol=10;
  var myTable;
  var noRows;
  var myCells,ID;
  
function setUp(){
    if(!myTable){myTable=document.getElementById("celebs");}
     myCells = myTable.rows[0].cells.length;
    noRows=myTable.rows.length;

    for( var x = 0; x < myTable.rows[0].cells.length; x++ ) {
        colWdth=myTable.rows[0].cells[x].offsetWidth;
        myTable.rows[0].cells[x].setAttribute("width",colWdth-4);

    } 
}

function right(up){
    if(up){window.clearTimeout(ID);return;}
    if(!myTable){setUp();}

    if(myCol<(myCells)){
        for( var x = 0; x < noRows; x++ ) {
            myTable.rows[x].cells[myCol].style.display="";
        }
        if(myCol > 10){myCol--;}

        ID = window.setTimeout('right()',100);
    }
}
  
function left(up){
    if(up){window.clearTimeout(ID);return;}
    if(!myTable){setUp();}

    if(myCol<(myCells-1)){
        for( var x = 0; x < noRows; x++ ) {
            myTable.rows[x].cells[myCol].style.display="none";
        }
        myCol++
        ID = window.setTimeout('left()',100);
    }
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

</head>
<body>
<?php
	if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) {
		echo '<p><a href="inputcertificateproductSB.php?data=1" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plusthick"></span>Add Item</a></p>';
	}
?>

<!-- <button title="Left" onMouseDown="left();" onMouseUp="left(1);">&lt;&lt;</button>
<button title="Right" onMouseDown="right();" onMouseUp="right(1);">&gt;&gt;</button> -->
<br /><br />

<table width="1400" border="0" cellpadding="2" cellspacing="2" id="celebs">
  <thead>
    <tr class="tabel_header">
      <td rowspan="2">No.</td>
      <td rowspan="2" width="110">Name Of Equipment</td>
      <td rowspan="2">Tag / Serial Number</td>
      <td align="center" colspan="5">Specification</td>
      <td colspan="2">Validation Date</td>
      <td rowspan="2" title="Code color now (<?php echo date("F Y");?>)">Status</td>  
      <td rowspan="2">Day Remaining</td>
      <td rowspan="2" width="180">Location</td>
      <td rowspan="2" width="130">Certificate No.</td>
      <td rowspan="2" width="86">Certificated By</td>
      <td width="120" rowspan="2">Updated by</td>
      <td width="110" rowspan="2">Update</td>
      <?php if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) { echo '<td width="100" rowspan="2">&nbsp;</td>'; } ?>
    </tr>
    <tr>
      <td class="tabel_header" width="44">Length (mm)</td>
      <td class="tabel_header" width="44">Height (mm)</td>
      <td class="tabel_header" width="44">Width (mm)</td>
      <td class="tabel_header" width="44">Tare Weight (kg)</td>
      <td class="tabel_header" width="44">SWL (kg)</td>
      <td class="tabel_header" width="95">Inspection Date</td>
      <td class="tabel_header" width="105">Expired Date</td>

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
    <tr class="tabel_body" ondblclick="this.style.fontWeight='bold';" onclick="this.style.fontWeight='normal';" title="Double click data for 'highlight', and one click to remove highlight">
      <?php $a=$a+1 ?>
      <td align="center"><?php echo $a; ?></td>
      <td width="167"><?php echo $row_Recordset1[name_of_equipment]; ?></td>
      <td width="93"><?php echo $row_Recordset1[tag_serial_number]; ?></td>
      <td align="center"><?php echo $row_Recordset1[length_mm]; ?></td>
      <td align="center"><?php echo $row_Recordset1[height_mm]; ?></td>
      <td align="center" ><?php echo $row_Recordset1[width_mm]; ?></td>
      <td align="center"><?php echo $row_Recordset1[tare_weight_kg]; ?></td>
      <td align="center"><?php echo $row_Recordset1[SWL_kg]; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_Recordset1[inspection_date]); ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_Recordset1[expired_date]); ?></td>
      
      <?php if ($row_Recordset1['status'] == 0) {
				echo '<td align="center" bgcolor = "'.$vbgcolor.'" style="color:#F00"><b>Expired</b></td>';
			} else if ($row_Recordset1['status'] == 1) {
				echo '<td align="center" bgcolor = "'.$vbgcolor.'" style="color:#'.$fcolor.'"><b>Valid</b></td>';
			} ?>
       <td align="center"><?php { include "msg_expired.php"; } ?></td>      
      <td width="190"><?php echo $row_Recordset1['location']; ?></td>

      <td align="center" width="146"><?php if ($row_Recordset1['fileupload'] == "") {
				echo $row_Recordset1['no_certificate'];
		} else { ?>
        <a href=upload/<?php echo $row_Recordset1['fileupload']; ?> target="_blank"><?php echo $row_Recordset1['no_certificate']; ?></a>
        <?php } ?></td>
      <td width="86"><?php echo $row_Recordset1[issued_by]; ?></td>
      
	<td>
	  <?php
		$vusr = $row_Recordset1['issued_user'];
		mysql_select_db($database_core, $core);
		$query_rsusr = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vusr'";
		$rsusr = mysql_query($query_rsusr, $core) or die(mysql_error());
		$row_rsusr = mysql_fetch_assoc($rsusr);
		$totalRows_rsusr = mysql_num_rows($rsusr);
		
		echo $row_rsusr[fname]; ?> <?php echo $row_rsusr[mname]; ?> <?php echo $row_rsusr[lname]; ?>
	</td>
      <td align="center"><?php echo functddmmmyyyy($row_Recordset1[exist_date]); ?></td>
       <?php
       if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'qly') || ($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'branchmanager') || ($_SESSION['userlvl'] == 'project')) { ?>
       		<td align="center"><a href="editcertificateproductSB.php?data=<?php echo $row_Recordset1['id_certificate']; ?>">Edit</a> | <a href="deletecertificateproduct.php?data=<?php echo $row_Recordset1['id_certificate']; ?>&data1=1&data2=<?php echo $row_Recordset1['tag_serial_number']; ?>" onclick="return confirm('Delete <?php echo $row_Recordset1['name_of_equipment']; ?> with tag serial number <?php echo $row_Recordset1['tag_serial_number']; ?> ?')">Delete</a></td>
	   <?php } ?>  
    </tr>
    
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </tbody>
</table>
<br />
<table>
  <tr>
    <td><a href="#"><img src="/images/icon_printpw.gif" alt="" width="49" height="50" class="btn" onclick="MM_openBrWindow('viewcertificateproductSB_print.php','','scrollbars=yes,resizable=yes,width=1200,height=500')"/></a></td>
  </tr>
</table>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>