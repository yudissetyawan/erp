<?php require_once('../Connections/core.php'); ?>
<?php require_once('../Connections/core.php'); ?>
<?php require_once('../Connections/core.php'); ?>
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
	
  $logoutGoTo = "../index.php";
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
$query_Recordset1 = "SELECT * FROM h_employee";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_jenis_training ORDER BY jenis_training ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM h_datapribadi WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_mcu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM h_experiences WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset5, "text"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_penghargaan WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset6, "text"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_sim WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset7, "text"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_datakeluarga WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset8, "text"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_dataortu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset9, "text"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM h_bahasa WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset10, "text"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM h_training WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset11, "text"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

$colname_Recordset12 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset12 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset12 = sprintf("SELECT * FROM h_job_position WHERE id = %s", GetSQLValueString($colname_Recordset12, "int"));
$Recordset12 = mysql_query($query_Recordset12, $core) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

$colname_Recordset13 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset13 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset13 = sprintf("SELECT * FROM dms WHERE idms = %s AND dms.id_departemen = 'HRD_rec' ", GetSQLValueString($colname_Recordset13, "text"));
$Recordset13 = mysql_query($query_Recordset13, $core) or die(mysql_error());
$row_Recordset13 = mysql_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysql_num_rows($Recordset13);

$colname_Recordset14 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset14 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset14 = sprintf("SELECT * FROM h_selection_interview WHERE id = %s", GetSQLValueString($colname_Recordset14, "int"));
$Recordset14 = mysql_query($query_Recordset14, $core) or die(mysql_error());
$row_Recordset14 = mysql_fetch_assoc($Recordset14);
$totalRows_Recordset14 = mysql_num_rows($Recordset14);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD - Detail Data Karyawan</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function datediff($tgl1, $tgl2){
	 $tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	 $tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
 	  $diff_secs = abs($tgl1 - $tgl2);
	 $base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	 $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	 return array( "years" => date("Y", $diff) - $base_year,
	"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"months" => date("n", $diff) - 1,
	"days_total" => floor($diff_secs / (3600 * 24)),
	"days" => date("j", $diff) - 1 ),
	 "hours_total" => floor($diff_secs / 3600),
	"hours" => date("G", $diff),
	"minutes_total" => floor($diff_secs / 60),
	"minutes" => (int) date("i", $diff),
	"seconds_total" => $diff_secs,
	"seconds" => (int) date("s", $diff)  );
	 }
</script>

<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: underline;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
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

</head>

	
<body>
<?php {
include "../../date.php";
  }
?>
<table width="1270" border="0" align="center">
<tr>
    <td height="64" colspan="3"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="649" align="right" valign="bottom"><table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>
        <td width="10" align="right" valign="bottom">|</td>
        <td width="307" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="#"><?php echo $_SESSION['MM_Username']?> </a></td>
        <td width="11" class="demoHeaders">|</a></td>
        <td width="106" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
        <td width="11" class="demoHeaders">|</td>
        <td width="107" class="demoHeaders"><a href="<?php echo $logoutAction ?>;">Logout</a></td>
        <td width="18">|</td>
      </tr>
    </table></td><tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root"><a href="../home_hrd.php">HRD / GAFF</a></td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><strong>Employee</strong></td>
        </tr>
    </table></td>
      <tr>
  <tr>
    <td colspan="5" align="left" class="General" id="font"><div id="TabbedPanels1" class="VTabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">Personal Data</li>
        <li class="TabbedPanelsTab" tabindex="0">Training</li>
        <li class="TabbedPanelsTab" tabindex="0">Healthy</li>
        <li class="TabbedPanelsTab" tabindex="0">Pengobatan</li>
        <li class="TabbedPanelsTab" tabindex="0">Bantuan/Santunan</li>
        <li class="TabbedPanelsTab" tabindex="0">Experiences</li>
        <li class="TabbedPanelsTab" tabindex="0">Appreciation</li>
