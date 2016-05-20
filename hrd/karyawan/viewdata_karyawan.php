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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_Recordset1, "text"));
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
$query_Recordset3 = sprintf("SELECT * FROM h_datapribadi WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_mcu WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM h_experiences WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_penghargaan WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_sim WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_datakeluarga WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset8, "int"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_dataortu WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset9, "int"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM h_bahasa WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset10, "int"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT h_training.*, h_kategori_training.nama_kategori FROM h_training, h_kategori_training WHERE id_h_employee = %s AND h_kategori_training.id_kategori = h_training.kategori", GetSQLValueString($colname_Recordset11, "int"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

$colname_Recordset12 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset12 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset12 = sprintf("SELECT * FROM h_job_position WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset12, "int"));
$Recordset12 = mysql_query($query_Recordset12, $core) or die(mysql_error());
$row_Recordset12 = mysql_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysql_num_rows($Recordset12);

$colname_Recordset13 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset13 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset13 = sprintf("SELECT * FROM dms WHERE idms = %s  AND dms.id_departemen = 'HRD'", GetSQLValueString($colname_Recordset13, "text"));
$Recordset13 = mysql_query($query_Recordset13, $core) or die(mysql_error());
$row_Recordset13 = mysql_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysql_num_rows($Recordset13);

$colname_Recordset14 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset14 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset14 = sprintf("SELECT * FROM h_children WHERE id_employee = %s", GetSQLValueString($colname_Recordset14, "int"));
$Recordset14 = mysql_query($query_Recordset14, $core) or die(mysql_error());
$row_Recordset14 = mysql_fetch_assoc($Recordset14);
$totalRows_Recordset14 = mysql_num_rows($Recordset14);

$colname_Recordset15 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset15 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset15 = sprintf("SELECT * FROM h_bpjs_idcard WHERE id_employee = %s", GetSQLValueString($colname_Recordset15, "int"));
$Recordset15 = mysql_query($query_Recordset15, $core) or die(mysql_error());
$row_Recordset15 = mysql_fetch_assoc($Recordset15);
$totalRows_Recordset15 = mysql_num_rows($Recordset15);

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD - Detail Data Karyawan</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
<script src="../../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />

<link href="/css/induk.css" media="screen" rel="stylesheet" type="text/css" />
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
<?php { include "../../date.php"; require_once "../../dateformat_funct.php"; } ?>
<table width="1270" border="0" align="center">
 <tr>
    <td height="64" colspan="3" rowspan="2"><img src="../../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="649" align="right" valign="top"><table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>
        <td width="10" align="right" valign="middle" class="demoHeaders">|</td>
        <td width="300" align="right" valign="middle" class="demoHeaders">Your Logged as <a href="viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?> </b></a></td>
        <td width="11" class="demoHeaders">|</a></td>
        <td width="90" class="demoHeaders"><a href="../../contact.php">Contact Us</a></td>
        <td width="11" class="demoHeaders">|</td>
        <td width="65" class="demoHeaders"><a href="<?php echo $logoutAction ?>;">Logout</a></td>
        <td align="right" width="18" class="demoHeaders">|</td>
      </tr>
    </table></td></tr>
    
    <tr>
    <td align="right" valign="bottom">
		<?php { include "../../menu_notification.php"; } ?>
    </td>
  </tr>
    
    <td colspan="4" align="right" bgcolor="#8db4e3" class="root" id="font"><table width="600" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root"><a href="../home_hrd.php">HRD / GAFF</a></td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="484" align="left" class="root"><?php echo $row_Recordset1['nik']; ?> - <?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
        </tr>
    </table></td>
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
        <li class="TabbedPanelsTab" tabindex="0">Children Data</li>
        <li class="TabbedPanelsTab" tabindex="0">Parent Data</li>
        <li class="TabbedPanelsTab" tabindex="0">Languange</li>
        <li class="TabbedPanelsTab" tabindex="0">Job Position</li>
        <li class="TabbedPanelsTab" tabindex="0">BPJS &amp; ID Card</li>
        <li class="TabbedPanelsTab" tabindex="0">Attachment</li>
        <li class="TabbedPanelsTab" tabindex="0">Skill test</li>
        <li class="TabbedPanelsTab" tabindex="0">Interviews</li>
        <li class="TabbedPanelsTab" tabindex="0">Psikotes &amp; MCU</li>
        <li class="TabbedPanelsTab" tabindex="0">Selection</li>
      </ul>
      
      
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <form id="form1" name="form1" method="POST">
            <table width="1448" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td></td>
                <td>&nbsp;</td>
                <td><strong><u><a href="datakaryawan.php?data=<?php echo $row_Recordset1['id']; ?>" target="_blank"><font size="3">Input  Data Karyawan</font></a></u></strong></td>
                <td colspan="3"><strong><u><a href="editdetailkaryawan.php?data=<?php echo $row_Recordset1['id']; ?>" target="_blank"><font size="3">Edit Data Karyawan</font></a></u></strong></td>
                </tr>
              <tr>
                <td width="164"></td>
                <td width="8">&nbsp;</td>
                <td width="393"><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset1['id_datapribadi']; ?>" size="5" readonly="readonly" /></td>
                <td width="165">&nbsp;</td>
                <td width="13">&nbsp;</td>
                <td width="705">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="General">Jenis Kelamin</span></td>
                <td>:</td>
                <td><?php echo $row_Recordset3['jk']; ?></td>
                <td>Ukuran Baju</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['ukuran_baju']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['status']; ?></td>
                <td>Ukuran Celana</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['ukuran_celana']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>No. KTP</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['noktp']; ?></td>
                <td>Coverall (Dale)</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['Coverall']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Berlaku KTP Sampai dengan</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['berlakuktp']; ?></td>
                <td>Ukuran Sepatu (Safety)</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['ukuran_sepatu']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td><strong><?php echo $row_Recordset3['tempat_lahir']; ?>/<?php echo $row_Recordset3['tgl_lahir']; ?></strong></td>
                <td>Pendidikan Terakhir</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['pendidikan']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Umur</td>
                <td>:</td>
                <td><?php
				$retrieved =$row_Recordset3['tgl_lahir']; 
				$date =substr($retrieved, -4) ; 
				$datenow=date('Y');
				$umur=$datenow-$date;
				if ($umur >= '2014') {
					echo "--";
				} else {
					echo $umur.' '."Tahun";
				} ?></td>
                <td>Nama Sekolah / PT</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['namapend']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Alamat Rumah</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['alamat']; ?></td>
                <td>Jurusan</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['jurusan']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Kode Pos </td>
                <td>:</td>
                <td><?php echo $row_Recordset3['poscode']; ?></td>
                <td>No. KPJ</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['nokpj']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['notlp']; ?></td>
                <td>Gol. Darah</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['gol_darah']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['nohp']; ?></td>
                <td>No. NPWP</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['no_npwp']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['agama']; ?></td>
                <td>Email</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['email']; ?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Berat Badan</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['berat']; ?> Kg</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tinggi Badan</td>
                <td>:</td>
                <td><?php echo $row_Recordset3['tinggi']; ?> Cm</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
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
        
        
    <!-- SHOW DATA TRAINING -->
	<div class="container">
	  <table width="100%" border="1" class="table" id="celebs">
		  <thead>
            <tr class="tabel_header" height="30">
              <td>No.</td>
              <td>Category</td>
              <td>Type of Training</td>
              <td>Date of Training</td>
              <td>Expired Date</td>
              <td>Certificate No.</td>
              <td>Provider</td>
              <td>Remark</td>
            </tr>
            </thead>
            <tbody>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php $n=$n+1; echo $n ?></td>
                <td><?php echo $row_Recordset11['nama_kategori']; ?></td>
                <td><?php echo $row_Recordset11['jenis_training']; ?></td>
                <td align="center"><?php echo $row_Recordset11['date']; ?></td>
                <td align="center"><?php echo functddmmmyyyy($row_Recordset11['exp_date']); ?></td>
                <td><?php echo $row_Recordset11['no_certificate']; ?></td>
                <td><?php echo $row_Recordset11['provider']; ?></td>
                <td><?php echo $row_Recordset11['remark']; ?></td>
              </tr>
              <?php } while ($row_Recordset11 = mysql_fetch_assoc($Recordset11)); ?></tbody>
          </table>
          </div>
        </div>
        
        
        <!-- SHOW DATA MCU -->
        <div class="TabbedPanelsContent">
          <form id="form3" name="form3" method="POST">
            <table width="100%">
              <tr class="tabel_header" height="30">
                <td>No.</td>
                <td>Date of MCU</td>
                <td>Expired Date</td>
                <td>Category</td>
                <td>Status</td>
                <td>Remark</td>
                <td>Advice</td>
              </tr>
              <?php do { ?>
                <tr class="tabel_body">
                  <td align="center"><?php $o=$o+1; echo $o ?></td>
                  <td align="center"><?php echo functddmmmyyyy($row_Recordset4['date']); ?></td>
                  <td align="center"><?php echo functddmmmyyyy($row_Recordset4['exp_date']); ?></td>
                  <td align="center"><?php echo $row_Recordset4['kategori']; ?></td>
                  <td align="center"><?php echo $row_Recordset4['status']; ?></td>
                  <td><?php echo $row_Recordset4['remark']; ?></td>
                  <td><?php echo $row_Recordset4['saran']; ?></td>
                </tr>
                <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
            </table>
          </form>
        </div>
        
        
        <!-- DATA PENGOBATAN -->
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
        
        
        <!-- SHOW DATA BANTUAN -->
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
        
        
        <!-- SHOW DATA EXPERIENCES -->
        <div class="TabbedPanelsContent">
          <p><?php { require_once "../date.php"; } ?></p>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="pencarian" id="pencarian">
              <table width="100%">
                <tr class="tabel_header" height="30">
                  <td>No.</td>
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
                  <tr class="tabel_body">
                    <td width="25" align="center"><?php $p= $p+1; echo $p ?></td>
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
        </div>
        
        
        <!-- SHOW DATA APPRECIATE -->
        <div class="TabbedPanelsContent">
          <table width="100%">
            <tr class="tabel_header" height="30">
              <td>No.</td>
              <td>Nama Penghargaan</td>
              <td>Penyelenggara</td>
              <td>Tahun</td>
              <td>Catatan</td>
              <td>Tipe Penghargaan</td>
            </tr>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php $q=$q+1; echo $q ?></td>
                <td><?php echo $row_Recordset6['nama_penghargaan']; ?></td>
                <td><?php echo $row_Recordset6['provider']; ?></td>
                <td><?php echo $row_Recordset6['tahun']; ?></td>
                <td><?php echo $row_Recordset6['remark']; ?></td>
                <td><?php echo $row_Recordset6['tipe_penghargaan']; ?></td>
              </tr>
              <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
          </table>
        </div>
        
        
        <!-- SHOW DATA DRIVING LANGUAGE (SIM) -->
        <div class="TabbedPanelsContent">
          <form id="form9" name="form9" method="POST">
            <table border="1" width="200">
              <tr class="tabel_header">
                <td width="20">No.</td>
                <td width="80">Golongan SIM</td>
                <td width="100">Expired Date</td>
              </tr>
              <?php do { ?>
                <tr class="tabel_body">
                  <td align="center"><?php $r=$r+1; echo $r ?></td>
                  <td align="center"><?php echo $row_Recordset7['sim_gol']; ?></td>
                  <td align="center"><?php echo functddmmmyyyy($row_Recordset7['masaberlaku']); ?></td>
                </tr>
                <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
            </table>
          </form>
        </div>
        
        
        <!-- SHOW DATA FAMILY -->
        <div class="TabbedPanelsContent">
          <form id="form8" name="form8" method="POST">
            <table width="650" border="0" cellspacing="0" cellpadding="0">
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
                <td class="General"><?php
					$retrieved =$row_Recordset8['tgl_lahir']; 
					$date =substr($retrieved, -4) ; 
					$datenow=date('Y');
					$umur=$datenow-$date;
					if ($umur>='2013') {
						echo "--";
					} else {
						echo $umur.' '."Tahun";
					} ?>
				</td>
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
         <table border="0">
           <tr class="tabel_header">
             <td>No</td>
             <td>Nama Anak</td>
             <td>L/P</td>
             <td>Tempat Lahir</td>
             <td>Tanggal Lahir</td>
             <td>Umur</td>
             <td>Pendidikan Terakhir</td>
           </tr>
           <tr class="tabel_body"><?php $a=$a+1; ?>
             <td><?php echo $a; ?></td>
             <td><?php echo $row_Recordset14['nama_anak']; ?></td>
             <td><?php echo $row_Recordset14['jk']; ?></td>
             <td><?php echo $row_Recordset14['tempat_lahir']; ?></td>
             <td><?php echo $row_Recordset14['tanggal_lahir']; ?></td>
             <td><?php
				$retrieved =$row_Recordset14['tanggal_lahir']; 
				$date =substr($retrieved, -4) ; 
				$datenow=date('Y');
				$umur=$datenow-$date;
				if ($umur >= '2014') {
					echo "--";
				} else {
					echo $umur.' '."Tahun";
				} ?></td>
             <td><?php echo $row_Recordset14['pendidikan_terakhir']; ?></td>
           </tr>
         </table> 
       
       </div>
        
        <!-- SHOW DATA PARENT -->
        <div class="TabbedPanelsContent">
          <form id="form7" name="form7" method="POST">
            <table width="700" border="0" cellspacing="0" cellpadding="0">
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
        
        
        <!-- SHOW DATA LANGUAGE -->
        <div class="TabbedPanelsContent">
          <form id="form10" name="form10" method="POST">
            <table width="300" border="1">
              <tr class="tabel_header" height="30">
                <td width="30">No.</td>
                <td>Language</td>
                <td>Predicate</td>
              </tr>
              <?php do { ?>
                <tr class="tabel_body">
                  <td align="center"><?php echo $s=$s+1; $s; ?></td>
                  <td><?php echo $row_Recordset10[bahasa]; ?></td>
                  <td><?php echo $row_Recordset10[predikat]; ?></td>
                </tr>
                <?php } while ($row_Recordset10 = mysql_fetch_assoc($Recordset10)); ?>
            </table>
          </form>
        </div>
        
        
       <!-- SHOW DATA JOB POSITION -->
        <div class="TabbedPanelsContent">
          <form id="form2" name="form2" method="post" action="">
            <table width="327" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id_pelamar']; ?>" size="8" /></td>
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
        <!-- INPUT DATA BPJS -->
        <div class="TabbedPanelsContent">
          <form id="form15" name="form15">
            <table border="0">
              <tr class="tabel_header">
                <td colspan="6">BPJS </td>
                </tr>
              <tr>
                <td>No. BPJS Ketenagakerjaan</td>
                <td>:</td>
                <td><?php echo $row_Recordset15['nobpjs_tk']; ?></td>
                <td>Tanggal Kepesertaan</td>
                <td>:</td>
                <td><?php echo $row_Recordset15['tgl_tk']; ?></td>
              </tr>
              <tr>
                <td>No. BPJS Kesehatan</td>
                <td>&nbsp;</td>
                <td><?php echo $row_Recordset15['nobpjs_kes']; ?></td>
                <td>Tanggal Kepesertaan</td>
                <td>:</td>
                <td><?php echo $row_Recordset15['tgl_kes']; ?></td>
              </tr>
              <tr class="tabel_header">
                <td colspan="6">ID Card</td>
                </tr>
              <tr>
                <td>ID Card Chevron</td>
                <td>&nbsp;</td>
                <td><?php echo $row_Recordset15['id_chev']; ?></td>
                <td>Tanggal Pembuatan - Expired</td>
                <td>&nbsp;</td>
                <td><?php echo $row_Recordset15['tgl_buat_chev']; ?> - <?php echo $row_Recordset15['tgl_exp_chev']; ?></td>
              </tr>
              <tr>
                <td>ID Card Bukaka</td>
                <td>:</td>
                <td><?php echo $row_Recordset15['id_bkk']; ?></td>
                <td>Tanggal Pembuatan - Expired</td>
                <td>&nbsp;</td>
                <td><?php echo $row_Recordset15['tgl_buat_bkk']; ?> - <?php echo $row_Recordset15['tgl_exp_bkk']; ?></td>
              </tr>
              <tr align="center">
                <td colspan="6">&nbsp;</td>
                </tr>
            </table>
          </form>
        </div>
        
        <!-- SHOW ATTACHMENT -->
        <div class="TabbedPanelsContent">
          <table width="600" border="1">
            <tr class="tabel_header" height="30">
              <td width="30">No.</td>
              <td>Job Initial</td>
              <td>Date</td>
              <td>Name of File</td>
            </tr>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php $t=$t+1; echo $t; ?></td>
                <td><?php echo $row_Recordset13[inisial_pekerjaan]; ?></td>
                <td><?php echo $row_Recordset13[date]; ?></td>
                <td><a href="../upload/<?php echo $row_Recordset13['fileupload']; ?>" target="_blank"><?php echo $row_Recordset13[fileupload]; ?></a></td>
              </tr>
              <?php } while ($row_Recordset13 = mysql_fetch_assoc($Recordset13)); ?>
          </table>
        </div>
        
        
        <div class="TabbedPanelsContent">Content 14
          <form id="form13" name="form13" method="post" action="">
          </form>
        </div>
        
        <div class="TabbedPanelsContent">Content 15</div>
        <div class="TabbedPanelsContent">Content 16</div>
        <div class="TabbedPanelsContent">Content 17</div>
      </div>
      
	<p>&nbsp;</p>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
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

mysql_free_result($Recordset15);
?>
