<?php require_once('../../Connections/core.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

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

$idemp = $_SESSION['empID'];
mysql_select_db($database_core, $core);
$query_rsuser = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee  WHERE h_employee.id = '$idemp'";
$rsuser = mysql_query($query_rsuser, $core) or die(mysql_error());
$row_rsuser = mysql_fetch_assoc($rsuser);
$totalRows_rsuser = mysql_num_rows($rsuser);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT h_absen_header.*, h_bulan.bulan AS bulan_huruf FROM h_absen_header, h_bulan WHERE h_absen_header.id = %s AND h_bulan.id = h_absen_header.bulan", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT a.id, a.idheader, a.employee, a.status, a.h01, a.h02, a.h03, a.h04, a.h05, a.h06, a.h07, a.h08, a.h09, a.h10, a.h11, a.h12, a.h13, a.h14, a.h15, a.h16, a.h17, a.h18, a.h19, a.h20, a.h21, a.h22, a.h23, a.h24, a.h25, a.h26, a.h27, a.h28, a.h29, a.h30, a.h31, b.firstname, b.nik, b.department, b.midlename, b.lastname, b.jabatan FROM h_absen a LEFT JOIN h_employee b ON a.employee=b.id WHERE a.idheader = '".$row_Recordset1['id']."'";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM h_absen_inisial";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Report <?php echo $row_Recordset1['month']; ?></title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../../js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
		// jeditable yang untuk header	
		$(".headereditable_select").editable("save.php?tb=h_absen_header&select=1&tb2=h_employee&fld=firstname", { 
			indicator : 'Saving....', // indikator saat melakukan proses
			loadurl: 'listemploy_json.php', // pengambilan data jason
			type   : "select", // tipe jeditable
			submit : "OK", // proses berlangsung saat di tekan ok
			 placeholder: '___'	//saat data kosong digantikan dengan ini
		});
		$('.headeredit').editable('save.php?tb=h_absen_header', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...', // saat jeditable di hoover akan muncul pesan ini
			placeholder: '___'
		});
	 	$('.headeredit_area').editable('save.php?tb=h_absen_header', { 
			 type      : 'textarea',
			 cancel    : 'Cancel',
			 submit    : 'OK',
			 indicator : 'Saving...',
			 rows      : 2, // tinggi sesuai nilai row
			 tooltip   : 'Click to edit...',
			 placeholder: '___'
     	});
		// sama seperti yang diatas tp yg ini untuk data core
		$(".coreeditable_select").editable("save.php?tb=h_absen&select=1&tb2=h_employee&fld=firstname", { 
			indicator  : 'Saving....',
			loadurl    : 'listemploy_json.php',
			type       : "select",
			submit     : "OK",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
$(".coreeditanggal_select").editable("save.php?tb=h_absen&select=1&tb2=h_employee&fld=firstname", { 
			indicator  : 'Saving....',
			type       : "text",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});		
		$('.coreedit').editable('save.php?tb=h_absen', {
			indicator  : 'Saving...',
			tooltip    : 'Click to edit...',
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
		$('.coreedit_status').editable('save.php?tb=h_absen', {
			indicator  : 'Saving...',
			loadurl    : 'list_status.php',
			tooltip    : 'Click to edit...',
			type       : "select",
			submit     : "OK",
			submitdata : function(){
							document.location.reload();
						 },
			 placeholder: '___'
		});
	 	$('.coreedit_area').editable('save.php?tb=h_absen', { 
			 type      : 'textarea',
			 cancel    : 'Cancel',
			 submit    : 'OK',
			 indicator : 'Saving...',
			 rows      : 1,
			 tooltip   : 'Click to edit...',
			 placeholder: '___'
     	});
 	});
</script>
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
<p>
<input name="rkpabsn_permen" type="submit" id="rkpabsn_permen" onclick="MM_openBrWindow('rkpabsn_permen.php?data=<?php echo $row_Recordset1['id']; ?>','','width=1000,height=500')" value="Rekap Data Karyawan Pusat" />
<input type="submit" name="rkpabsn_lokal" id="rkpabsn_lokal" onclick="MM_openBrWindow('rkpabsn_lokal.php?data=<?php echo $row_Recordset1['id']; ?>','','width=1000,height=500')" value="Rekap Data Karyawan Lokal" />
 <input type="submit" name="rkpabsn_harian" id="rkpabsn_harian" onclick="MM_openBrWindow('rkpabsn_harian.php?data=<?php echo $row_Recordset1['id']; ?>','','width=1000,height=500')" value="Rekap Data Karyawan Harian"/>
 <input type="submit" name="rkpabsn_pkl" id="rkpabsn_pkl" onclick="MM_openBrWindow('rkpabsn_pkl.php?data=<?php echo $row_Recordset1['id']; ?>','','width=1000,height=500')" value="Rekap Data Karyawan PKL" />
</p>
<table width="1862" id="celebs">
  <thead>
    <tr class="tabel_header">
      <td width="17" rowspan="2" align="center">NO</td>
      <td width="330" rowspan="2" align="center">NAMA</td>
      <td width="56" rowspan="2" align="center">NIK</td>
      <td width="77" rowspan="2" align="center">BAGIAN</td>
      <td width="106" rowspan="2" align="center">POSISI</td>
      <td width="100" rowspan="2" align="center">STATUS</td>
      <td colspan="31"><?php echo $row_Recordset1['bulan_huruf']; ?> <?php echo $row_Recordset1['tahun']; ?></td>
      <td width="32" rowspan="2" align="center">Total Sakit</td>
      <td width="32" rowspan="2" align="center">Total Izin</td>
      <td width="32" rowspan="2" align="center">Total Alpa</td>
      <td width="32" rowspan="2" align="center">Total IP</td>
      <td width="32" rowspan="2" align="center">Total IK</td>
      <td width="33" rowspan="2" align="center">Total IT</td>
      <td width="32" rowspan="2" align="center">Total TTM</td>
      <td width="32" rowspan="2" align="center">Total TTK</td>
      <td width="32" rowspan="2" align="center">Total Cuti</td>
      <td width="45" rowspan="2" align="center">Sisa Cuti</td>
      <td width="73" rowspan="2" align="center">Total Terlambat (menit)</td>
      <td width="42" rowspan="2" align="center">&nbsp;</td>
    </tr>
    <tr class="tabel_header">
      <td width="17" align="center" class="tabel_header">01</td>
      <td width="17" align="center" class="tabel_header">02</td>
      <td width="17" align="center" class="tabel_header">03</td>
      <td width="17" align="center" class="tabel_header">04</td>
      <td width="17" align="center" class="tabel_header">05</td>
      <td width="17" align="center" class="tabel_header">06</td>
      <td width="17" align="center" class="tabel_header">07</td>
      <td width="17" align="center" class="tabel_header">08</td>
      <td width="17" align="center" class="tabel_header">09</td>
      <td width="17" align="center" class="tabel_header">10</td>
      <td width="17" align="center" class="tabel_header">11</td>
      <td width="17" align="center" class="tabel_header">12</td>
      <td width="17" align="center" class="tabel_header">13</td>
      <td width="17" align="center" class="tabel_header">14</td>
      <td width="17" align="center" class="tabel_header">15</td>
      <td width="17" align="center" class="tabel_header">16</td>
      <td width="17" align="center" class="tabel_header">17</td>
      <td width="17" align="center" class="tabel_header">18</td>
      <td width="17" align="center" class="tabel_header">20</td>
      <td width="17" align="center" class="tabel_header">20</td>
      <td width="17" align="center" class="tabel_header">21</td>
      <td width="17" align="center" class="tabel_header">22</td>
      <td width="17" align="center" class="tabel_header">23</td>
      <td width="17" align="center" class="tabel_header">24</td>
      <td width="17" align="center" class="tabel_header">25</td>
      <td width="17" align="center" class="tabel_header">26</td>
      <td width="17" align="center" class="tabel_header">27</td>
      <td width="17" align="center" class="tabel_header">28</td>
      <td width="17" align="center" class="tabel_header">29</td>
      <td width="17" align="center" class="tabel_header">30</td>
      <td width="17" align="center" class="tabel_header">31</td>
    </tr>
  </thead>
  <tbody>
    <?php if($totalRows_Recordset2>0){ $i=0 ;do{ ?>
      <tr class="tabel_body">
        <td align="center"><?php $i++; echo $i; ?></td>
        <td><div class="coreeditable_select" id="<?php echo $row_Recordset2['id']; ?>-employee"><?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['midlename']; ?> <?php echo $row_Recordset2['lastname']; ?></div></td>
        <td><?php echo $row_Recordset2[nik]; ?></td>
        <td><?php echo $row_Recordset2[department]; ?></td>
        <td><?php echo $row_Recordset2['jabatan']; ?></td>
        <td><div class="coreedit_status" id="<?php echo $row_Recordset2['id']; ?>-status"><?php echo $row_Recordset2['status']; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h01"><?php echo $row_Recordset2[h01]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h02"><?php echo $row_Recordset2[h02]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h03"><?php echo $row_Recordset2[h03]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h04"><?php echo $row_Recordset2[h04]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h05"><?php echo $row_Recordset2[h05]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h06"><?php echo $row_Recordset2[h06]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h07"><?php echo $row_Recordset2[h07]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h08"><?php echo $row_Recordset2[h08]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h09"><?php echo $row_Recordset2[h09]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h10"><?php echo $row_Recordset2[h10]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h11"><?php echo $row_Recordset2[h11]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h12"><?php echo $row_Recordset2[h12]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h13"><?php echo $row_Recordset2[h13]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h14"><?php echo $row_Recordset2[h14]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h15"><?php echo $row_Recordset2[h15]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h16"><?php echo $row_Recordset2[h16]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h17"><?php echo $row_Recordset2[h17]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h18"><?php echo $row_Recordset2[h18]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h19"><?php echo $row_Recordset2[h19]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h20"><?php echo $row_Recordset2[h20]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h21"><?php echo $row_Recordset2[h21]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h22"><?php echo $row_Recordset2[h22]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h23"><?php echo $row_Recordset2[h23]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h24"><?php echo $row_Recordset2[h24]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h25"><?php echo $row_Recordset2[h25]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h26"><?php echo $row_Recordset2[h26]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h27"><?php echo $row_Recordset2[h27]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h28"><?php echo $row_Recordset2[h28]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h29"><?php echo $row_Recordset2[h29]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h30"><?php echo $row_Recordset2[h30]; ?></div></td>
        <td align="center"><div class="coreeditanggal_select" id="<?php echo $row_Recordset2['id']; ?>-h31"><?php echo $row_Recordset2[h31]; ?></div></td>
        <td align="center">
        <?php
	  	$tdkmsk = $row_Recordset2['h01'];
	$tdkmsk2 = $row_Recordset2['h02'];
	$tdkmsk3 = $row_Recordset2['h03'];
	$tdkmsk4 = $row_Recordset2['h04'];
	$tdkmsk5 = $row_Recordset2['h05'];
	$tdkmsk6 = $row_Recordset2['h06'];
	$tdkmsk7 = $row_Recordset2['h07'];
	$tdkmsk8 = $row_Recordset2['h08'];
	$tdkmsk9 = $row_Recordset2['h09'];
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
	  ?><?php 	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "skt");
?></td>
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "iz");
?></td>
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "a");
?></td>
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ip");
?></td>
        <td align="center"><?php 

	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ik");
?></td>
        <td align="center"><?php 
	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "it");