<li class="TabbedPanelsTab" tabindex="0">SIM</li>
        <li class="TabbedPanelsTab" tabindex="0">Family Data</li>
        <li class="TabbedPanelsTab" tabindex="0">Parent Data</li>
        <li class="TabbedPanelsTab" tabindex="0">Languange</li>
        <li class="TabbedPanelsTab" tabindex="0">Job Position</li>
        <li class="TabbedPanelsTab" tabindex="0">Attachment</li>
        <li class="TabbedPanelsTab" tabindex="0">Skill test</li>
        <li class="TabbedPanelsTab" tabindex="0">Interviews</li>
        <li class="TabbedPanelsTab" tabindex="0">Psikotes &amp; MCU</li>
        <li class="TabbedPanelsTab" tabindex="0">Selection</li>
      
      </ul>
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <form id="form1" name="form1" method="post">
        <table width="708" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td colspan="2" align="center" class="view"><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset1['id']; ?>" size="10" readonly="readonly" /></td>
            <td class="view" align="center"><strong><u><a href="inputcvdetail.php?data=<?php echo $row_Recordset1['id']; ?>" target="_blank"><font size="3">Input Data Pelamar</font></a></u></strong></td>
            <td colspan="3" class="view" align="center"><strong><u><a href="editdetailcv.php?data=<?php echo $row_Recordset1['id']; ?>" target="_blank"><font size="3">Edit Data Pelamar</font></a></u></strong></td>
            </tr>
          <tr>
            <td width="161" class="view">No. Pelamar</td>
            <td width="12">:</td>
            <td width="266"><?php echo $row_Recordset1['no_pelamar']; ?></td>
            <td class="view">No. Telp</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['notlp']; ?></td>
          </tr>
          <tr>
            <td class="view">Nama</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
            <td class="view">Agama</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['agama']; ?></td>
          </tr>
          <tr>
            <td class="view">Jenis Kelamin</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['jk']; ?></td>
            <td width="120" class="view">Berat Badan</td>
            <td width="4">:</td>
            <td width="144"><?php echo $row_Recordset3['berat']; ?>Kg</td>
          </tr>
          <tr>
            <td class="view">Status</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['status']; ?></td>
            <td class="view">Tinggi Badan</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['tinggi']; ?>Cm</td>
          </tr>
          <tr>
            <td class="view">No. KTP</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['noktp']; ?></td>
            <td class="view">Pendidikan Terakhir</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['pendidikan']; ?></td>
          </tr>
          <tr>
            <td class="view"> Berlaku KTP Sampai dengan</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['berlakuktp']; ?></td>
            <td class="view">Nama Sekolah/PT</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['namapend']; ?></td>
          </tr>
          <tr>
            <td class="view">Tempat / Tgl. Lahir</td>
            <td>:</td>
            <td class="view"><strong><?php echo $row_Recordset3['tempat_lahir']; ?>, <?php echo $row_Recordset3['tgl_lahir']; ?></strong></td>
            <td class="view">Jurusan</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['jurusan']; ?></td>
          </tr>
          <tr>
            <td class="view">Umur</td>
            <td>:</td>
            <td class="view"> <?php
			$retrieved =$row_Recordset3['tgl_lahir']; 
			$date =substr($retrieved, -4) ; 
			$datenow=date('Y');
			$umur=$datenow-$date;
if ($umur>='2013')
  {
  echo "--";
  }
