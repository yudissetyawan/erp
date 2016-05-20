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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT pr_si_core.*, m_unit.unit, m_master.descr_name, m_master.descr_spec, m_master.brand, m_master.item_code, m_e_model.mtrl_model, m_master_prop.weight_kgs, m_master_prop.dimension_m, m_master_prop.volume_m3 FROM pr_si_core, m_unit, m_master, m_e_model, m_master_prop WHERE pr_si_core.id_header = %s AND pr_si_core.id_unit=m_unit.id_unit AND pr_si_core.id_descr=m_master.id_item AND m_master.id_mmodel=m_e_model.id_mmodel AND pr_si_core.id_prop=m_master_prop.id_prop", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM pr_si_header WHERE id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_prepared = "-1";
if (isset($_GET['data'])) {
  $colname_prepared = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_prepared = sprintf("SELECT pr_si_header.req_by, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM pr_si_header, h_employee WHERE pr_si_header.id = %s AND pr_si_header.req_by=h_employee.id", GetSQLValueString($colname_prepared, "int"));
$prepared = mysql_query($query_prepared, $core) or die(mysql_error());
$row_prepared = mysql_fetch_assoc($prepared);
$totalRows_prepared = mysql_num_rows($prepared);

$colname_recieved = "-1";
if (isset($_GET['data'])) {
  $colname_recieved = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_recieved = sprintf("SELECT pr_si_header.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM pr_si_header, h_employee WHERE pr_si_header.id = %s  AND pr_si_header.recv_by=h_employee.id", GetSQLValueString($colname_recieved, "int"));
$recieved = mysql_query($query_recieved, $core) or die(mysql_error());
$row_recieved = mysql_fetch_assoc($recieved);
$totalRows_recieved = mysql_num_rows($recieved);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT pr_si_header.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM pr_si_header, h_employee WHERE pr_si_header.id = %s  AND pr_si_header.apprv_by=h_employee.id", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$data=$_GET['data'];
$tmpg = "select SUM(pr_si_core.weights) as total from pr_si_core where id_header='$data' "; // Cari jumlah
$hasil = mysql_query($tmpg, $core) or die(mysql_error()); // execute query
$vrb = mysql_fetch_assoc($hasil); // execute jd array
$panjang = $vrb['total'];

$tmpg11 = "select SUM(pr_si_core.volumes) as total from pr_si_core where id_header='$data' "; // Cari jumlah
$hasil11 = mysql_query($tmpg11, $core) or die(mysql_error()); // execute query
$vrb11 = mysql_fetch_assoc($hasil11); // execute jd array
$panjang11 = $vrb11['total'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
 <script type="text/javascript">
/*--This JavaScript method for Print command--*/
    function PrintDoc() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>M/S Request</title><link rel="stylesheet" type="text/css" href="../../css/print.css" /><link rel="stylesheet" type="text/css" href="../../css/untuk_printmr.css" /></head><body onload="window.print()">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }

/*--This JavaScript method for Print Preview command--*/
    function PrintPreview() {
        var toPrint = document.getElementById('printarea');
        var popupWin = window.open('', '_blank', 'width=1100,height=800,location=no,left=200px');
        popupWin.document.open();
        popupWin.document.write('<html><title>::Print Preview::</title><link rel="stylesheet" type="text/css" href="../../css/print.css" media="screen"/><link rel="stylesheet" type="text/css" href="../../css/untuk_printmr.css" /></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();
    }
</script>

<style type="text/css">
			table {border-collapse:collapse;}
			.tdclass{border-right:1px solid #333333;}
			body{
	font: 75.5% "Trebuchet MS", sans-serif;
	margin: 50px;
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
	margin-bottom: 5px;
}
			.demoHeaders { margin-top: 2em; }

			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
.headerdate {	text-align: left;
}
.headertable {
	text-align: center;
	color: #FFF;
	font-weight: 900;
}
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>
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

<body id="printarea">
<table width="1000" border="1" class="table" id="celebs">
<thead>
  <tr class="tabel_header">
    <td width="29"><div align="center"><strong>No</strong></div></td>
    <td width="32"><div align="center"><strong>QTY</strong></div></td>
    <td width="48"><div align="center"><strong>UNIT</strong></div></td>
    <td width="287"><div align="center"><strong>DESCRIPTION</strong></div></td>
    <td width="68"><div align="center"><strong>WEIGHT (Kgs)</strong></div></td>
    <td width="88"><div align="center"><strong>DIMENSION (Mtr)</strong></div></td>
    <td width="71"><div align="center"><strong>VOLUME (M3)</strong></div></td>
    <td width="175"><div align="center"><strong>REMARK</strong></div></td>
  </tr>
</thead>
<tbody>  
  <?php do { ?>
  <tr class="tabel_body">
    <?php $a=$a+1 ?>
    <td align="center"><?php echo $a; ?></td>
    <td align="center"><?php echo $row_Recordset1[qty]; ?></td>
    <td><?php echo $row_Recordset1[unit]; ?></td>
    <td ><?php echo $row_Recordset1[mtrl_model]; ?> (<?php echo $row_Recordset1['descr_name']; ?>) <?php echo $row_Recordset1['id_type']; ?> <?php echo $row_Recordset1['brand']; ?></td>
    <td align="center"><?php echo $row_Recordset1[weight_kgs]; ?></td>
    <td align="center"><?php echo $row_Recordset1[dimension_m]; ?></td>
    <td align="center"><?php echo $row_Recordset1[volume_m3]; ?></td>
    <td><?php echo $row_Recordset1[remark]; ?></td>
  </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr class="tabel_header">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>TOTAL WEIGHT</strong></div></td>
    <td width="90"><div align="center"><strong><?php echo $panjang; ?></strong></div></td>
    <td width="88"><div align="center"><strong><?php echo $panjang1; ?></strong></div></td>
    <td width="71"><div align="center"><strong><?php echo $panjang11; ?></strong></div></td>
    <td width="175">&nbsp;</td>
  </tr>
  </tbody>
</table>

<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($prepared);

mysql_free_result($recieved);

mysql_free_result($Recordset3);
?>
