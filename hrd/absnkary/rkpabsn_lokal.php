<?php require_once('../../Connections/core.php'); ?>
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
$query_Recordset1 = sprintf("SELECT * FROM h_absen_header WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT a.id, a.idheader, a.employee, a.status, a.h01, a.h02, a.h03, a.h04, a.h05, a.h06, a.h07, a.h08, a.h09, a.h10, a.h11, a.h12, a.h13, a.h14, a.h15, a.h16, a.h17, a.h18, a.h19, a.h20, a.h21, a.h22, a.h23, a.h24, a.h25, a.h26, a.h27, a.h28, a.h29, a.h30, a.h31, b.firstname, b.nik, b.department, b.midlename, b.lastname, b.jabatan FROM h_absen a LEFT JOIN h_employee b ON a.employee=b.id WHERE a.idheader = '".$row_Recordset1['id']."' AND a.status = 'lokal'";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
</script>

</head>

<body>
<p class="buatform">Periode : <?php echo $row_Recordset1['bulan']; ?> <?php echo $row_Recordset1['tahun']; ?></p>
<table width="930" id="celebs">
  <thead>
    <tr class="tabel_header">
      <td width="17" rowspan="2" align="center">NO</td>
      <td width="228" rowspan="2" align="center">NAMA</td>
      <td width="60" rowspan="2" align="center">NIK</td>
      <td width="81" rowspan="2" align="center">BAGIAN</td>
      <td width="101" rowspan="2" align="center">POSISI</td>
      <td colspan="10"  align="center">Total</td>
    </tr>
    <tr class="tabel_header">
      <td width="32"  class="tabel_header" align="center"> Sakit</td>
      <td width="32"  class="tabel_header" align="center"> Izin</td>
      <td width="32"  class="tabel_header" align="center"> Alpa</td>
      <td width="32"  class="tabel_header" align="center"> IP</td>
      <td width="32"  class="tabel_header" align="center"> IK</td>
      <td width="34"  class="tabel_header" align="center"> IT</td>
      <td width="32"  class="tabel_header" align="center"> TTM</td>
      <td width="32"  class="tabel_header" align="center"> TTK</td>
      <td width="32"  class="tabel_header" align="center"> Cuti</td>
      <td width="59"  class="tabel_header" align="center"> Terlambat (menit)</td>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $i++; echo $i; ?></td>
      <td><?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?></td>
      <td><?php echo $row_Recordset2[nik]; ?></td>
      <td><?php echo $row_Recordset2[department]; ?></td>
      <td><?php echo $row_Recordset2['jabatan']; ?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "skt");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "iz");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "a");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ip");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ik");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "it");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ttm");
?></td>
      <td><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ttk");
?></td>
      <td align="center"><?php 
	$tdkmsk = $row_Recordset2['h1'];
	$tdkmsk2 = $row_Recordset2['h2'];
	$tdkmsk3 = $row_Recordset2['h3'];
	$tdkmsk4 = $row_Recordset2['h4'];
	$tdkmsk5 = $row_Recordset2['h5'];
	$tdkmsk6 = $row_Recordset2['h6'];
	$tdkmsk7 = $row_Recordset2['h7'];
	$tdkmsk8 = $row_Recordset2['h8'];
	$tdkmsk9 = $row_Recordset2['h9'];
	$tdkmsk10 = $row_Recordset2['h10'];
	$tdkmsk11 = $row_Recordset2['h11'];
	$tdkmsk12 = $row_Recordset2['h12'];
	$tdkmsk13 = $row_Recordset2['h13'];
	$tdkmsk14 = $row_Recordset2['h14'];
	$tdkmsk15 = $row_Recordset2['h15'];
	$tdkmsk16 = $row_Recordset2['h16'];
	$tdkmsk17 = $row_Recordset2['h17'];
	$tdkmsk18 = $row_Recordset2['h18'];
	$tdkmsk19 = $row_Recordset2['h19'];
	$tdkmsk20 = $row_Recordset2['h20'];
	$tdkmsk21 = $row_Recordset2['h21'];
	$tdkmsk22 = $row_Recordset2['h22'];
	$tdkmsk23 = $row_Recordset2['h23'];
	$tdkmsk24 = $row_Recordset2['h24'];
	$tdkmsk25 = $row_Recordset2['h25'];
	$tdkmsk26 = $row_Recordset2['h26'];
	$tdkmsk27 = $row_Recordset2['h27'];
	$tdkmsk28 = $row_Recordset2['h28'];
	$tdkmsk29 = $row_Recordset2['h29'];
	$tdkmsk30 = $row_Recordset2['h30'];
	$tdkmsk31 = $row_Recordset2['h31'];
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ct");
?></td>
      <td align="center"><?php $telat=$row_Recordset2['h1']+$row_Recordset2['h2']+$row_Recordset2['h3']+$row_Recordset2['h4']+$row_Recordset2['h5']+$row_Recordset2['h6']+$row_Recordset2['h7']+$row_Recordset2['h8']+$row_Recordset2['h9']+$row_Recordset2['h10']+$row_Recordset2['h11']+$row_Recordset2['h12']+$row_Recordset2['h13']+$row_Recordset2['h14']+$row_Recordset2['h15']+$row_Recordset2['h16']+$row_Recordset2['h17']+$row_Recordset2['h18']+$row_Recordset2['h19']+$row_Recordset2['h20']+$row_Recordset2['h21']+$row_Recordset2['h22']+$row_Recordset2['h23']+$row_Recordset2['h24']+$row_Recordset2['h25']+$row_Recordset2['h26']+$row_Recordset2['h27']+$row_Recordset2['h28']+$row_Recordset2['h29']+$row_Recordset2['h30']+$row_Recordset2['h31']; echo $telat; ?></td>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
  </tbody>
</table>
<p>&nbsp;</p>
<table width="1000" class="General">
  <tr>
    <td width="665">&nbsp;</td>
    <td width="162"><p>Prepare By : </p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <?php echo $row_Recordset1['prepareby']; ?></td>
    <td width="162"><p>Checked By : </p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <?php echo $row_Recordset1['checkedby']; ?></td>
    <td width="162"><p>Approve By : </p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <p class="hidentext">.</p>
      <?php echo $row_Recordset1['approvedby']; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