else
  {
  echo $umur.' '."Tahun";
  }
                    	
			?></td>
            <td class="view">No. KPJ</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['nokpj']; ?></td>
          </tr>
          <tr>
            <td class="view">Alamat Rumah</td>
            <td>:</td>
            <td class="view"><label><?php echo $row_Recordset3['alamat']; ?></label></td>
            <td class="view">Gol. Darah</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['gol_darah']; ?></td>
          </tr>
          <tr>
            <td class="view">Kode Pos </td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['poscode']; ?></td>
            <td class="view">No. NPWP</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['no_npwp']; ?></td>
          </tr>
          <tr>
            <td class="view">No. HP</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['nohp']; ?></td>
            <td class="view">Email</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['email']; ?></td>
          </tr>
          <tr>
            <td class="view">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          </div>
        <div class="TabbedPanelsContent">
	<div class="container">
	  <table width="555" class="table" id="celebs">
		  <thead>
            <tr class="tabel_header">
              <td>No</td>
              <td>Kategori</td>
              <td>Jenis Training</td>
              <td>Tanggal</td>
              <td>Tanggal Kadaluarsa</td>
              <td>No. Sertifikat </td>
              <td>Penyelenggara</td>
              <td>Catatan</td>
            </tr>
            </thead>
            <tbody>
            <?php do { ?>
              <tr class="tabel_body"><?php $n=$n+1; ?>
                <td><?php echo $n ?></td>
                <td><?php echo $row_Recordset11['kategori']; ?></td>
                <td><?php echo $row_Recordset11['jenis_training']; ?></td>
                <td><?php echo $row_Recordset11['date']; ?></td>
                <td><?php echo $row_Recordset11['exp_date']; ?></td>
                <td><?php echo $row_Recordset11['no_certificate']; ?></td>
                <td><?php echo $row_Recordset11['provider']; ?></td>
                <td><?php echo $row_Recordset11['remark']; ?></td>
              </tr>
              <?php } while ($row_Recordset11 = mysql_fetch_assoc($Recordset11)); ?>
              </tbody>
          </table>
          </div>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form3" name="form3" method="POST">
            <table border="1">
              <tr class="tabel_header">
                <td>No</td>
                <td>Tanggal</td>
                <td>Tanggal Kadaluarsa</td>
                <td>Kategori</td>
                <td>Status</td>
                <td>Catatan</td>
                <td>Saran</td>
              </tr>
              <?php do { ?>
                <tr class="tabel_body"><?php $i=$i+1; ?>
                  <td><?php echo $i ?></td>
                  <td><?php echo $row_Recordset4['date']; ?></td>
                  <td><?php echo $row_Recordset4['exp_date']; ?></td>
                  <td><?php echo $row_Recordset4['kategori']; ?></td>
                  <td><?php echo $row_Recordset4['status']; ?></td>
                  <td><?php echo $row_Recordset4['remark']; ?></td>
                  <td><?php echo $row_Recordset4['saran']; ?></td>
                </tr>
                <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form11" name="form11" method="post" action="">
            <table width="572" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="179" class="General">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="378">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Tanggal Berobat</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Biaya Pengobatan</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Obat dari Rawat Inap</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Rawat Inap</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Alat Bantu Dengar</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kacamata</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Gigi Palsu</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form14" name="form14" method="POST">
            <table width="649" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="idbantuan" type="text" class="hidentext" id="idbantuan" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="293">Jenis Bantuan/Santunan</td>
                <td width="10">:</td>
                <td width="346"><select name="bantuan" id="bantuan">
                  <option value="Beasiswa">Beasiswa</option>
                  <option value="Pernikahan">Pernikahan</option>
                  <option value="Khitan">Khitan</option>
                  <option value="Kematian Istri/Suami">Kematian Istri/Suami</option>
                  <option value="Kematian Anak">Kematian Anak</option>
                </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Nilai</td>
                <td>:</td>
                <td><input type="text" name="nilaibantuan" id="nilaibantuan" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><input type="text" name="tgl_bantuan" id="tanggal7" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit10" id="submit9" value="Submit" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <p>
  <?php {include "../date.php";}?>
</p>

<form action="<?$_SERVER['PHP_SELF']?>" method="post" name="pencarian" id="pencarian">
  <table border="1">
    <tr class="tabel_header">
      <td>No</td>
      <td>Pengalaman</td>
      <td>Nama Perusahaan</td>
      <td>Lokasi</td>
      <td>Bagian</td>
      <td>Jabatan</td>
      <td>Uraian</td>
      <td>Tanggal Masuk</td>
      <td>Tanggal Keluar</td>
    </tr>
    <?php do { ?>
      <tr class="tabel_body"><?php $j=$j+1; ?>
        <td><?php echo $j ?></td>
        <td><?php echo $row_Recordset5['pengalaman']; ?></td>
        <td><?php echo $row_Recordset5['nama_instansi']; ?></td>
        <td><?php echo $row_Recordset5['lokasi']; ?></td>
        <td><?php echo $row_Recordset5['bagian']; ?></td>
        <td><?php echo $row_Recordset5['jabatan']; ?></td>
        <td><?php echo $row_Recordset5['uraian']; ?></td>
        <td><?php echo $row_Recordset5['tgl_masuk']; ?></td>
        <td><?php echo $row_Recordset5['tgl_keluar']; ?></td>
      </tr>
      <?php } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>
  </table>
</form>
<p>&nbsp;</p>
          <br />
        </div>
        <div class="TabbedPanelsContent">
          <table border="1">
            <tr class="tabel_header">
              <td>No</td>
              <td>Nama Penghargaan</td>
              <td>Penyelenggara</td>
              <td>Tahun</td>
              <td>Catatan</td>
              <td>Tipe Penghargaan</td>
            </tr>
            <?php do { ?>
              <tr class="tabel_body"><?php $k=$k+1; ?>
                <td><?php echo $k ?></td>
                <td><?php echo $row_Recordset6['nama_penghargaan']; ?></td>
                <td><?php echo $row_Recordset6['provider']; ?></td>
                <td><?php echo $row_Recordset6['tahun']; ?></td>
                <td><?php echo $row_Recordset6['remark']; ?></td>
                <td><?php echo $row_Recordset6['tipe_penghargaan']; ?></td>
              </tr>
              <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
          </table>
        </div>
<div class="TabbedPanelsContent">
  <form id="form9" name="form9" method="POST">
    <table border="1">
      <tr class="tabel_header">
        <td>No</td>
        <td>Golongan S I M</td>
        <td>Masa Berlaku</td>
      </tr>
      <?php do { ?>
        <tr class="tabel_body"><?php $l=$l+1; ?>
          <td><?php echo $l ?></td>
          <td><?php echo $row_Recordset7['sim_gol']; ?></td>
          <td><?php echo $row_Recordset7['masaberlaku']; ?></td>
        </tr>
        <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
    </table>
  </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form8" name="form8" method="POST">
            <table width="651" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" class="General"><strong>Data Anggota Keluarga :</strong></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input name="idkel" type="text" class="hidentext" id="idkel" value="<?php echo $row_Recordset8['id_datapribadi']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="241" class="General">Hubungan Keluarga</td>
                <td width="11" class="General">:</td>
                <td width="399" class="General"><?php echo $row_Recordset8['hub_keluarga']; ?></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['nama']; ?></td>
              </tr>
              <tr>
                <td class="General">Tempat Lahir</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['tempat_lahir']; ?></td>
              </tr>
              <tr>
                <td class="General">Tanggal lahir</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['tgl_lahir']; ?></td>
              </tr>
              <tr>
                <td class="General">Umur</td>
                <td class="General">:</td>
                <td class="General"><span class="view">
                  <?php
			$retrieved =$row_Recordset8['tgl_lahir']; 
			$date =substr($retrieved, -4) ; 
			$datenow=date('Y');
			$umur=$datenow-$date;
if ($umur>='2013')
  {
  echo "--";
  }
else
  {
  echo $umur.' '."Tahun";
  }
                    	
			?>
                </span></td>
              </tr>
              <tr>
                <td class="General">Pekerjaan</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['pekerjaan']; ?></td>
              </tr>
              <tr>
                <td class="General">Jenis Kelamin</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['jk']; ?></td>
              </tr>
              <tr>
                <td class="General">Pendidikan</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['pendidikan']; ?></td>
              </tr>
              <tr>
                <td class="General">Agama</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['agama']; ?></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" class="General"><strong>Keluarga yang dapat dihubungi dalam keadaan Emergency (Tidak serumah)</strong></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Nama Saudara</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['emg_nama']; ?></td>
              </tr>
              <tr>
                <td class="General">Alamat Saudara</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['emg_alamat']; ?></td>
              </tr>
              <tr>
                <td class="General">No. Telp/HP</td>
                <td class="General">:</td>
                <td class="General"><?php echo $row_Recordset8['emg_telp']; ?></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form7" name="form7" method="POST">
            <table width="678" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="134">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="519"><input name="idortu" type="text" class="hidentext" id="idortu" value="<?php echo $row_Recordset9['id_datapribadi']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Nama Ayah</td>
                <td class="General">:</td>
                <td><?php echo $row_Recordset9['nama_ayah']; ?><br /></td>
              </tr>
              <tr>
                <td class="General">Nama Ibu</td>
                <td class="General">:</td>
                <td><?php echo $row_Recordset9['nama_ibu']; ?></td>
              </tr>
              <tr>
                <td class="General">Alamat</td>
                <td class="General">:</td>
                <td><?php echo $row_Recordset9['alamat']; ?></td>
              </tr>
              <tr>
                <td class="General">No. Telp</td>
                <td class="General">:</td>
                <td><?php echo $row_Recordset9['telp']; ?></td>
              </tr>
              <tr>
                <td class="General">No. HP</td>
                <td class="General">:</td>
                <td><?php echo $row_Recordset9['nohp']; ?></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form10" name="form10" method="POST">
            <table width="207" border="1">
              <tr class="tabel_header" >
                <td>No </td>
                <td>Bahasa</td>
                <td>Predikat</td>
              </tr>
              <?php do { ?>
                <tr class="tabel_body"><?php $m=$m+1; ?>
                  <td><?php echo $m ?></td>
                  <td><?php echo $row_Recordset10[bahasa]; ?></td>
                  <td><?php echo $row_Recordset10[predikat]; ?></td>
                </tr>
                <?php } while ($row_Recordset10 = mysql_fetch_assoc($Recordset10)); ?>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form2" name="form2" method="post" action="">
            <table width="327" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" size="8" /></td>
              </tr>
              <tr>
                <td class="General">Posisi yang dilamar</td>
                <td>:</td>
                <td><?php echo $row_Recordset12['posisi']; ?></td>
              </tr>
              <tr>
                <td class="General">Reference</td>
                <td>:</td>
                <td><?php echo $row_Recordset12['reference']; ?></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <table width="284" border="1">
            <tr class="tabel_header">
              <td>NO</td>
              <td>Inisial Pekerjaan</td>
              <td>Tanggal</td>
              <td>Nama File </td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <?php $t=$t+1; ?>
              <td><?php echo $t ?></td>
              <td><?php echo $row_Recordset13[inisial_pekerjaan]; ?></td>
              <td><?php echo $row_Recordset13[date]; ?></td>
              <td><a href="../hrd/upload/<?php echo $row_Recordset13['fileupload']; ?>" target="_blank"></a><a href="../hrd/upload/<?php echo $row_Recordset13['fileupload']; ?>" target="_blank"><?php echo $row_Recordset13[fileupload]; ?></a></td>
            </tr>
            <?php } while ($row_Recordset13 = mysql_fetch_assoc($Recordset13)); ?>
          </table>
        </div>
        <div class="TabbedPanelsContent">Content 14
          <form id="form13" name="form13" method="post" action="">
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <table width="956" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td colspan="2" class="General"><strong>Identitas Personnel</strong></td>
              <td><input name="id_pelamar2" type="hidden" id="id_pelamar2" value="<?php echo $row_Recordset1['id']; ?>" /></td>
              <td width="150" class="General"><strong>Riwayat Pekerjaan</strong></td>
              <td width="11">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="190" class="General">No. Pelamar</td>
              <td width="10" class="General">:</td>
              <td width="302"><?php echo $row_Recordset1['no_pelamar']; ?></td>
              <td colspan="2" class="General">&nbsp;</td>
              <td width="286">&nbsp;    </td>
            </tr>
            <tr>
              <td class="General">Nama</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
              <td rowspan="3" class="General">Riwayat Pekerjaan</td>
              <td rowspan="3">:</td>
              <td rowspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td class="General">Jenis Kelamin</td>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="General">Alamat</td>
              <td class="General">:</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="General">No. Telepon / HP</td>
              <td class="General">:</td>
              <td>&nbsp;</td>
              <td rowspan="3" class="General">Skill yang mendukung</td>
              <td rowspan="3">:</td>
              <td rowspan="3"><?php echo $row_Recordset14['skill']; ?></td>
            </tr>
            <tr>
              <td class="General">Agama</td>
              <td class="General">:</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="General">Suku</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['suku']; ?></td>
            </tr>
            <tr>
              <td class="General">Tinggi Badan</td>
              <td class="General">:</td>
              <td>&nbsp;</td>
              <td rowspan="3" class="General">Leadership</td>
              <td rowspan="3">:</td>
              <td rowspan="3"><?php echo $row_Recordset14['leadership']; ?></td>
            </tr>
            <tr>
              <td class="General">Berat Badan</td>
              <td class="General">:</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="41" class="General">Penyakit Bawaan</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['penyakit_bawaan']; ?></td>
            </tr>
            <tr>
              <td colspan="2" class="General"><strong>Riwayat Pendidikan</strong></td>
              <td>&nbsp;</td>
              <td rowspan="2">Loyalitas</td>
              <td rowspan="2">:</td>
              <td rowspan="2"><?php echo $row_Recordset14['loyalitas']; ?></td>
            </tr>
            <tr>
              <td class="General">SD Tahun</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['sd_tahun']; ?></td>
            </tr>
            <tr>
              <td class="General">SLTP. Tahun</td>
              <td class="General">&nbsp;</td>
              <td><?php echo $row_Recordset14['sltp_tahun']; ?></td>
              <td rowspan="2" class="General">Tanggung Jawab</td>
              <td rowspan="2">:</td>
              <td rowspan="2"><?php echo $row_Recordset14['tanggung_jawab']; ?></td>
            </tr>
            <tr>
              <td class="General">SLTA Tahun</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['slta_tahun']; ?></td>
            </tr>
            <tr>
              <td class="General">Pendidikan Terakhir</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['pend_terakhir']; ?></td>
              <td rowspan="2" class="General">Bakat dalam Pekerjaan</td>
              <td rowspan="2">:</td>
              <td rowspan="2"><?php echo $row_Recordset14['bakat']; ?></td>
            </tr>
            <tr>
              <td class="General">Fakultas / Jurusan</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['jurusan']; ?></td>
            </tr>
            <tr>
              <td class="General">IPK</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['ipk']; ?></td>
              <td rowspan="2" class="General">Kepribadian</td>
              <td rowspan="2">:</td>
              <td rowspan="2"><?php echo $row_Recordset14['kepribadian']; ?></td>
            </tr>
            <tr>
              <td class="General">Gaji yang di inginkan</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['gaji_diinginkan']; ?></td>
            </tr>
            <tr>
              <td class="General">Bagian/ Posisi yang diinginkan</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['posisi_dilamar']; ?></td>
              <td class="General">Kemampuan Intelektual</td>
              <td>:</td>
              <td><?php echo $row_Recordset14['intelektual']; ?></td>
            </tr>
            <tr>
              <td class="General">Date</td>
              <td class="General">:</td>
              <td><?php echo $row_Recordset14['date_interview']; ?></td>
              <td class="General">Kesimpulan</td>
              <td>:</td>
              <td><?php echo $row_Recordset14['kesimpulan']; ?></td>
            </tr>
            <tr>
              <td class="General">Pelaksana</td>
              <td>:</td>
              <td><?php echo $row_Recordset14['pelaksana_interview']; ?></td>
              <td class="General">Saran</td>
              <td>:</td>
              <td><?php echo $row_Recordset14['saran']; ?></td>
            </tr>
            <tr>
              <td colspan="6" class="General" align="center">&nbsp;</td>
            </tr>
          </table>
        </div>
        <div class="TabbedPanelsContent">Content 16</div>
<div class="TabbedPanelsContent">Content 17</div>
      </div>
<p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="625" colspan="2" align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);

mysql_free_result($Recordset11);

mysql_free_result($Recordset12);

mysql_free_result($Recordset13);

mysql_free_result($Recordset14);
?>
