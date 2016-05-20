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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_datapribadi (id_h_employee, jk, status, noktp, berlakuktp, tempat_lahir, tgl_lahir, alamat, poscode, notlp, nohp, agama, berat, tinggi, ukuran_baju, ukuran_celana, Coverall, ukuran_sepatu, pendidikan, jurusan, namapend, nokpj, gol_darah, no_npwp, email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_datapribadi'], "int"),
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['noktp'], "text"),
                       GetSQLValueString($_POST['berlakuktp'], "text"),
                       GetSQLValueString($_POST['tempatlahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['poscode'], "text"),
                       GetSQLValueString($_POST['notlp'], "text"),
                       GetSQLValueString($_POST['nohp'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['berat'], "text"),
                       GetSQLValueString($_POST['tinggi'], "text"),
                       GetSQLValueString($_POST['ukuran_baju'], "text"),
                       GetSQLValueString($_POST['ukuran_celana'], "int"),
                       GetSQLValueString($_POST['coverall'], "text"),
                       GetSQLValueString($_POST['ukuran_sepatu'], "int"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['namapend'], "text"),
                       GetSQLValueString($_POST['nokpj'], "text"),
                       GetSQLValueString($_POST['gol_darah'], "text"),
                       GetSQLValueString($_POST['no_npwp'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO h_job_position (id_h_employee, posisi, reference) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_pelamar'], "int"),
                       GetSQLValueString($_POST['posisi'], "text"),
                       GetSQLValueString($_POST['referance'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, inisial_pekerjaan, `date`, fileupload) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmscb'], "text"),
                       GetSQLValueString($_POST['inisialpr2'], "text"),
                       GetSQLValueString($_POST['datepr2'], "text"),
                       GetSQLValueString($_POST['nama_filepr2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
	{ require_once "dateformat_funct.php"; }
	
  $insertSQL = sprintf("INSERT INTO h_mcu (id_h_employee, `date`, exp_date, kategori, status, remark, saran) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idmcu'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['date']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['exp_date']), "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['status2'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['saran'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form4")) {
  $insertSQL = sprintf("INSERT INTO h_experiences (id_h_employee, pengalaman, nama_instansi, lokasi, bagian, jabatan, uraian, tgl_masuk, tgl_keluar) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idexp'], "int"),
                       GetSQLValueString($_POST['pengalaman'], "text"),
                       GetSQLValueString($_POST['nama_instansi'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['bagian'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['uraian'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "text"),
                       GetSQLValueString($_POST['tgl_keluar'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form5")) {
  $insertSQL = sprintf("INSERT INTO h_penghargaan (id_h_employee, nama_penghargaan, provider, tahun, remark, tipe_penghargaan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idapr'], "int"),
                       GetSQLValueString($_POST['nama_penghargaan'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['tahun'], "text"),
                       GetSQLValueString($_POST['remark2'], "text"),
                       GetSQLValueString($_POST['tipe_penghargaan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form9")) {
	{ require_once "dateformat_funct.php"; }
	
  $insertSQL = sprintf("INSERT INTO h_sim (id_h_employee, sim_gol, masaberlaku) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idsim'], "int"),
                       GetSQLValueString($_POST['sim_gol'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['masa_berlaku']), "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form8")) {
  $insertSQL = sprintf("INSERT INTO h_datakeluarga (id_h_employee, emg_nama, emg_alamat, emg_telp, hub_keluarga, nama, tempat_lahir, tgl_lahir, pekerjaan, jk, pendidikan, agama) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idkel'], "int"),
                       GetSQLValueString($_POST['emg_nama'], "text"),
                       GetSQLValueString($_POST['emg_alamat'], "text"),
                       GetSQLValueString($_POST['emg_telp'], "text"),
                       GetSQLValueString($_POST['hub_keluarga'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['pekerjaan'], "text"),
                       GetSQLValueString($_POST['jk2'], "text"),
                       GetSQLValueString($_POST['pendidikan2'], "text"),
                       GetSQLValueString($_POST['agama2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form7")) {
  $insertSQL = sprintf("INSERT INTO h_dataortu (id_h_employee, nama_ayah, nama_ibu, alamat, telp, nohp) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idortu'], "int"),
                       GetSQLValueString($_POST['nama_ayah'], "text"),
                       GetSQLValueString($_POST['nama_ibu'], "text"),
                       GetSQLValueString($_POST['alamat2'], "text"),
                       GetSQLValueString($_POST['telp'], "text"),
                       GetSQLValueString($_POST['nohp2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form11")) {
	{ require_once "dateformat_funct.php"; }

  $insertSQL = sprintf("INSERT INTO h_training (id_h_employee, kategori, jenis_training, `date`, exp_date, no_certificate, provider, remark) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_datapribadi2'], "int"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['jenis_training'], "text"),
                       GetSQLValueString($_POST['tanggal'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['exp_date']), "date"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['remark'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form14")) {
  $insertSQL = sprintf("INSERT INTO h_bantuan (id_datapribadi, jenis_bantuan, tanggal, nilai) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_bantuan'], "text"),
                       GetSQLValueString($_POST['bantuan'], "text"),
                       GetSQLValueString($_POST['tgl_bantuan'], "text"),
                       GetSQLValueString($_POST['nilaibantuan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form10")) {
  $insertSQL = sprintf("INSERT INTO h_bahasa (id_h_employee, bahasa, predikat) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idbahasa'], "int"),
                       GetSQLValueString($_POST['bahasa'], "text"),
                       GetSQLValueString($_POST['predikat'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form12")) {
  $insertSQL = sprintf("INSERT INTO h_children (id_employee, nama_anak, jk, tempat_lahir, tanggal_lahir, pendidikan_terakhir) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_employee'], "int"),
                       GetSQLValueString($_POST['nama_anak'], "text"),
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['pendidikan_terakhir'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form15")) {
  $insertSQL = sprintf("INSERT INTO h_bpjs_idcard (id_employee, nobpjs_tk, nobpjs_kes, tgl_tk, tgl_kes, id_chev, id_bkk, tgl_buat_chev, tgl_exp_chev, tgl_buat_bkk, tgl_exp_bkk) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_employee2'], "int"),
                       GetSQLValueString($_POST['nobpjs_tk'], "text"),
                       GetSQLValueString($_POST['nobpjs_kes'], "text"),
                       GetSQLValueString($_POST['tgl_tk'], "text"),
                       GetSQLValueString($_POST['tgl_kes'], "text"),
                       GetSQLValueString($_POST['id_chev'], "text"),
                       GetSQLValueString($_POST['id_bkk'], "text"),
                       GetSQLValueString($_POST['tgl_buat_chev'], "text"),
                       GetSQLValueString($_POST['tgl_exp_chev'], "text"),
                       GetSQLValueString($_POST['tgl_buat_bkk'], "text"),
                       GetSQLValueString($_POST['tgl_exp_bkk'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
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
$query_Recordset3 = sprintf("SELECT * FROM h_datapribadi WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_mcu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset4, "int"));
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
$query_Recordset7 = sprintf("SELECT * FROM h_sim WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_datakeluarga WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset8, "int"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_dataortu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset9, "int"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM h_training WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset11, "int"));
$Recordset11 = mysql_query($query_Recordset11, $core) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM h_children WHERE id_employee = %s", GetSQLValueString($colname_Recordset10, "int"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../css/button.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD- Input Data Karyawan</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function datediff($tgl1, $tgl2){
	$tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	$tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
	$diff_secs = abs($tgl1 - $tgl2);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	return array (
		"years" => date("Y", $diff) - $base_year,
		"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
		"months" => date("n", $diff) - 1,
		"days_total" => floor($diff_secs / (3600 * 24)),
		"days" => date("j", $diff) - 1 ),
		"hours_total" => floor($diff_secs / 3600),
		"hours" => date("G", $diff),
		"minutes_total" => floor($diff_secs / 60),
		"minutes" => (int) date("i", $diff),
		"seconds_total" => $diff_secs,
		"seconds" => (int) date("s", $diff)
	);
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

</head>

<body>
<?php { include "date.php"; } ?>
<table width="1270" border="0" align="center">
  <tr>
    <td width="594" height="64" colspan="3" rowspan="2"><img src="file:///C|/inetpub/wwwroot/images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="625" colspan="2" align="right" valign="top"><table width="420" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr valign="middle">
        <td width="10" align="right" class="demoHeaders">|</td>
        <td width="350" align="right" class="demoHeaders">Your Logged as <a href="../../karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b>
		<?php echo $_SESSION['MM_Username']; ?></b></a></td>
        <td width="11" class="demoHeaders">|</a></td>
        <td width="106" class="demoHeaders"><a href="file:///C|/inetpub/wwwroot/contact.php">Contact Us</a></td>
        <td width="11" class="demoHeaders">|</td>
        <td width="107" class="demoHeaders"><a href="<?php echo $logoutAction ?>">Logout</a></td>
        <td align="right" width="5" class="demoHeaders">|</td>
      </tr>
    </table>
    </td>
  </tr>
    <tr>
    <td align="right" valign="bottom">
		<?php { require_once "../../menu_notification.php"; } ?>
    </td>
  </tr>
  
  <tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" id="font"><table width="635" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="file:///C|/inetpub/wwwroot/home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root">HRD/GAFF</td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="519" align="left" class="root"><form id="form6" name="form6" method="post" action="">
          <?php echo $row_Recordset1['nik']; ?>
          - 
          <?php echo $row_Recordset1['firstname']; ?>
        </form></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5" align="left" class="General" id="font">
	<?php
		if ($_GET[modul]=='unapproved'){
			echo '<iframe src="tm/unapproved_crf.php" width="1200" height="550" style="border:thin"></iframe>';
		} elseif ($_GET[modul]=='notif'){
			?><iframe src="prj/bacanotif.php?data=<?php echo $usrid; ?>" width="1200" height="550" style="border:thin"></iframe><?php
		} else { ?>    
    
    <div id="TabbedPanels1" class="VTabbedPanels">
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
          <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
            <table width="1448" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td width="164">&nbsp;</td>
                <td width="8">&nbsp;</td>
                <td width="393"><input name="id_datapribadi" type="hidden" id="id_datapribadi" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
                <td width="165">&nbsp;</td>
                <td width="13">&nbsp;</td>
                <td width="705">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="General">Jenis Kelamin</span></td>
                <td>:</td>
                <td><input type="radio" name="jk" value="Pria" <?php echo ($row_Recordset3['jk']=='Pria')?'checked':'' ?> size="17">Pria

<input type="radio" name="jk" value="Wanita" <?php echo ($row_Recordset3['jk']=='Wanita')?'checked':'' ?> size="17">Wanita
                </td>
                <td>Ukuran Baju</td>
                <td>:</td>
                <td>
                  <select name="ukuran_baju" id="ukuran_baju">
                    <option value="" selected="selected">-Ukuran Baju-</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                  <select name="status" id="status2">
                    <option value="" selected="selected">-Status-</option>
                    <option value="TK/0">TK/O</option>
                    <option value="TK/1">TK/1</option>
                    <option value="TK/2">TK/2</option>
                    <option value="TK/3">TK/3</option>
                    <option value="K/0">K/0</option>
                    <option value="K/1">K/1</option>
                    <option value="K/2">K/2</option>
                    <option value="K/3">K/3</option>
                  </select></td>
                <td>Ukuran Celana</td>
                <td>:</td>
                <td>
                  <select name="ukuran_celana" id="ukuran_celana">
                    <option value="" selected="selected">-Ukuran Celana-</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                  </select></td>
              </tr>
              <tr>
                <td>No. KTP</td>
                <td>:</td>
                <td>
                  <input type="text" name="noktp" id="noktp" /></td>
                <td>Coverall (Dale)</td>
                <td>:</td>
                <td>
                  <select name="coverall" id="coverall">
                    <option value="" selected="selected">-Coverall-</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
                  </select></td>
              </tr>
              <tr>
                <td> Berlaku KTP Sampai dengan</td>
                <td>:</td>
                <td><input type="text" name="berlakuktp" id="tanggal3" /></td>
                <td>Ukuran Sepatu (Safety)</td>
                <td>:</td>
                <td>
                  <select name="ukuran_sepatu" id="ukuran_sepatu">
                    <option value="" selected="selected">-Ukuran Sepatu-</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    </select>
                 </td>
              </tr>
              <tr>
                <td>Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td><b>
                  <input type="text" name="tempatlahir" id="tempatlahir" />
                  /
                  
                  <input type="text" name="tgl_lahir" id="tanggal4" />
                  </b></td>
                <td>Pendidikan Terakhir</td>
                <td>:</td>
                <td>
                  <select name="pendidikan" id="pendidikan2">
                    <option value="" selected="selected">-Pendidikan-</option>
                    <option value="SD">SD</option>
                    <option value="SLTP">SLTP</option>
                    <option value="SLTA">SLTA</option>
                    <option value="DI/DII">DI/DII</option>
                    <option value="DIII">DIII</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                    </select>
                  </td>
              </tr>
              <tr>
                <td>Umur</td>
                <td>:</td>
                <td>&nbsp;</td>
                <td>Nama Sekolah/PT</td>
                <td>:</td>
                <td><input type="text" name="namapend" id="namapend" /></td>
              </tr>
              <tr>
                <td>Alamat Rumah</td>
                <td>:</td>
                <td><textarea name="alamat" id="alamat" class="General"></textarea></td>
                <td>Jurusan</td>
                <td>:</td>
                <td><input name="jurusan" type="text" class="huruf_besar" id="jurusan" /></td>
              </tr>
              <tr>
                <td>Kode Pos </td>
                <td>:</td>
                <td><input type="text" name="poscode" id="poscode" /></td>
                <td>No. KPJ</td>
                <td>:</td>
                <td><input type="text" name="nokpj" id="nokpj" /></td>
              </tr>
              <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td><input type="text" name="notlp" id="notlp" /></td>
                <td>Gol. Darah</td>
                <td>:</td>
                <td>
                  <select name="gol_darah" id="gol_darah">
                    <option value="" selected="selected">-Golongan Darah-</option>
                    <option value="O">O</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                  </select></td>
              </tr>
              <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><input type="text" name="nohp" id="nohp2" />
                </td>
                <td>No. NPWP</td>
                <td>:</td>
                <td><input type="text" name="no_npwp" id="no_npwp" /></td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td>
                  <select name="agama" id="agama2"><option value="" selected="selected">-Agama-</option>
                    <option value="ISLAM">ISLAM</option>
                    <option value="PROTESTAN">PROTESTAN</option>
                    <option value="KHATOLIK">KHATOLIK</option>
                    <option value="HINDU">HINDU</option>
                    <option value="BUDHA">BUDHA</option>
                    <option value="KHONGHUCU">KHONGHUCU</option>
                  </select></td>
                <td>Email</td>
                <td>:</td>
                <td><input type="text" name="email" id="email" /></td>
              </tr>
              <tr>
                <td>Berat Badan</td>
                <td>:</td>
                <td><input type="text" name="berat" id="berat" size="3" /> Kg</td>
                <td>&nbsp;</td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tinggi Badan</td>
                <td>:</td>
                <td><input type="text" name="tinggi" id="tinggi" size="3" /> Cm</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr align="center">
                <td colspan="6"><input type="submit" name="submit" id="submit" value="Simpan" class="input" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
	</div>


	<!-- INPUT DATA TRAINING -->
	<div class="TabbedPanelsContent">
		<form action="<?php echo $editFormAction; ?>" id="form11" name="form11" method="POST">
            <table width="1100" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td width="95">&nbsp;</td>
                <td width="8">&nbsp;</td>
                <td width="263" class="General"><input name="id_datapribadi2" type="text" class="hidentext" id="id_datapribadi2" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
                <td width="95" class="General">&nbsp;</td>
                <td width="8" class="General">&nbsp;</td>
                <td width="200" class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kategori Training</td>
                <td>:</td>
                <td class="General"><input type="radio" name="kategori" id="radio" value="1" />
                  Management Training</td>
                <td class="General">No. Sertifikat</td>
                <td>:</td>
                <td><input type="text" name="no_certificate" id="no_certificate" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="General"><input type="radio" name="kategori" id="radio2" value="2" />                  
                Skill Training</td>
                <td class="General">Penyelenggara</td>
                <td>:</td>
                <td><input name="provider" type="text" class="huruf_besar" id="provider" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Training</td>
                <td>:</td>
                <td class="General"><select name="jenis_training" id="jenis_training">
                  <?php
			do {  
			?>
                  <option value="<?php echo $row_Recordset2['jenis_training']?>"<?php if (!(strcmp($row_Recordset2['jenis_training'], $row_Recordset2['jenis_training']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['jenis_training']?></option>
                  <?php
            } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
              $rows = mysql_num_rows($Recordset2);
              if($rows > 0) {
                  mysql_data_seek($Recordset2, 0);
                  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
              }
            ?>
                </select><?php { include "popup.html"; } ?></td>
                
                <td class="General">Klasifikasi</td>
                <td>:</td>
                <td><select name="klasifikasi" id="klasifikasi">
                  <option value="" selected="selected">---</option>
                  <option value="Basic">Basic</option>
                  <option value="Advance">Advance</option>
                  <option value="Inspector">Inspector</option>
                  <option value="Migas A">Migas A</option>
                  <option value="Migas B">Migas B</option>
                  <option value="Migas C">Migas C</option>
                  <option value="Depnaker III">Depnaker III</option>
                  <option value="Depnaker II">Depnaker II</option>
                  <option value="Depnaker I">Depnaker I</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Tanggal Training</td>
                <td>:</td>
                <td><input type="text" name="tanggal" id="tanggal1" />                  <em>*(2010-10-10)</em></td>
                <td class="General">Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="25" rows="3" class="General"></textarea></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td>:</td>
                <td><input type="text" name="exp_date" id="tanggal9" />
                  *<em>(2010-10-10)</em></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form11" />
		</form>         
		<p>&nbsp;</p>
	</div>
        
    
    <!-- INPUT DATA MCU -->    
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form3" name="form3" method="POST">
            <table width="627" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="idmcu" type="text" class="hidentext" id="idmcu" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="148">Tanggal MCU</td>
                <td width="11">:</td>
                <td width="468"><input type="text" name="date" id="tanggal10" /></td>
              </tr>
              <tr>
                <td>Masa Berlaku</td>
                <td>:</td>
                <td>
                  <input type="text" name="exp_date" id="tanggal11" /></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td><input type="text" name="status2" id="status" /></td>
              </tr>
              <tr>
                <td>Kategori</td>
                <td>:</td>
                <td><input type="text" name="kategori" id="kategori" /></td>
              </tr>
              <tr>
                <td>Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="45" rows="5" class="General"></textarea></td>
              </tr>
              <tr>
                <td>Saran</td>
                <td>:</td>
                <td><textarea name="saran" id="saran" cols="45" rows="5" class="General"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit3" id="submit2" value="Simpan" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form3" />
          </form>
        </div>
        
        
        <!-- INPUT DATA PENGOBATAN -->
        <div class="TabbedPanelsContent">
          <form id="form11" name="form11" method="post" action="">
            <table width="572" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="179">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="378">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Tanggal Berobat</td>
                <td>:</td>
                <td><input type="text" name="dateobat" id="dateobat" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Biaya Pengobatan</td>
                <td>:</td>
                <td><input type="text" name="biayaobat" id="biayaobat" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Obat dari Rawat Inap</td>
                <td>:</td>
                <td><input type="text" name="obatrawin" id="obatrawin" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Rawat Inap</td>
                <td>:</td>
                <td><input type="text" name="rawatinap" id="rawatinap" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Alat Bantu Dengar</td>
                <td>:</td>
                <td><input type="text" name="alatdengar" id="alatdengar" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kacamata</td>
                <td>:</td>
                <td><input type="text" name="kacamata" id="kacamata" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Gigi Palsu</td>
                <td>:</td>
                <td><input type="text" name="gigipalsu" id="gigipalsu" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit4" id="submit3" value="Simpan" /></td>
              </tr>
            </table>
          </form>
        </div>
        
        <!-- INPUT DATA BANTUAN -->
        <div class="TabbedPanelsContent">
        <form action="<?php echo $editFormAction; ?>" id="form14" name="form14" method="POST">
            <table width="649" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_bantuan" type="text" class="hidentext" id="id_bantuan" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="293">Jenis Bantuan/Santunan</td>
                <td width="10">:</td>
                <td width="346"><select name="bantuan" id="bantuan">
                <option value="" selected="selected">-Jenis Bantuan-</option>
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
            <input type="hidden" name="MM_insert" value="form14" />
        </form>  
        </div>
        
        
        <!-- INPUT DATA EXPERIENCE -->
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form4" name="form4" method="POST">
            <table width="675" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="General"><input name="idexp" type="text" class="hidentext" id="idexp" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="136" class="General">Kategori Experiences</td>
                <td width="10">:</td>
                <td width="328" class="General">
                  <input type="text" name="pengalaman" id="pengalaman" /></td>
              </tr>
              <tr>
                <td class="General">Nama Instansi / Organisasi</td>
                <td>:</td>
                <td class="General">
                  <input type="text" name="nama_instansi" id="nama_instansi" /></td>
              </tr>
              <tr>
                <td class="General">Lokasi</td>
                <td>:</td>
                <td class="General">
                  <input type="text" name="lokasi" id="lokasi" /></td>
              </tr>
              <tr>
                <td class="General">Bagian</td>
                <td>:</td>
                <td class="General">
                  <input type="text" name="bagian" id="bagian" /></td>
              </tr>
              <tr>
                <td class="General">Jabatan</td>
                <td>:</td>
                <td class="General">
                  <input type="text" name="jabatan" id="jabatan" /></td>
              </tr>
              <tr>
                <td class="General">Uraian Singkat</td>
                <td>:</td>
                <td class="General">
                  <input type="text" name="uraian" id="uraian" /></td>
              </tr>
              <tr>
                <td class="General">Lama</td>
                <td>&nbsp;</td>
                <td class="General">
                  <input type="text" name="tgl_masuk" id="tgl_masuk" /> 
                  s/d 
                  <input type="text" name="tgl_keluar" id="tgl_keluar" />
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit5" id="submit4" value="Simpan" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form4" />
          </form>
          <p>&nbsp;</p>
          <br />
        </div>
        
        
        <!-- INPUT DATA APPRECIATE/PENGHARGAAN -->
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form5" name="form5" method="POST">
            <table width="559" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input name="idapr" type="text" class="hidentext" id="idapr" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Tipe</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="tipe_penghargaan" id="tipe_penghargaan" /></td>
              </tr>
              <tr>
                <td class="General">Nama Penghargaan</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="nama_penghargaan" id="nama_penghargaan" /></td>
              </tr>
              <tr>
                <td class="General">Provider</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="provider" id="provider" /></td>
              </tr>
              <tr>
                <td width="178" class="General">Tahun</td>
                <td width="10" class="General">:</td>
                <td width="372" class="General"><input type="text" name="tahun" id="tahun" /></td>
              </tr>
              <tr>
                <td class="General">Remark</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="remark2" id="remark" /></td>
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
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input type="submit" name="submit6" id="submit5" value="Simpan" /></td>
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
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form5" />
          </form>
        </div>
        

	<!-- INPUT DATA SIM -->
    <div class="TabbedPanelsContent">
      <form action="<?php echo $editFormAction; ?>" id="form9" name="form9" method="POST">
            <table width="334" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input name="idsim" type="text" class="hidentext" id="idsim" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="152" class="General">Golongan SIM</td>
                <td width="10" class="General">:</td>
                <td width="175" class="General"><input type="text" name="sim_gol" id="sim_gol" /></td>
              </tr>
              <tr>
                <td class="General">Masa Berlaku</td>
                <td class="General">:</td>
                <td class="General">
                  <input type="text" name="masa_berlaku" id="tanggal12" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input type="submit" name="submit7" id="submit6" value="Simpan" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form9" />
	</form>
	</div>
    
    <!-- INPUT DATA ANGGOTA KELUARGA -->
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form8" name="form8" method="POST">
            <table width="651" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" class="General"><b>Data Anggota Keluarga :</b></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input name="idkel" type="text" class="hidentext" id="idkel" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="241" class="General">Hubungan Keluarga</td>
                <td width="11" class="General">:</td>
                <td width="399" class="General"><input type="text" name="hub_keluarga" id="hub_keluarga" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td class="General">:</td>
                <td class="General"><input name="nama" type="text" class="huruf_besar" id="nama" /></td>
              </tr>
              <tr>
                <td class="General">Tempat Lahir</td>
                <td class="General">:</td>
                <td class="General"><input name="tempat_lahir" type="text" class="huruf_besar" id="tempat_lahir" /></td>
              </tr>
              <tr>
                <td class="General">Tanggal lahir</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="tgl_lahir" id="tgl_lahir" /></td>
              </tr>
              <tr>
                <td class="General">Pekerjaan</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="pekerjaan" id="pekerjaan" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Kelamin</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="jk2" id="jk2" /></td>
              </tr>
              <tr>
                <td class="General">Pendidikan</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="pendidikan2" id="pendidikan" /></td>
              </tr>
              <tr>
                <td class="General">Agama</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="agama2" id="agama" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" class="General"><b>Keluarga yang dapat dihubungi dalam keadaan Emergency (Tidak serumah)</b></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Nama Saudara</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="emg_nama" id="emg_nama" /></td>
              </tr>
              <tr>
                <td class="General">Alamat Saudara</td>
                <td class="General">:</td>
                <td class="General"><textarea class="General" name="emg_alamat" id="emg_alamat"></textarea></td>
              </tr>
              <tr>
                <td class="General">No. Telp/HP</td>
                <td class="General">:</td>
                <td class="General"><input type="text" name="emg_telp" id="emg_telp" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input type="submit" name="submit8" id="submit7" value="Simpan" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form8" />
          </form>
        </div>
         <div class="TabbedPanelsContent">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form12" id="form12">
             <table>
               <tr>
                 <td>Nama Anak :</td>
                 <td><input type="text" name="nama_anak" value="" size="32" /></td>
               </tr>
               <tr>
                 <td>Jenis Kelamin :</td>
                 <td><table width="200">
                   <tr>
                     <td><label>
                       <input type="radio" name="jk" value="P" id="jk_0" />
                       Perempuan</label></td>
                   </tr>
                   <tr>
                     <td><label>
                       <input type="radio" name="jk" value="L" id="jk_1" />
                       Laki - Laki</label></td>
                   </tr>
                 </table></td>
               </tr>
               <tr>
                 <td>Tempat lahir :</td>
                 <td><input type="text" name="tempat_lahir" value="" size="32" /></td>
               </tr>
               <tr>
                 <td>Tanggal lahir :</td>
                 <td><input type="text" name="tanggal_lahir" value="" size="32" id="tanggal20" /></td>
               </tr>
               <tr>
                 <td>Pendidikan terakhir:</td>
                 <td><input type="text" name="pendidikan_terakhir" value="" size="32" /></td>
               </tr>
               <tr>
                 <td colspan="2" align="center"><input name="id_employee" type="hidden" id="id_employee" value="<?php echo $row_Recordset1['id']; ?>" />                   <input type="submit" value="Insert record" /></td>
                </tr>
             </table>
             <input type="hidden" name="MM_insert2" value="form12" />
           </form>
           <p>&nbsp;</p>
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
             <tr class="tabel_body">
               <?php $a=$a+1; ?>
               <td><?php echo $a; ?></td>
               <td><?php echo $row_Recordset10['nama_anak']; ?></td>
               <td><?php echo $row_Recordset10['jk']; ?></td>
               <td><?php echo $row_Recordset10['tempat_lahir']; ?></td>
               <td><?php echo $row_Recordset10['tanggal_lahir']; ?></td>
               <td><?php
				$retrieved =$row_Recordset10['tanggal_lahir']; 
				$date =substr($retrieved, -4) ; 
				$datenow=date('Y');
				$umur=$datenow-$date;
				if ($umur >= '2014') {
					echo "--";
				} else {
					echo $umur.' '."Tahun";
				} ?></td>
               <td><?php echo $row_Recordset10['pendidikan_terakhir']; ?></td>
             </tr>
           </table>
         </div>
      
      <!-- INPUT DATA ORANG TUA -->  
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form7" name="form7" method="POST">
            <table width="678" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="134">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="519"><input name="idortu" type="text" class="hidentext" id="idortu" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Nama Ayah</td>
                <td class="General">:</td>
                <td><input type="text" name="nama_ayah" id="nama_ayah" /><br /></td>
              </tr>
              <tr>
                <td class="General">Nama Ibu</td>
                <td class="General">:</td>
                <td><input type="text" name="nama_ibu" id="nama_ibu" /></td>
              </tr>
              <tr>
                <td class="General">Alamat</td>
                <td class="General">:</td>
                <td><textarea class="General" name="alamat2" id="alamat"></textarea></td>
              </tr>
              <tr>
                <td class="General">No. Telp</td>
                <td class="General">:</td>
                <td><input type="text" name="telp" id="telp" /></td>
              </tr>
              <tr>
                <td class="General">No. HP</td>
                <td class="General">:</td>
                <td><input type="text" name="nohp2" id="nohp" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit9" id="submit8" value="Simpan" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form7" />
          </form>
        </div>
        
     <!-- INPUT DATA BAHASA -->   
        <div class="TabbedPanelsContent">
          <form id="form10" name="form10" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="200" border="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="idbahasa" type="text" class="hidentext" id="idbahasa" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td>Bahasa</td>
                <td>:</td>
                <td><input type="text" name="bahasa" id="bahasa" /></td>
              </tr>
              <tr>
                <td>Predikat</td>
                <td>:</td>
                <td>
                  <select name="predikat" id="predikat">
                    <option value="" selected="selected">---</option>
                    <option value="Sangat Baik">Sangat Baik</option>
                    <option value="Baik">Baik</option>
                    <option value="Cukup">Cukup</option>
                    <option value="Kurang">Kurang</option>
                  </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit11" id="submit10" value="Submit" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form10" />
          </form>
        </div>
        
     <!-- INPUT DATA POSISI -->   
        <div class="TabbedPanelsContent">
          <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="327" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" size="8" /></td>
              </tr>
              <tr>
                <td class="General">Posisi yang dilamar</td>
                <td>:</td>
                <td>
                  <input type="text" name="posisi" id="posisi" /></td>
              </tr>
              <tr>
                <td class="General">Reference</td>
                <td>:</td>
                <td>
                  <input type="text" name="referance" id="referance" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit12" id="submit11" value="Simpan" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form2" />
          </form>
        </div>
        <!-- INPUT DATA BPJS -->
        <div class="TabbedPanelsContent">
          <form id="form15" name="form15" method="POST" action="<?php echo $editFormAction; ?>">
            <table border="0">
              <tr class="tabel_header">
                <td colspan="6"><input name="id_employee2" type="hidden" id="id_employee2" value="<?php echo $row_Recordset1['id']; ?>" />                  
                  BPJS </td>
                </tr>
              <tr>
                <td>No. BPJS Ketenagakerjaan</td>
                <td>:</td>
                <td><input type="text" name="nobpjs_tk" id="nobpjs_tk" /></td>
                <td>Tanggal Kepesertaan</td>
                <td>:</td>
                <td><input type="text" name="tgl_tk" id="tgl_tk" /></td>
              </tr>
              <tr>
                <td>No. BPJS Kesehatan</td>
                <td>&nbsp;</td>
                <td><input type="text" name="nobpjs_kes" id="nobpjs_kes" /></td>
                <td>Tanggal Kepesertaan</td>
                <td>:</td>
                <td><input type="text" name="tgl_kes" id="tgl_kes" /></td>
              </tr>
              <tr class="tabel_header">
                <td colspan="6">ID Card</td>
                </tr>
              <tr>
                <td>ID Card Chevron</td>
                <td>&nbsp;</td>
                <td><input type="text" name="id_chev" id="id_chev" /></td>
                <td>Tanggal Pembuatan - Expired</td>
                <td>&nbsp;</td>
                <td><input type="text" name="tgl_buat_chev" id="tgl_buat_chev" /> 
                  - 
                  <input type="text" name="tgl_exp_chev" id="tgl_exp_chev" /></td>
              </tr>
              <tr>
                <td>ID Card Bukaka</td>
                <td>:</td>
                <td><input type="text" name="id_bkk" id="id_bkk" /></td>
                <td>Tanggal Pembuatan - Expired</td>
                <td>&nbsp;</td>
                <td><input type="text" name="tgl_buat_bkk" id="tgl_buat_bkk" /> 
                  - 
                  <input type="text" name="tgl_exp_bkk" id="tgl_exp_bkk" /></td>
              </tr>
              <tr align="center">
                <td colspan="6"><input type="submit" name="submit2" id="submit12" value="Submit" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form15" />
          </form>
        </div>
        
        <div class="TabbedPanelsContent">
          <h1><a href="../../attachment.php?data=<?php echo $row_Recordset1['id']; ?>">UPLOAD FILES HERE !</a></h1>
        </div>
        <div class="TabbedPanelsContent">Content 14
          <form id="form13" name="form13" method="post" action="">
          </form>

        </div>
        
        
        <div class="TabbedPanelsContent">Content 15</div>
        <div class="TabbedPanelsContent">Content 16</div>
        <div class="TabbedPanelsContent">Content 17</div>
      </div>
    </div>
    
   <?php } ?> 
    </td>
  </tr>
  
  <tr>
    <td colspan="5" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="29">&nbsp;</td>
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
	
	mysql_free_result($Recordset11);

mysql_free_result($Recordset10);
?>
