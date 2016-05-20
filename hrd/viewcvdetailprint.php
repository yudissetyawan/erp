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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_recruitment WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
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
	color: #00F;
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
<table width="1292" border="0" align="center">
  <tr>
    <td height="64" colspan="2"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="707" align="right" valign="bottom"></td>
  </tr>
  <tr>
    <td colspan="3" align="right" bgcolor="#8db4e3" class="tabel_index" id="font"><table width="1150" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="48" bgcolor="#EFEFEF" class="root"><a href="home.php">Home</a></td>
        <td width="10" align="right" bgcolor="#EFEFEF" class="root">|</td>
        <td width="68" align="right" bgcolor="#EFEFEF" class="root">HRD/GAFF</td>
        <td width="10" align="right" bgcolor="#EFEFEF" class="root">|</td>
        <td width="74" align="right" bgcolor="#EFEFEF" class="root">Recruitment</td>
        <td width="293" align="right" bgcolor="#EFEFEF" class="root">&nbsp;</td>
        <td width="647" align="right" bgcolor="#EFEFEF" class="root">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="218" valign="top"><fieldset>
      <legend>Data Pribadi</legend>
      <form id="form1" name="form1" method="post">
        <table width="708" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td class="view" align="center">&nbsp;</td>
            <td class="view" align="center">&nbsp;</td>
            <td class="view" align="center"><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset1['id']; ?>" size="10" readonly="readonly" /></td>
            <td class="view"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td width="144"  class="view"><?php echo $row_Recordset3['berat']; ?>Kg</td>
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
            <td class="view"><?php
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
                    	
			?>              </td>
            <td class="view">No. KPJ</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['nokpj']; ?></td>
            </tr>
          <tr>
            <td class="view">Alamat Rumah</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset3['alamat']; ?></td>
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
    </fieldset></td>
    <td width="2" rowspan="4" valign="top" bgcolor="#33CCFF">&nbsp;</td>
    <td valign="top"><fieldset>
      <legend>Pengalaman</legend>
      <table width="550" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="2" class="view" align="center">&nbsp;</td>
          <td class="view"  align="center"><input name="idexp" type="text" class="hidentext" id="idexp" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" />
            </td>
          </tr>
        <tr>
          <td width="153" class="view">Kategori Experiences</td>
          <td width="4">:</td>
          <td width="547" class="view"><?php echo $row_Recordset7['pengalaman']; ?></td>
          </tr>
        <tr>
          <td class="view">Nama Instansi / Organisasi</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['nama_instansi']; ?></td>
          </tr>
        <tr>
          <td class="view">Lokasi</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['lokasi']; ?></td>
          </tr>
        <tr>
          <td class="view">Bagian</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['bagian']; ?></td>
          </tr>
        <tr>
          <td class="view">Jabatan</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['jabatan']; ?></td>
          </tr>
        <tr>
          <td class="view">Uraian Singkat</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['uraian']; ?></td>
          </tr>
        <tr>
          <td class="view">Tanggal Masuk</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['tgl_masuk']; ?></td>
          </tr>
        <tr>
          <td class="view">Sampai Dengan</td>
          <td>:</td>
          <td class="view"><?php echo $row_Recordset7['tgl_keluar']; ?></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table>
    </fieldset></td>
  </tr>
  <tr>
    <td id="font" class="view"><fieldset>
      <legend>SIM</legend>
      <form id="form9" name="form9" method="post">
        <table width="709" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td class="view" align="center">&nbsp;</td>
            <td class="view">&nbsp;</td>
            <td class="view"><input name="idsim" type="text" class="hidentext" id="idsim" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
            </tr>
          <tr>
            <td width="161" class="view">Golongan SIM</td>
            <td width="12" class="view">:</td>
            <td width="535" class="view"><?php echo $row_Recordset4['sim_gol']; ?></td>
            </tr>
          <tr>
            <td class="view">Masa Berlaku</td>
            <td class="view">:</td>
            <td class="view"><?php echo $row_Recordset4['masaberlaku']; ?></td>
            </tr>
          <tr>
            <td class="view">&nbsp;</td>
            <td class="view">&nbsp;</td>
            <td class="view">&nbsp;</td>
            </tr>
          <tr>
            <td class="view">&nbsp;</td>
            <td class="view">&nbsp;</td>
            <td class="view">&nbsp;</td>
            </tr>
          </table>
      </form>
    </fieldset></td>
    <td id="font"class="view"><form id="form10" name="form10" method="post">
      <fieldset>
        <legend>Bahasa yang dikuasai</legend>
        <table width="551" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="125" class="view" align="center">&nbsp;</td>
            <td width="15">&nbsp;</td>
            <td width="407"><input name="idbahasa" type="text" class="hidentext" id="idbahasa" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" /></td>
            </tr>
          <tr>
            <td class="view">Bahasa yang dikuasai</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset5['bahasa']; ?></td>
            </tr>
          <tr>
            <td class="view">Predikat</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset5['predikat']; ?></td>
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
      </fieldset>
    </form></td>
  </tr>
  <tr>
    <td><fieldset>
      <legend>Penghargaan</legend>
      <form id="form11" name="form11" method="post">
        <table width="708" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="view" align="center">&nbsp;</td>
            <td class="view"><input name="idapr" type="text" class="hidentext" id="idapr" value="<?php echo $row_Recordset1['id']; ?>" readonly="readonly" />
              <input name="tipe_penghargaan" type="text" class="hidentext" id="tipe_penghargaan" value="Reward" /></td>
            </tr>
          <tr>
            <td width="164" class="view">Nama Penghargaan</td>
            <td width="4" class="view">:</td>
            <td width="540" class="view"><?php echo $row_Recordset6['nama_penghargaan']; ?></td>
            </tr>
          <tr>
            <td class="view">Provider</td>
            <td class="view">:</td>
            <td class="view"><?php echo $row_Recordset6['provider']; ?></td>
            </tr>
          <tr>
            <td class="view">Tahun</td>
            <td class="view">:</td>
            <td class="view"><?php echo $row_Recordset6['tahun']; ?></td>
            </tr>
          <tr>
            <td class="view">Remark</td>
            <td class="view">:</td>
            <td class="view"><?php echo $row_Recordset6['remark']; ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="view">&nbsp;</td>
            <td class="view">&nbsp;</td>
            </tr>
          </table>
        
      </form>
    </fieldset></td>
    <td class="view" id="font2"><fieldset>
      <legend>Posisi</legend>
      <form id="form2" name="form2" method="post">
        <table width="553" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="128" class="view" align="center">&nbsp;</td>
            <td width="10">&nbsp;</td>
            <td width="421"><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" value="<?php echo $row_Recordset1['id']; ?>" /></td>
            </tr>
          <tr>
            <td class="view"> Posisi yang dilamar</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset9['posisi']; ?></td>
            </tr>
          <tr>
            <td class="view">Reference</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset9['reference']; ?></td>
            </tr>
          <tr>
            <td class="view">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td height="25" class="view">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          </table>  
      </form>
    </fieldset></td>
  </tr>
  <tr>
    <td width="709" height="139"><fieldset>
      <legend>Tes Kesehatan</legend>
      <form id="form3" name="form3" method="post">
        <table width="600" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td colspan="2" class="view" align="center">&nbsp;</td>
            <td><input name="idmcu" type="text" class="hidentext" id="idmcu" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
            </tr>
          <tr>
            <td width="161" class="view">Tanggal MCU</td>
            <td width="4">:</td>
            <td width="431" class="view"><?php echo $row_Recordset8['date']; ?></td>
            </tr>
          <tr>
            <td class="view">Masa Berlaku</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset8['exp_date']; ?></td>
            </tr>
          <tr>
            <td class="view">Status</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset8['status']; ?></td>
            </tr>
          <tr>
            <td class="view">Kategori</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset8['kategori']; ?></td>
            </tr>
          <tr>
            <td class="view">Remark</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset8['remark']; ?></td>
            </tr>
          <tr>
            <td class="view">Saran</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset8['saran']; ?></td>
            </tr>
          <tr>
            <td height="18">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          </table>
        
      </form>
    </fieldset></td>
    <td  class="view" id="font"><fieldset>
      <legend>Training</legend>
      <form id="form5" name="form5" method="post">
        <table width="555" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="121" class="view" align="center">&nbsp;</td>
            <td width="12">&nbsp;</td>
            <td width="134" class="view"><input name="id_training" type="text" class="hidentext" id="id_training" value="<?php echo $row_Recordset1['id']; ?>" size="5" readonly="readonly" /></td>
            <td width="89" class="view">&nbsp;</td>
            <td width="7" class="view">&nbsp;</td>
            <td width="186" class="view">&nbsp;</td>
            </tr>
          <tr>
            <td class="view">Kategori </td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset2['kategori']; ?></td>
            <td class="view">No. Sertifikat</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset2['no_certificate']; ?></td>
            </tr>
          <tr>
            <td class="view">Nama</td>
            <td>&nbsp;</td>
            <td class="view"><?php echo $row_Recordset2['jenis_training']; ?></td>
            <td class="view">Penyelenggara</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset2['provider']; ?></td>
            </tr>
          <tr>
            <td class="view">Tanggal</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset2['date']; ?></td>
            <td class="view">Klasifikasi</td>
            <td>:</td>
            <td><select name="klasifikasi" id="klasifikasi">
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
            <td class="view">Masa Berlaku</td>
            <td>:</td>
            <td class="view"><?php echo $row_Recordset2['exp_date']; ?></td>
            <td class="view">Remark</td>
            <td>:</td>
            <td><?php echo $row_Recordset2['remark']; ?></td>
            </tr>
          <tr>
            <td class="view">&nbsp;</td>
            <td>:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td height="12" class="view">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          </table>
      </form>
    </fieldset></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset3);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>
