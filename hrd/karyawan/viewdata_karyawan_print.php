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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data of Employee</title>
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

<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
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
<?php { include "../../date.php"; require_once "../../dateformat_funct.php"; } ?>
<table width="1200" border="0" align="center">
  <tr>
    <td height="64" colspan="2"><img src="../../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="707" align="right" valign="bottom"></td>
  </tr>
  <tr>
    <td colspan="3" align="right" bgcolor="#8db4e3" class="tabel_index" id="font"><table width="1535" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="64" bgcolor="#EFEFEF" class="root"><a href="../../home.php">Home</a></td>
        <td width="13" align="right" bgcolor="#EFEFEF" class="root">|</td>
        <td width="90" align="right" bgcolor="#EFEFEF" class="root">Personal Data</td>
        <td width="13" align="right" bgcolor="#EFEFEF" class="root">|</td>
        <td width="298" align="right" bgcolor="#EFEFEF" class="root"><?php echo $row_Recordset1['nik']; ?> - <?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
        <td width="191" align="right" bgcolor="#EFEFEF" class="root">&nbsp;</td>
        <td width="866" align="right" bgcolor="#EFEFEF" class="root">&nbsp;</td>
        </tr>
    </table>
    </td>
  </tr>
  
  
  <tr>
    <td height="218" valign="top"><fieldset>
      <legend>Data Pribadi</legend>
      <form id="form1" name="form1" method="POST">
      <table width="830" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="130"></td>
                <td width="10">&nbsp;</td>
                <td width="290"><input name="id_datapribadi" type="text" class="hidentext" id="id_datapribadi" value="<?php echo $row_Recordset1['id_datapribadi']; ?>" size="5" readonly="readonly" /></td>
                <td width="125">&nbsp;</td>
                <td width="10">&nbsp;</td>
                <td width="200">&nbsp;</td>
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
                <td> Berlaku KTP Sampai dengan</td>
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
					if ($umur>='2013') {
						echo "--";
					} else {
						echo $umur.' '."Tahun";
					} ?>
                </td>
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
            </table>
        </form>
    </fieldset>
    </td>
    
    
    <td width="2" rowspan="4" valign="top" bgcolor="#33CCFF">&nbsp;</td>
    <td valign="top"><fieldset>
      <legend>Training</legend>
      <table border="1" width="680">
        <tr class="tabel_header">
          <td width="20">No.</td>
          <td width="50">Kategori</td>
          <td width="80">Jenis Training</td>
          <td width="90">Tanggal</td>
          <td width="70">Tanggal Kadaluarsa</td>
          <td width="100">No. Sertifikat</td>
          <td width="100">Penyelenggara</td>
          <td>Catatan</td>
        </tr>
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
        <?php } while ($row_Recordset11 = mysql_fetch_assoc($Recordset11)); ?>
      </table>
    </fieldset>
    </td>
  </tr>
  
  
  <tr>
    <td id="font" class="view"><br /><fieldset>
      <legend>SIM</legend>
      <form id="form9" name="form9" method="post">
        <table border="1" width="250">
          <tr class="tabel_header">
            <td>No.</td>
            <td>Golongan S I M</td>
            <td>Masa Berlaku</td>
          </tr>
          <?php do { ?>
          <tr class="tabel_body">
            <td align="center" width="25"><?php $r=$r+1; echo $r; ?></td>
            <td align="center" width="100"><?php echo $row_Recordset7['sim_gol']; ?></td>
            <td align="center" width="125"><?php echo functddmmmyyyy($row_Recordset7['masaberlaku']); ?></td>
          </tr>
          <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
        </table>
      </form>
    </fieldset>
    </td>
    
    
    <td id="font"class="view"><form id="form10" name="form10" method="post">
      <fieldset>
        <legend>Bahasa yang dikuasai</legend>
        <table width="300" border="1">
          <tr class="tabel_header">
            <td width="25">No.</td>
            <td width="125">Bahasa</td>
            <td width="150">Predikat</td>
          </tr>
          <?php do { ?>
          <tr class="tabel_body">
            <td align="center"><?php $s=$s+1; echo $s ?></td>
            <td><?php echo $row_Recordset10[bahasa]; ?></td>
            <td><?php echo $row_Recordset10[predikat]; ?></td>
          </tr>
          <?php } while ($row_Recordset10 = mysql_fetch_assoc($Recordset10)); ?>
        </table>
      </fieldset>
    </form>
    </td>
  </tr>
  
  
  <tr>
    <td><fieldset>
      <legend>Penghargaan</legend>
      <form id="form11" name="form11" method="post">
        <table border="1" width="800">
          <tr class="tabel_header">
            <td width="25">No.</td>
            <td>Nama Penghargaan</td>
            <td>Penyelenggara</td>
            <td>Tahun</td>
            <td>Catatan</td>
            <td>Tipe Penghargaan</td>
          </tr>
          <?php do { ?>
          <tr class="tabel_body">
            <td align="center"><?php $q=$q+1; echo $q; ?></td>
            <td><?php echo $row_Recordset6['nama_penghargaan']; ?></td>
            <td><?php echo $row_Recordset6['provider']; ?></td>
            <td align="center"><?php echo $row_Recordset6['tahun']; ?></td>
            <td><?php echo $row_Recordset6['remark']; ?></td>
            <td><?php echo $row_Recordset6['tipe_penghargaan']; ?></td>
          </tr>
          <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
        </table>
      </form>
    </fieldset>
    </td>
    
    
    <td class="view" id="font2"><fieldset>
      <legend>Posisi</legend>
      <form id="form2" name="form2" method="post">
        <table width="553" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="128" class="view" align="center">&nbsp;</td>
            <td width="10">&nbsp;</td>
            <td width="421"><input name="id_pelamar" type="text" class="hidentext" id="id_pelamar" /></td>
            </tr>
          <tr>
            <td class="view"> Posisi yang dilamar</td>
            <td>:</td>
<td class="view"></td>
            </tr>
          <tr>
            <td class="view">Reference</td>
            <td>:</td>
<td class="view"></td>
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
    <td width="709"><fieldset>
      <legend>Tes Kesehatan</legend>
      <form id="form3" name="form3" method="post">
        <table border="1" width="800">
          <tr class="tabel_header">
            <td width="25">No.</td>
            <td width="75">Tanggal</td>
            <td width="75">Tanggal Kadaluarsa</td>
            <td width="55">Kategori</td>
            <td width="90">Status</td>
            <td width="220">Catatan</td>
            <td>Saran</td>
          </tr>
          <?php do { ?>
          <tr class="tabel_body">
            <td align="center"><?php $o=$o+1; echo $o ?></td>
            <td align="center"><?php echo functddmmmyyyy($row_Recordset4['date']); ?></td>
            <td align="center"><?php echo functddmmmyyyy($row_Recordset4['exp_date']); ?></td>
            <td align="center"><?php echo $row_Recordset4['kategori']; ?></td>
            <td><?php echo $row_Recordset4['status']; ?></td>
            <td><?php echo $row_Recordset4['remark']; ?></td>
            <td><?php echo $row_Recordset4['saran']; ?></td>
          </tr>
          <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
        </table>
      </form>
    </fieldset>
    </td>
    
    
    <td class="view" id="font"><fieldset>
      <legend>Pengalaman</legend>
      <form id="form5" name="form5" method="post">
        <table border="1" width="680">
          <tr class="tabel_header">
            <td width="25">No.</td>
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
            <td align="center"><?php $p=$p+1; echo $p ?></td>
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
    </fieldset></td>
  </tr>
  
  
  <tr>
    <td height="139"><br /><br /><fieldset>
      <legend>Data Keluarga</legend>
      <form id="form8" name="form8" method="post">
        <table width="651" border="0" cellspacing="0" cellpadding="0">
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
            <td class="General"><?php echo $row_Recordset8['umur']; ?></td>
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
          </table>
      </form>
    </fieldset>
    </td>
    
    <td valign="top" bgcolor="#33CCFF">&nbsp;</td>
    <td  class="view" id="font3"><fieldset>
      <legend>Data Orang Tua</legend>
      <form id="form7" name="form7" method="post">
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
    </fieldset></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset3);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);

mysql_free_result($Recordset9);

mysql_free_result($Recordset10);

mysql_free_result($Recordset11);

mysql_free_result($Recordset12);

mysql_free_result($Recordset13);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>
