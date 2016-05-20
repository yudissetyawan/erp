.<?php require_once('../../Connections/core.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_datapribadi SET jk=%s, status=%s, noktp=%s, berlakuktp=%s, tempat_lahir=%s, tgl_lahir=%s, alamat=%s, poscode=%s, notlp=%s, nohp=%s, agama=%s, berat=%s, tinggi=%s, ukuran_baju=%s, ukuran_celana=%s, Coverall=%s, ukuran_sepatu=%s, pendidikan=%s, jurusan=%s, namapend=%s, nokpj=%s, gol_darah=%s, no_npwp=%s, email=%s WHERE id_h_employee=%s",
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
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id_datapribadi'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
	{ require_once "../../dateformat_funct.php"; }
	
  $updateSQL = sprintf("UPDATE h_mcu SET `date`=%s, exp_date=%s, kategori=%s, status=%s, remark=%s, saran=%s WHERE id_h_employee=%s",
                       GetSQLValueString(functyyyymmdd($_POST['date']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['exp_date']), "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['status2'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['saran'], "text"),
                       GetSQLValueString($_POST['idmcu'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form14")) {
  $updateSQL = sprintf("UPDATE h_bantuan SET jenis_bantuan=%s, tanggal=%s, nilai=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['bantuan'], "text"),
                       GetSQLValueString($_POST['tgl_bantuan'], "text"),
                       GetSQLValueString($_POST['nilaibantuan'], "text"),
                       GetSQLValueString($_POST['id_bantuan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form8")) {
  $updateSQL = sprintf("UPDATE h_datakeluarga SET emg_nama=%s, emg_alamat=%s, emg_telp=%s, hub_keluarga=%s, nama=%s, tempat_lahir=%s, tgl_lahir=%s, umur=%s, pekerjaan=%s, jk=%s, pendidikan=%s, agama=%s WHERE id_h_employee=%s",
                       GetSQLValueString($_POST['emg_nama'], "text"),
                       GetSQLValueString($_POST['emg_alamat'], "text"),
                       GetSQLValueString($_POST['emg_telp'], "text"),
                       GetSQLValueString($_POST['hub_keluarga'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['umur2'], "text"),
                       GetSQLValueString($_POST['pekerjaan'], "text"),
                       GetSQLValueString($_POST['jk2'], "text"),
                       GetSQLValueString($_POST['pendidikan2'], "text"),
                       GetSQLValueString($_POST['agama2'], "text"),
                       GetSQLValueString($_POST['idkel'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form4")) {
  $updateSQL = sprintf("UPDATE h_dataortu SET nama_ayah=%s, nama_ibu=%s, alamat=%s, telp=%s, nohp=%s WHERE id_h_employee=%s",
                       GetSQLValueString($_POST['nama_ayah'], "text"),
                       GetSQLValueString($_POST['nama_ibu'], "text"),
                       GetSQLValueString($_POST['alamat2'], "text"),
                       GetSQLValueString($_POST['telp'], "text"),
                       GetSQLValueString($_POST['nohp2'], "text"),
                       GetSQLValueString($_POST['idortu'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
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

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM h_datapribadi WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT h_training.*, h_kategori_training.nama_kategori FROM h_training, h_kategori_training WHERE id_h_employee = %s AND h_kategori_training.id_kategori = h_training.kategori", GetSQLValueString($colname_Recordset3, "int"));
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
$query_Recordset5 = sprintf("SELECT * FROM h_bantuan WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset5, "text"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_experiences WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset6, "text"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_penghargaan WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_sim WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset8, "int"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_datakeluarga WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset9, "int"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

$colname_Recordset10 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset10 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset10 = sprintf("SELECT * FROM h_dataortu WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset10, "int"));
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset11 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset11 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset11 = sprintf("SELECT * FROM h_bahasa WHERE id_h_employee = %s", GetSQLValueString($colname_Recordset11, "int"));
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

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HRD - Edit Data Karyawan</title>
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

</head>

	
<body>
<?php { require_once "../../date.php"; } 
	{ require_once "../../dateformat_funct.php"; }
?>

<table width="1270" border="0" align="center">
  <tr>
    <td width="594" height="64" colspan="3" rowspan="2"><img src="../../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="625" colspan="2" align="right" valign="top"><table width="420" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr valign="middle">
        <td width="10" align="right" class="demoHeaders">|</td>
        <td width="350" align="right" class="demoHeaders">Your Logged as <a href="viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b>
		<?php echo $_SESSION['MM_Username']; ?></b></a></td>
        <td width="11" class="demoHeaders">|</a></td>
        <td width="106" class="demoHeaders"><a href="../../contact.php">Contact Us</a></td>
        <td width="11" class="demoHeaders">|</td>
        <td width="107" class="demoHeaders"><a href="<?php echo $logoutAction ?>">Logout</a></td>
        <td align="right" width="5" class="demoHeaders">|</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="right" valign="bottom">
		<?php { require_once "../../menu_notification.php"; } ?>
	</td>
  </tr>
  
  <tr>
    <td colspan="4" align="right" bgcolor="#8db4e3" id="font"><table width="635" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="32" align="left" class="root"><a href="../../home.php">Home</a></td>
        <td width="10" align="left" class="root">|</td>
        <td width="64" align="left" class="root">HRD/GAFF</td>
        
        <td width="10" align="left" class="root">|</td>
        <td width="519" align="left" class="root"><form id="form6" name="form6" method="post" action="">
          <?php echo $row_Recordset1['nik']; ?> - 
          <?php echo $row_Recordset1['firstname']; ?>
        </form></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left" class="General" id="font">
   <?php
	if ($_GET[modul]=='unapproved'){
		echo '<iframe src="../../tm/unapproved_crf.php" width="1200" height="550" style="border:thin"></iframe>';
	} elseif ($_GET[modul]=='notif'){
		?>
   <iframe src="../../prj/bacanotif.php?data=<?php echo $usrid; ?>" width="1200" height="550" style="border:thin"></iframe>
   <?php
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
      
      <!-- EDIT DATA PRIBADI -->
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
            <table width="1448" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td width="164">&nbsp;</td>
                <td width="8">&nbsp;</td>
                <td width="393"><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset2['id_h_employee']; ?>" size="5" readonly="readonly" /></td>
                <td width="165">&nbsp;</td>
                <td width="13">&nbsp;</td>
                <td width="705">&nbsp;</td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><input type="radio" name="jk" value="Pria" <?php echo ($row_Recordset2['jk']=='Pria')?'checked':'' ?> size="17">Pria

<input type="radio" name="jk" value="Wanita" <?php echo ($row_Recordset2['jk']=='Wanita')?'checked':'' ?> size="17">Wanita</td>
                <td>Ukuran Baju</td>
                <td>:</td>
                <td><input name="ukuran_baju" type="text" id="ukuran_baju" value="<?php echo $row_Recordset2['ukuran_baju']; ?>" /></td>
                </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td><input name="status" type="text" id="status" value="<?php echo $row_Recordset2['status']; ?>" /></td>
                <td>Ukuran Celana</td>
                <td>:</td>
                <td><input name="ukuran_celana" type="text" id="ukuran_celana" value="<?php echo $row_Recordset2['ukuran_celana']; ?>" /></td>
              </tr>
              <tr>
                <td>No. KTP</td>
                <td>:</td>
                <td><input name="noktp" type="text" id="noktp" value="<?php echo $row_Recordset2['noktp']; ?>" /></td>
                <td>Coverall (Dale)</td>
                <td>:</td>
                <td>
                  <input name="coverall" type="text" id="coverall" value="<?php echo $row_Recordset2['Coverall']; ?>" /></td>
              </tr>
              <tr>
                <td>Berlaku KTP sampai dengan</td>
                <td>:</td>
                <td>
                  <input name="berlakuktp" type="text" id="tanggal3" value="<?php echo $row_Recordset2['berlakuktp']; ?>" /></td>
                <td>Ukuran Sepatu (Safety)</td>
                <td>:</td>
                <td>
                  <input name="ukuran_sepatu" type="text" id="ukuran_sepatu" value="<?php echo $row_Recordset2['ukuran_sepatu']; ?>" /></td>
              </tr>
              <tr>
                <td>Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td><strong>
                  <input name="tempatlahir" type="text" id="tempatlahir" value="<?php echo $row_Recordset2['tempat_lahir']; ?>" />
                  /
                  <input name="tgl_lahir" type="text" id="tanggal1" value="<?php echo $row_Recordset2['tgl_lahir']; ?>" size="15" />
                  </strong></td>
                <td>Pendidikan Terakhir</td>
                <td>:</td>
                <td>
                  <input name="pendidikan" type="text" id="pendidikan" value="<?php echo $row_Recordset2['pendidikan']; ?>" /></td>
              </tr>
              <tr>
                <td>Umur</td>
                <td>:</td>
                <td><input type="text" name="umur" id="umur" size="3" style="text-align:right" value="<?php
                	echo (date("Y") - substr($row_Recordset2['tgl_lahir'], -4)); ?>" /> Tahun
                </td>
                <td>Nama Sekolah / PT</td>
                <td>:</td>
                <td><input name="namapend" type="text" id="namapend" value="<?php echo $row_Recordset2['namapend']; ?>" /></td>
              </tr>
              <tr>
                <td>Alamat Rumah</td>
                <td>:</td>
                <td><input name="alamat" type="text" id="alamat" value="<?php echo $row_Recordset2['alamat']; ?>" /></td>
                <td>Jurusan</td>
                <td>:</td>
                <td><label for="jurusan"></label>
                  <input name="jurusan" type="text" id="jurusan" value="<?php echo $row_Recordset2['jurusan']; ?>" /></td>
              </tr>
              <tr>
                <td>Kode Pos </td>
                <td>:</td>
                <td><label for="poscode"></label>
                  <input name="poscode" type="text" id="poscode" value="<?php echo $row_Recordset2['poscode']; ?>" /></td>
                <td>No. KPJ</td>
                <td>:</td>
                <td><label for="nokpj"></label>
                  <input name="nokpj" type="text" id="nokpj" value="<?php echo $row_Recordset2['nokpj']; ?>" /></td>
              </tr>
              <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td><label for="notlp"></label>
                  <input name="notlp" type="text" id="notlp" value="<?php echo $row_Recordset2['notlp']; ?>" /></td>
                <td>Gol. Darah</td>
                <td>:</td>
                <td><label for="gol_darah"></label>
                  <input name="gol_darah" type="text" id="gol_darah" value="<?php echo $row_Recordset2['gol_darah']; ?>" /></td>
              </tr>
              <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><label for="nohp"></label>
                  <input name="nohp" type="text" id="nohp" value="<?php echo $row_Recordset2['nohp']; ?>" /></td>
                <td>No. NPWP</td>
                <td>:</td>
                <td><label for="no_npwp"></label>
                  <input name="no_npwp" type="text" id="no_npwp" value="<?php echo $row_Recordset2['no_npwp']; ?>" /></td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td><label for="agama"></label>
                  <input name="agama" type="text" id="agama" value="<?php echo $row_Recordset2['agama']; ?>" /></td>
                <td>Email</td>
                <td>:</td>
                <td><label for="email"></label>
                  <input name="email" type="text" id="email" value="<?php echo $row_Recordset2['email']; ?>" /></td>
              </tr>
              <tr>
                <td>Berat Badan</td>
                <td>:</td>
                <td><input name="berat" type="text" id="berat" value="<?php echo $row_Recordset2['berat']; ?>" size="3" style="text-align:right" /> Kg</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tinggi Badan</td>
                <td>:</td>
                <td><input name="tinggi" type="text" id="tinggi" value="<?php echo $row_Recordset2['tinggi']; ?>" size="3" style="text-align:right" /> Cm</td>
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
            <input type="hidden" name="MM_update" value="form1" />
          </form>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
		</div>
          
        
        <!-- EDIT DATA TRAINING -->  
        <div class="TabbedPanelsContent">
          <table border="1" width="100%">
            <tr class="tabel_header" height="30">
              <td>No.</td>
              <td>Kategori</td>
              <td>Jenis Training</td>
              <td>Tanggal</td>
              <td>Tanggal Kadaluarsa</td>
              <td>No. Sertifikat </td>
              <td>Penyelenggara</td>
              <td>Catatan</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td align="center"><?php $n=$n+1; echo $n ?></td>
              <td><?php echo $row_Recordset3['nama_kategori']; ?></td>
              <td><?php echo $row_Recordset3['jenis_training']; ?></td>
              <td align="center"><?php echo $row_Recordset3['date']; ?></td>
              <td align="center"><?php echo $row_Recordset3['exp_date']; ?></td>
              <td align="center"><?php echo $row_Recordset3['no_certificate']; ?></td>
              <td><?php echo $row_Recordset3['provider']; ?></td>
              <td><?php echo $row_Recordset3['remark']; ?></td>
              <td align="center"><a href='deletetraining.php?id=<?php echo $row_Recordset3['id']; ?>'>Delete</a> | <a href="edit_training.php?data=<?php echo $row_Recordset3['id']; ?>">Edit</a></td>
            </tr>
            <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
          </table>
        </div>
        
        
        <!-- DATA MCU -->
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form3" name="form3" method="POST">
            <table width="627" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="idmcu" type="text" class="hidentext" id="idmcu" value="<?php echo $row_Recordset4['id_datapribadi']; ?>" size="5" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="148">MCU Date</td>
                <td width="11">:</td>
                <td width="468"><input name="date" type="text" id="date" value="<?php echo functddmmmyyyy($row_Recordset4['date']); ?>" /></td>
              </tr>
              <tr>
                <td>Expired Date</td>
                <td>:</td>
                <td><input name="exp_date" type="text" id="exp_date" value="<?php echo functddmmmyyyy($row_Recordset4['exp_date']); ?>" /></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td><input name="status2" type="text" id="status" value="<?php echo $row_Recordset4['status']; ?>" /></td>
              </tr>
              <tr>
                <td>Category</td>
                <td>:</td>
                <td><input name="kategori" type="text" id="kategori" value="<?php echo $row_Recordset4['kategori']; ?>" /></td>
              </tr>
              <tr>
                <td>Remark</td>
                <td>:</td>
                <td><textarea name="remark" id="remark" cols="45" rows="5"><?php echo $row_Recordset4['remark']; ?></textarea></td>
              </tr>
              <tr>
                <td>Advice</td>
                <td>:</td>
                <td><textarea name="saran" id="saran" cols="45" rows="5"><?php echo $row_Recordset4['saran']; ?></textarea></td>
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
            <input type="hidden" name="MM_update" value="form3" />
          </form>
        </div>
        
        
        <!-- EDIT DATA PENGOBATAN -->
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
                <td><label for="dateobat"></label>
                  <input type="text" name="dateobat" id="dateobat" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Biaya Pengobatan</td>
                <td>:</td>
                <td><label for="biayaobat"></label>
                  <input type="text" name="biayaobat" id="biayaobat" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Obat dari Rawat Inap</td>
                <td>:</td>
                <td><label for="obatrawin"></label>
                  <label for="obatrawin"></label>
                  <input type="text" name="obatrawin" id="obatrawin" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Rawat Inap</td>
                <td>:</td>
                <td>
                  <input type="text" name="rawatinap" id="rawatinap" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Alat Bantu Dengar</td>
                <td>:</td>
                <td><input type="text" name="alatdengar" id="alatdengar" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Kacamata</td>
                <td>:</td>
                <td>
                  <input type="text" name="kacamata" id="kacamata" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">Gigi Palsu</td>
                <td>:</td>
                <td><input type="text" name="gigipalsu" id="gigipalsu" /></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit4" id="submit3" value="Simpan" /></td>
              </tr>
            </table>
          </form>
        </div>
        
        
        <!-- EDIT DATA BANTUAN -->
        <div class="TabbedPanelsContent">
        <form action="<?php echo $editFormAction; ?>" id="form14" name="form14" method="POST">
            <table width="649" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_bantuan" type="text" class="hidentext" id="id_bantuan" value="<?php echo $row_Recordset5['id_datapribadi']; ?>" size="5" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="293">Jenis Bantuan/Santunan</td>
                <td width="10">:</td>
                <td width="346">
                <select name="bantuan" id="bantuan" title="<?php echo $row_Recordset5['jenis_bantuan']; ?>">
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
                <td><input name="nilaibantuan" type="text" id="nilaibantuan" value="<?php echo $row_Recordset5['nilai']; ?>" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><input name="tgl_bantuan" type="text" id="tanggal7" value="<?php echo $row_Recordset5['tanggal']; ?>" /></td>
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
            <input type="hidden" name="MM_update" value="form14" />
        </form>  
        </div>
        
        
        <!-- DATA EXPERIENCE -->
        <div class="TabbedPanelsContent">
          <table border="1" width="100%">
            <tr class="tabel_header" height="30">
              <td>No</td>
              <td>Pengalaman</td>
              <td>Nama Perusahaan</td>
              <td>Lokasi</td>
              <td>Bagian</td>
              <td>Jabatan</td>
              <td>Uraian</td>
              <td>Tanggal Masuk</td>
              <td>Tanggal Keluar</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr class="tabel_body">
              <td align="center"><?php echo $n ?></td>
              <td><?php echo $row_Recordset6['pengalaman']; ?></td>
              <td><?php echo $row_Recordset6['nama_instansi']; ?></td>
              <td><?php echo $row_Recordset6['lokasi']; ?></td>
              <td><?php echo $row_Recordset6['bagian']; ?></td>
              <td><?php echo $row_Recordset6['jabatan']; ?></td>
              <td><?php echo $row_Recordset6['uraian']; ?></td>
              <td><?php echo $row_Recordset6['tgl_masuk']; ?></td>
              <td><?php echo $row_Recordset6['tgl_keluar']; ?></td>
              <td align="center"><a href='deleteexperiences.php?id=<?php echo $row_Recordset6['id']; ?>'>Delete</a> | <a href="edit_experiences.php?data=<?php echo $row_Recordset6['id']; ?>">Edit</a></td>
            </tr>
            <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
          </table>
          <p>&nbsp;</p>
          <br />
        </div>
        
        
        <!-- DATA PENGHARGAAN -->
        <div class="TabbedPanelsContent">
          <table border="1" width="100%">
            <tr class="tabel_header" height="30">
				<td width="30">No.</td>
              <td>Nama Penghargaan</td>
              <td>Penyelenggara / Pemberi</td>
              <td>Tahun</td>
              <td>Catatan</td>
              <td>Tipe Penghargaan</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
              <tr class="tabel_body">
              	<td align="center"><?php echo $n ?></td>
                <td><?php echo $row_Recordset7['nama_penghargaan']; ?></td>
                <td><?php echo $row_Recordset7['provider']; ?></td>
                <td align="center"><?php echo $row_Recordset7['tahun']; ?></td>
                <td><?php echo $row_Recordset7['remark']; ?></td>
                <td><?php echo $row_Recordset7['tipe_penghargaan']; ?></td>
                <td align="center"><a href='deleteapreciation.php?id=<?php echo $row_Recordset7['id']; ?>'>Delete</a> | <a href='edit_apreciation.php?data=<?php echo $row_Recordset7['id']; ?>'>Edit</a></td>
              </tr>
              <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
          </table>
        </div>
        
        
        <!-- DATA SIM -->
        <div class="TabbedPanelsContent">
          <table border="1" width="350">
            <tr class="tabel_header" height="30">
              <td width="30">No.</td>
              <td width="120">Golongan S I M</td>
              <td width="110">Masa Berlaku</td>
              <td width="90">&nbsp;</td>
            </tr>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php echo $n ?></td>
                <td align="center"><?php echo $row_Recordset8['sim_gol']; ?></td>
                <td align="center"><?php echo functddmmmyyyy($row_Recordset8['masaberlaku']); ?></td>
                <td align="center"><a href='deletesim.php?id=<?php echo $row_Recordset8['id']; ?>'>Delete</a> | <a href='edit_sim.php?data=<?php echo $row_Recordset8['id']; ?>'>Edit</a></td>
              </tr>
              <?php } while ($row_Recordset8 = mysql_fetch_assoc($Recordset8)); ?>
          </table>
        </div>
        
        
        <!-- EDIT DATA ANGGOTA KELUARGA -->
        <div class="TabbedPanelsContent">
          <form action="<?php echo $editFormAction; ?>" id="form8" name="form8" method="POST">
            <table width="651" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" class="General"><strong>Data Anggota Keluarga :</strong></td>
              </tr>
              <tr>
                <td class="General">&nbsp;</td>
                <td class="General">&nbsp;</td>
                <td class="General"><input name="idkel" type="text" class="hidentext" id="idkel" value="<?php echo $row_Recordset9['id_datapribadi']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td width="241" class="General">Hubungan Keluarga</td>
                <td width="11" class="General">:</td>
                <td width="399" class="General"><label for="hub_keluarga"></label>
                  <input name="hub_keluarga" type="text" id="hub_keluarga" value="<?php echo $row_Recordset9['hub_keluarga']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Nama</td>
                <td class="General">:</td>
                <td class="General"><label for="nama"></label>
                  <input name="nama" type="text" id="nama" value="<?php echo $row_Recordset9['nama']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Tempat Lahir</td>
                <td class="General">:</td>
                <td class="General"><label for="tempat_lahir"></label>
                  <input name="tempat_lahir" type="text" id="tempat_lahir" value="<?php echo $row_Recordset9['tempat_lahir']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Tanggal lahir</td>
                <td class="General">:</td>
                <td class="General"><label for="tgl_lahir"></label>
                  <input name="tgl_lahir" type="text" id="tgl_lahir" value="<?php echo $row_Recordset9['tgl_lahir']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Umur</td>
                <td class="General">:</td>
                <td class="General"><label for="umur"></label>
                  <input name="umur2" type="text" id="umur" value="<?php echo $row_Recordset9['umur']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Pekerjaan</td>
                <td class="General">:</td>
                <td class="General"><label for="pekerjaan"></label>
                  <input name="pekerjaan" type="text" id="pekerjaan" value="<?php echo $row_Recordset9['pekerjaan']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Kelamin</td>
                <td class="General">:</td>
                <td class="General"><label for="jk2"></label>
                  <input name="jk2" type="text" id="jk2" value="<?php echo $row_Recordset9['jk']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Pendidikan</td>
                <td class="General">:</td>
                <td class="General"><label for="pendidikan"></label>
                  <input name="pendidikan2" type="text" id="pendidikan" value="<?php echo $row_Recordset9['pendidikan']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Agama</td>
                <td class="General">:</td>
                <td class="General"><label for="agama"></label>
                  <input name="agama2" type="text" id="agama" value="<?php echo $row_Recordset9['agama']; ?>" /></td>
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
                <td class="General"><label for="emg_nama"></label>
                  <input name="emg_nama" type="text" id="emg_nama" value="<?php echo $row_Recordset9['emg_nama']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Alamat Saudara</td>
                <td class="General">:</td>
                <td class="General"><label for="emg_alamat"></label>
                  <input name="emg_alamat" type="text" id="emg_alamat" value="<?php echo $row_Recordset9['emg_alamat']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">No. Telp/HP</td>
                <td class="General">:</td>
                <td class="General"><label for="emg_telp"></label>
                  <input name="emg_telp" type="text" id="emg_telp" value="<?php echo $row_Recordset9['emg_telp']; ?>" /></td>
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
            <input type="hidden" name="MM_update" value="form8" />
          </form>
        </div>
        
        
        <!-- EDIT DATA ORANG TUA -->
        <div class="TabbedPanelsContent">
          <form id="form4" name="form4" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="678" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="134">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="519"><input name="idortu" type="text" class="hidentext" id="idortu" value="<?php echo $row_Recordset10['id_datapribadi']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Nama Ayah</td>
                <td class="General">:</td>
                <td>
                  <input name="nama_ayah" type="text" id="nama_ayah" value="<?php echo $row_Recordset10['nama_ayah']; ?>" />
                  <br /></td>
              </tr>
              <tr>
                <td class="General">Nama Ibu</td>
                <td class="General">:</td>
                <td>
                  <input name="nama_ibu" type="text" id="nama_ibu" value="<?php echo $row_Recordset10['nama_ibu']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Alamat</td>
                <td class="General">:</td>
                <td>
                  <input name="alamat2" type="text" id="alamat3" value="<?php echo $row_Recordset10['alamat']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">No. Telp</td>
                <td class="General">:</td>
                <td>
                  <input name="telp" type="text" id="telp" value="<?php echo $row_Recordset10['telp']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">No. HP</td>
                <td class="General">:</td>
                <td>
                  <input name="nohp2" type="text" id="nohp3" value="<?php echo $row_Recordset10['nohp']; ?>" /></td>
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
            <input type="hidden" name="MM_update" value="form4" />
          </form>
        </div>
        
        
        <!-- EDIT DATA BAHASA -->
        <div class="TabbedPanelsContent">
          <table border="1" width="300">
            <tr class="tabel_header" height="30">
              <td width="30">No.</td>
              <td width="100">Bahasa</td>
              <td width="100">Predikat</td>
              <td width="70">&nbsp;</td>
            </tr>
            <?php do { ?>
              <tr class="tabel_body">
                <td align="center"><?php echo $n ?></td>
                <td><?php echo $row_Recordset11['bahasa']; ?></td>
                <td><?php echo $row_Recordset11['predikat']; ?></td>
                <td align="center"><a href='deletebahasa.php?id=<?php echo $row_Recordset11['id']; ?>'>Delete</a> | <a href='edit_bahasa.php?data=<?php echo $row_Recordset11['id']; ?>'>Edit</a></td>
              </tr>
              <?php } while ($row_Recordset11 = mysql_fetch_assoc($Recordset11)); ?>
          </table>
        </div>
        
        
        <!-- JOB POSITION -->
        <div class="TabbedPanelsContent">
          <form id="form2" name="form2" method="POST">
            <table width="327" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="General">&nbsp;</td>
                <td>&nbsp;</td>
                <td><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" size="8" /></td>
              </tr>
              <tr>
                <td class="General">Posisi yang dilamar</td>
                <td>:</td>
                <td><label for="posisi"></label>
                  <input name="posisi" type="text" id="posisi" value="<?php echo $row_Recordset12['posisi']; ?>" /></td>
              </tr>
              <tr>
                <td class="General">Reference</td>
                <td>:</td>
                <td><label for="referance"></label>
                  <input name="referance" type="text" id="referance" value="<?php echo $row_Recordset12['reference']; ?>" /></td>
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
          </form>
        </div>
        
        
        <!-- DATA LAMPIRAN -->
        <div class="TabbedPanelsContent">
          <form id="form12" name="form12" method="post" action="">
            <table width="454" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="148">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td width="296"><input name="idlamp" type="text" class="hidentext" id="idlamp" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
              </tr>
              <tr>
                <td class="General">Jenis Lampiran</td>
                <td>:</td>
                <td><select name="jenislampiran" id="jenislampiran">
                  <option value="MCU">MCU</option>
                  <option value="Sertifikat Organisasi">Sertifikat Organisasi</option>
                  <option value="Pengalaman Kerja">Pengalaman Kerja</option>
                  <option value="Piagam">Piagam</option>
                </select></td>
              </tr>
              <tr>
                <td class="General">Lampiran</td>
                <td>:</td>
                <td><input type="file" name="lampiran" id="lampiranmcu" />
                  <input type="submit" name="submit2" value="Upload" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
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
	
	mysql_free_result($Recordset10);
	
	mysql_free_result($Recordset11);
	
	mysql_free_result($Recordset12);
?>