?></td>
        
        <td align="center"><?php 
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ttm");
?></td>
        <td align="center"><?php 	
	echo substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ttk");
?></td>
        <td align="center"><?php 
	$cuti = substr_count("$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31", "ct"); echo $cuti;
?></td>
        <td align="center"><?php $sisacuti = 12 - $cuti; echo $sisacuti; ?></td>
        <td align="center"><?php $telat=$row_Recordset2['h01']+$row_Recordset2['h02']+$row_Recordset2['h03']+$row_Recordset2['h4']+$row_Recordset2['h05']+$row_Recordset2['h06']+$row_Recordset2['h07']+$row_Recordset2['h08']+$row_Recordset2['h09']+$row_Recordset2['h10']+$row_Recordset2['h11']+$row_Recordset2['h12']+$row_Recordset2['h13']+$row_Recordset2['h14']+$row_Recordset2['h15']+$row_Recordset2['h16']+$row_Recordset2['h17']+$row_Recordset2['h18']+$row_Recordset2['h19']+$row_Recordset2['h20']+$row_Recordset2['h21']+$row_Recordset2['h22']+$row_Recordset2['h23']+$row_Recordset2['h24']+$row_Recordset2['h25']+$row_Recordset2['h26']+$row_Recordset2['h27']+$row_Recordset2['h28']+$row_Recordset2['h29']+$row_Recordset2['h30']+$row_Recordset2['h31']; echo $telat; ?></td>
        <td width="42" align="center"><a style="text-decoration:none; color:#F00AAA" href="delrow.php?header=<?php echo $_GET['data']; ?>&amp;data=<?php echo $row_Recordset2['id']; ?>&amp;tb=h_absen"><strong>x</strong></a></td>
      </tr>
      <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
