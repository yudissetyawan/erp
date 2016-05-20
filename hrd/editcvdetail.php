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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE h_datapribadi SET jk=%s, status=%s, noktp=%s, berlakuktp=%s, tempat_lahir=%s, tgl_lahir=%s, alamat=%s, poscode=%s, notlp=%s, nohp=%s, agama=%s, berat=%s, tinggi=%s, pendidikan=%s, jurusan=%s, namapend=%s, nokpj=%s, gol_darah=%s, no_npwp=%s, email=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['jk'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['noktp'], "text"),
                       GetSQLValueString($_POST['berlakuktp'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kodepos'], "text"),
                       GetSQLValueString($_POST['notlp'], "text"),
                       GetSQLValueString($_POST['nohp'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['berat'], "text"),
                       GetSQLValueString($_POST['tinggi'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['namapend'], "text"),
                       GetSQLValueString($_POST['nokpj'], "text"),
                       GetSQLValueString($_POST['gol_darah'], "text"),
                       GetSQLValueString($_POST['nonpwp'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id_datapribadi'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form9")) {
  $updateSQL = sprintf("UPDATE h_sim SET sim_gol=%s, masaberlaku=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['gol_sim'], "text"),
                       GetSQLValueString($_POST['masaberlaku'], "text"),
                       GetSQLValueString($_POST['idsim'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form10")) {
  $updateSQL = sprintf("UPDATE h_bahasa SET bahasa=%s, predikat=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['bahasa'], "text"),
                       GetSQLValueString($_POST['predikat'], "text"),
                       GetSQLValueString($_POST['idbahasa'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form11")) {
  $updateSQL = sprintf("UPDATE h_penghargaan SET nama_penghargaan=%s, provider=%s, tahun=%s, remark=%s, tipe_penghargaan=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['nama_penghargaan'], "text"),
                       GetSQLValueString($_POST['pemberi'], "text"),
                       GetSQLValueString($_POST['tahun'], "text"),
                       GetSQLValueString($_POST['remarkap'], "text"),
                       GetSQLValueString($_POST['tipe_penghargaan'], "text"),
                       GetSQLValueString($_POST['idapr'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form5")) {
  $updateSQL = sprintf("UPDATE h_training SET kategori=%s, jenis_training=%s, `date`=%s, exp_date=%s, no_certificate=%s, provider=%s, remark=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['jenis_training'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['exp_date2'], "text"),
                       GetSQLValueString($_POST['no_certificate'], "text"),
                       GetSQLValueString($_POST['provider'], "text"),
                       GetSQLValueString($_POST['remark2'], "text"),
                       GetSQLValueString($_POST['id_training'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE h_job_position SET posisi=%s, reference=%s WHERE id_pelamar=%s",
                       GetSQLValueString($_POST['posisi'], "text"),
                       GetSQLValueString($_POST['reference'], "text"),
                       GetSQLValueString($_POST['id_pelamar'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE h_mcu SET `date`=%s, exp_date=%s, kategori=%s, status=%s, remark=%s, saran=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['datemcu'], "text"),
                       GetSQLValueString($_POST['exp_date'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['statusmcu'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['saran'], "text"),
                       GetSQLValueString($_POST['idmcu'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form4")) {
  $updateSQL = sprintf("UPDATE h_experiences SET pengalaman=%s, nama_instansi=%s, lokasi=%s, bagian=%s, jabatan=%s, uraian=%s, tgl_masuk=%s, tgl_keluar=%s WHERE id_datapribadi=%s",
                       GetSQLValueString($_POST['pengalaman'], "text"),
                       GetSQLValueString($_POST['nama_instansi'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['bagian'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['uraian'], "text"),
                       GetSQLValueString($_POST['tgl_masuk'], "text"),
                       GetSQLValueString($_POST['tgl_keluar'], "text"),
                       GetSQLValueString($_POST['idexp'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$totalRows_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $totalRows_Recordset1 = $_GET['data'];
}
$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM h_datapribadi WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM h_training WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM h_sim WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset5 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset5 = sprintf("SELECT * FROM h_bahasa WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset5, "int"));
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

$colname_Recordset6 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset6 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset6 = sprintf("SELECT * FROM h_penghargaan WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset6, "int"));
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

$colname_Recordset7 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset7 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset7 = sprintf("SELECT * FROM h_experiences WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset7, "int"));
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

$colname_Recordset8 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset8 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset8 = sprintf("SELECT * FROM h_mcu WHERE id_datapribadi = %s", GetSQLValueString($colname_Recordset8, "int"));
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

$colname_Recordset9 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset9 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset9 = sprintf("SELECT * FROM h_job_position WHERE id_pelamar = %s", GetSQLValueString($colname_Recordset9, "text"));
$Recordset9 = mysql_query($query_Recordset9, $core) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

mysql_select_db($database_core, $core);
$query_Recordset10 = "SELECT * FROM h_jenis_training";
$Recordset10 = mysql_query($query_Recordset10, $core) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.glossymenu {margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: 1px solid #9A9A9A;
	border-bottom-width: 0;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
.glossymenu {	margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: thin solid #000;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	line-height: normal;
	color: #000;
}
-->
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
	text-decoration: none;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style>
</head>

<body>
<?php {
	include "../date.php";}?>
<table width="1285" border="0" align="center">
  <tr>
    <td width="1271" valign="top"><table width="210" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
          <table width="708" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset1['id']; ?>" size="10" readonly="readonly" /></td>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="155" class="General">No. Pelamar</td>
              <td width="12">:</td>
              <td width="276"><input name="no" type="text" id="no" value="<?php echo $row_Recordset1['no_pelamar']; ?>" size="7" readonly="readonly" /></td>
              <td>No. Telp</td>
              <td>:</td>
              <td><input name="notlp" type="text" id="notlp" value="<?php echo $row_Recordset3['notlp']; ?>" /></td>
              </tr>
            <tr>
              <td class="General">Nama</td>
              <td>:</td>
              <td><input name="nama2" type="text" id="nama2" value="<?php echo $row_Recordset1['firstname'];  ?>"<?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?> size="30" readonly="readonly" /></td>
              <td>Agama</td>
              <td>:</td>
              <td><label for="agama"></label>
                <input name="agama2" type="text" id="agama" value="<?php echo $row_Recordset3['agama']; ?>" /></td>
              </tr>
            <tr>
              <td class="General">Jenis Kelamin</td>
              <td>:</td>
              <td><input type="radio" name="jk" value="Pria" <?php echo ($row_Recordset3['jk']=='Pria')?'checked':'' ?> size="17">Pria

<input type="radio" name="jk" value="Wanita" <?php echo ($row_Recordset3['jk']=='Wanita')?'checked':'' ?> size="17">Wanita</td>
              <td width="110" class="General">Berat Badan</td>
              <td width="4">:</td>
              <td width="144"><input name="berat" type="text" id="berat" value="<?php echo $row_Recordset3['berat']; ?>" size="10" />
                Kg</td>
              </tr>
            <tr>
              <td class="General">Status</td>
              <td>:</td>
              <td><label for="status"></label>
                <input name="status2" type="text" id="status" value="<?php echo $row_Recordset3['status']; ?>" /></td>
              <td class="General">Tinggi Badan</td>
              <td>:</td>
              <td><input name="tinggi" type="text" id="tinggi" value="<?php echo $row_Recordset3['tinggi']; ?>" size="10" />
                Cm</td>
              </tr>
            <tr>
              <td class="General">No. KTP</td>
              <td>:</td>
              <td><input name="noktp" type="text" id="noktp" value="<?php echo $row_Recordset3['noktp']; ?>" size="18" maxlength="16" /></td>
              <td class="General">Pendidikan Terakhir</td>
              <td>:</td>
              <td><label for="pendidikan"></label>
                <input name="pendidikan" type="text" id="pendidikan" value="<?php echo $row_Recordset3['pendidikan']; ?>" /></td>
              </tr>
            <tr>
              <td class="General"> Berlaku KTP Sampai dengan</td>
              <td>:</td>
              <td><input name="berlakuktp" type="text" id="tanggal4" value="<?php echo $row_Recordset3['berlakuktp']; ?>" size="18" /></td>
              <td class="General">Nama Sekolah/PT</td>
              <td>:</td>
              <td><input name="namapend" type="text" class="huruf_besar" id="namapend" value="<?php echo $row_Recordset3['namapend']; ?>" /></td>
              </tr>
            <tr>
              <td class="General">Tempat / Tgl. Lahir</td>
              <td>:</td>
              <td><input name="tempat_lahir" type="text" class="huruf_besar" id="tempat_lahir" value="<?php echo $row_Recordset3['tempat_lahir']; ?>" size="15" />
                <strong>/</strong>
                <input name="tgl_lahir" type="text" id="tanggal1" value="<?php echo $row_Recordset3['tgl_lahir']; ?>" size="15" /></td>
              <td class="General">Jurusan</td>
              <td>:</td>
              <td><input name="jurusan" type="text" class="huruf_besar" id="jurusan" value="<?php echo $row_Recordset3['jurusan']; ?>" /></td>
              </tr>
            <tr>
              <td class="General">Umur</td>
              <td>:</td>
              <td><input name="umur" type="text" id="umur" size="20"  />
                Tahun</td>
              <td class="General">No. KPJ</td>
              <td>:</td>
              <td><input name="nokpj" type="text" id="nokpj" value="<?php echo $row_Recordset3['nokpj']; ?>" /></td>
              </tr>
            <tr>
              <td class="General">Alamat Rumah</td>
              <td>:</td>
              <td><textarea name="alamat" cols="30" rows="2" class="huruf_besar" id="alamat"><?php echo $row_Recordset3['alamat']; ?></textarea></td>
              <td class="General">Gol. Darah</td>
              <td>:</td>
              <td><label for="gol_darah"></label>
                <input name="gol_darah" type="text" id="gol_darah" value="<?php echo $row_Recordset3['gol_darah']; ?>" /></td>
              </tr>
            <tr>
              <td>Kode Pos </td>
              <td>:</td>
              <td><input name="kodepos" type="text" id="kodepos" value="<?php echo $row_Recordset3['poscode']; ?>" size="10" /></td>
              <td class="General">No. NPWP</td>
              <td>:</td>
              <td><input name="nonpwp" type="text" id="nonpwp" value="<?php echo $row_Recordset3['no_npwp']; ?>" /></td>
              </tr>
            <tr>
              <td>No. HP</td>
              <td>:</td>
              <td><input name="nohp" type="text" id="textfield2" value="<?php echo $row_Recordset3['nohp']; ?>" /></td>
              <td>Email</td>
              <td>:</td>
              <td><input name="email" type="text" id="email" value="<?php echo $row_Recordset3['email']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="submit3" id="submit2" value="Submit" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form1" />
        </form>
          <hr /></td>
        <td width="3" rowspan="8" class="tabel_index">&nbsp;</td>
        <td width="488"><form action="<?php echo $editFormAction; ?>" id="form4" name="form4" method="POST">
          <table width="600" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td colspan="2" class="General"><strong>Experiences</strong></td>
              <td class="General"><input name="idexp" type="text" class="hidentext" id="idexp" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <td width="163" class="General">Kategori Experiences</td>
              <td width="4">:</td>
              <td width="454" class="General"><label for="pengalaman"></label>
                <input name="pengalaman" type="text" id="pengalaman" value="<?php echo $row_Recordset7['pengalaman']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Nama Instansi / Organisasi</td>
              <td>:</td>
              <td class="General"><input name="nama_instansi" type="text" class="huruf_besar" id="nama_instansi" value="<?php echo $row_Recordset7['nama_instansi']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Lokasi</td>
              <td>:</td>
              <td class="General"><input name="lokasi" type="text" class="huruf_besar" id="lokasi" value="<?php echo $row_Recordset7['lokasi']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Bagian</td>
              <td>:</td>
              <td class="General"><input name="bagian" type="text" class="huruf_besar" id="bagian" value="<?php echo $row_Recordset7['bagian']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Jabatan</td>
              <td>:</td>
              <td class="General"><input name="jabatan" type="text" class="huruf_besar" id="jabatan" value="<?php echo $row_Recordset7['jabatan']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Uraian Singkat</td>
              <td>:</td>
              <td class="General"><textarea name="uraian" id="uraian" cols="45" rows="2"><?php echo $row_Recordset7['uraian']; ?></textarea></td>
            </tr>
            <tr>
              <td class="General">Tanggal Masuk</td>
              <td>:</td>
              <td class="General"><input name="tgl_masuk" type="text" id="tanggal2" value="<?php echo $row_Recordset7['tgl_masuk']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Sampai Dengan</td>
              <td>:</td>
              <td class="General"><input name="tgl_keluar" type="text" id="tanggal3" value="<?php echo $row_Recordset7['tgl_keluar']; ?>" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="submit4" id="submit3" value="Submit" /></td>
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
          <hr />
          <input type="hidden" name="MM_update" value="form4" />
        </form></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="488" rowspan="4"><form action="<?php echo $editFormAction; ?>" id="form3" name="form3" method="POST">
          <table width="600" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td colspan="2" class="General"><strong>Medical Check Up</strong></td>
              <td><input name="idmcu" type="text" class="hidentext" id="idmcu" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
            </tr>
            <tr>
              <td width="152" class="General">Tanggal MCU</td>
              <td width="4">:</td>
              <td width="440"><input name="datemcu" type="text" id="tanggal6" value="<?php echo $row_Recordset8['date']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Masa Berlaku</td>
              <td>:</td>
              <td><input name="exp_date" type="text" id="exp_date" value="<?php echo $row_Recordset8['exp_date']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Status</td>
              <td>:</td>
              <td><label for="statusmcu"></label>
                <input name="statusmcu" type="text" id="statusmcu" value="<?php echo $row_Recordset8['status']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Kategori</td>
              <td>:</td>
              <td><label for="kategori"></label>
                <input name="kategori2" type="text" id="kategori" value="<?php echo $row_Recordset8['kategori']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Remark</td>
              <td>:</td>
              <td><textarea name="remark" id="remark" cols="45" rows="2"><?php echo $row_Recordset8['remark']; ?></textarea></td>
            </tr>
            <tr>
              <td class="General">Saran</td>
              <td>:</td>
              <td><textarea name="saran" id="saran" cols="45" rows="4"><?php echo $row_Recordset8['saran']; ?></textarea></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="Submit2" id="Submit2" value="Submit" /></td>
            </tr>
          </table>
          <hr />
          <input type="hidden" name="MM_update" value="form3" />
        </form></td>
      </tr>
      <tr>
        <td><form action="<?php echo $editFormAction; ?>" id="form9" name="form9" method="POST">
          <table width="709" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td class="General"><strong>SIM</strong></td>
              <td class="General">&nbsp;</td>
              <td class="General"><input name="idsim" type="text" class="hidentext" id="idsim" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <td width="155" class="General">Golongan SIM</td>
              <td width="12" class="General">:</td>
              <td width="541" class="General"><label for="gol_sim"></label>
                <input name="gol_sim" type="text" id="gol_sim" value="<?php echo $row_Recordset4['sim_gol']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Masa Berlaku</td>
              <td class="General">:</td>
              <td class="General"><input name="masaberlaku" type="text" id="tanggal5" value="<?php echo $row_Recordset4['masaberlaku']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td class="General">&nbsp;</td>
              <td class="General">&nbsp;</td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td class="General">&nbsp;</td>
              <td class="General"><input type="submit" name="submit8" id="submit7" value="Submit" /></td>
            </tr>
          </table>
          <hr />
          <input type="hidden" name="MM_update" value="form9" />
        </form></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><form action="<?php echo $editFormAction; ?>" id="form10" name="form10" method="POST">
          <table width="710" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td width="158" class="General"><strong>Bahasa yang dikuasai</strong></td>
              <td width="12">&nbsp;</td>
              <td width="542"><input name="idbahasa" type="text" class="hidentext" id="idbahasa" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <td class="General">Bahasa yang dikuasai</td>
              <td>:</td>
              <td><input name="bahasa" type="text" class="huruf_besar" id="bahasa" value="<?php echo $row_Recordset5['bahasa']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Predikat</td>
              <td>:</td>
              <td><label for="predikat"></label>
                <input name="predikat" type="text" id="predikat" value="<?php echo $row_Recordset5['predikat']; ?>" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="submit9" id="submit8" value="Submit" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <hr />
          <input type="hidden" name="MM_update" value="form10" />
        </form></td>
      </tr>
      <tr>
        <td rowspan="3"><form action="<?php echo $editFormAction; ?>" id="form11" name="form11" method="POST">
          <table width="708" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" class="General"><strong>Penghargaan yang diraih</strong></td>
              <td class="General"><input name="idapr" type="text" class="hidentext" id="idapr" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" />
                <input name="tipe_penghargaan" type="text" class="hidentext" id="tipe_penghargaan" value="Reward" /></td>
            </tr>
            <tr>
              <td width="160" class="General">Nama Penghargaan</td>
              <td width="10" class="General">:</td>
              <td width="518" class="General"><input name="nama_penghargaan" type="text" class="huruf_besar" id="nama_penghargaan" value="<?php echo $row_Recordset6['nama_penghargaan']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Provider</td>
              <td class="General">:</td>
              <td class="General"><input name="pemberi" type="text" class="huruf_besar" id="pemberi" value="<?php echo $row_Recordset6['provider']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Tahun</td>
              <td class="General">:</td>
              <td class="General"><input name="tahun" type="text" id="tahun" value="<?php echo $row_Recordset6['tahun']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Remark</td>
              <td class="General">:</td>
              <td class="General"><textarea name="remarkap" id="remarkap" cols="45" rows="2"><?php echo $row_Recordset6['remark']; ?></textarea></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="General">&nbsp;</td>
              <td class="General"><input type="submit" name="submit5" id="submit5" value="Submit" /></td>
            </tr>
          </table>
          <hr />
          <input type="hidden" name="MM_update" value="form11" />
        </form></td>
        <td width="488" height="2"><form action="<?php echo $editFormAction; ?>" id="form2" name="form2" method="POST">
          <table width="600
          " border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="159" class="General"><strong>Job Position</strong></td>
              <td width="10">&nbsp;</td>
              <td width="538"><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" /></td>
            </tr>
            <tr>
              <td class="General"> Posisi yang dilamar</td>
              <td>:</td>
              <td><input name="posisi" type="text" class="huruf_besar" id="posisi" value="<?php echo $row_Recordset9['posisi']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Reference</td>
              <td>:</td>
              <td><input name="reference" type="text" class="huruf_besar" id="reference" value="<?php echo $row_Recordset9['reference']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form2" />
        </form></td>
      </tr>
      <tr>
        <td height="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="488">&nbsp;</td>
      </tr>
      <tr>
        <td><form action="<?php echo $editFormAction; ?>" id="form5" name="form5" method="POST">
          <table width="707" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="113" class="General"><strong>Training</strong></td>
              <td width="6">&nbsp;</td>
              <td width="212" class="General"><input name="id_training" type="text" class="hidentext" id="id_training" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
              <td width="109" class="General">&nbsp;</td>
              <td width="12" class="General">&nbsp;</td>
              <td width="234" class="General">&nbsp;</td>
            </tr>
            <tr>
              <td class="General">Kategori </td>
              <td>:</td>
              <td class="General"><input type="radio" name="kategori" id="radio" value="1" />
                Management Training</td>
              <td class="General">No. Sertifikat</td>
              <td>:</td>
              <td><input name="no_certificate" type="text" id="no_certificate" value="<?php echo $row_Recordset2['no_certificate']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="General"><input type="radio" name="kategori" id="radio2" value="2" />
                Skill Training</td>
              <td class="General">Penyelenggara</td>
              <td>:</td>
              <td><input name="provider" type="text" class="huruf_besar" id="provider" value="<?php echo $row_Recordset2['provider']; ?>" /></td>
            </tr>
            <tr>
              <td class="General">Nama</td>
              <td>:</td>
              <td class="General"><select name="jenis_training" id="jenis_training">
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset10['jenis_training']?>"<?php if (!(strcmp($row_Recordset10['jenis_training'], $row_Recordset2['jenis_training']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset10['jenis_training']?></option>
                <?php
} while ($row_Recordset10 = mysql_fetch_assoc($Recordset10));
  $rows = mysql_num_rows($Recordset10);
  if($rows > 0) {
      mysql_data_seek($Recordset10, 0);
	  $row_Recordset10 = mysql_fetch_assoc($Recordset10);
  }
?>
                
              </select>                
              <?php {include "popup.html";}?></td>
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
              <td class="General">Tanggal </td>
              <td>:</td>
              <td><input name="date" type="text" id="tanggal7" value="<?php echo $row_Recordset2['date']; ?>" /></td>
              <td class="General">Remark</td>
              <td>:</td>
              <td><textarea name="remark2" id="remark2" cols="25" rows="3"><?php echo $row_Recordset2['remark']; ?></textarea></td>
            </tr>
            <tr>
              <td class="General">Masa Berlaku</td>
              <td>:</td>
              <td><input name="exp_date2" type="text" id="exp_date2" value="<?php echo $row_Recordset2['exp_date']; ?>" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="General">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="submit2" id="submit4" value="Submit" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form5" />
        </form></td>
        <td class="tabel_index">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset3);

mysql_free_result($Recordset2);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);
?>