<?php
  }
  ?>
  </tbody>
  <tr>
    <td align="center"><a style="text-decoration:none; color:#09F" href="addrow.php?data=<?php echo $_GET['data']; ?>&amp;fld=idheader&amp;tb=h_absen"><strong>+</strong></a></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="264" border="0">
  <tr class="tabel_header">
    <td width="18">No</td>
    <td width="137">Keterangan</td>
    <td width="95">Inisial</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $b=$b+1 ?>
      <td align="center"><?php echo $b; ?></td>
      <td><?php echo $row_Recordset3['jenis']; ?></td>
      <td align="center"><?php echo $row_Recordset3['inisial']; ?></td>
    </tr>
    <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
</table>
<p>&nbsp;</p>
<table width="1115" class="General">
  <tr>
    <td width="665">&nbsp;</td>
    <td width="162"><p>Prepare By :
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-prepareby"><?php echo $row_rsuser['fname']; ?> <?php echo $row_rsuser['mname']; ?> <?php echo $row_rsuser['lname']; ?></div></td>
    <td width="162"><p>Checked By :                  
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
      <div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-checkedby"><?php echo $row_Recordset1['checkedby']; ?></div>
    </td>
    <td width="162"><p>Approve By :                 
        <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <p class="hidentext">.</p>
    <div class="headeredit" id="<?php echo $row_Recordset1['id']; ?>-approvedby"><?php echo $row_Recordset1['approvedby']; ?></div></td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($rsuser);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
