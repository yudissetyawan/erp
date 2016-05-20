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

mysql_select_db($database_core, $core);
$query_h_employee_dari = "SELECT id, firstname, midlename, lastname FROM h_employee";
$h_employee_dari = mysql_query($query_h_employee_dari, $core) or die(mysql_error());
$row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
$totalRows_h_employee_dari = mysql_num_rows($h_employee_dari);

$colname_dibuat_oleh = "-1";
if (isset($_GET['data'])) {
  $colname_dibuat_oleh = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dibuat_oleh = sprintf("SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, q_cpar WHERE q_cpar.id = %s AND h_employee.id = q_cpar.dibuat_oleh", GetSQLValueString($colname_dibuat_oleh, "int"));
$dibuat_oleh = mysql_query($query_dibuat_oleh, $core) or die(mysql_error());
$row_dibuat_oleh = mysql_fetch_assoc($dibuat_oleh);
$totalRows_dibuat_oleh = mysql_num_rows($dibuat_oleh);

$colname_disetujui_oleh = "-1";
if (isset($_GET['data'])) {
  $colname_disetujui_oleh = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_disetujui_oleh = sprintf("SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM q_cpar, h_employee WHERE q_cpar.id = %s AND q_cpar.disetujui_oleh = h_employee.id", GetSQLValueString($colname_disetujui_oleh, "int"));
$disetujui_oleh = mysql_query($query_disetujui_oleh, $core) or die(mysql_error());
$row_disetujui_oleh = mysql_fetch_assoc($disetujui_oleh);
$totalRows_disetujui_oleh = mysql_num_rows($disetujui_oleh);

$colname_dianalisa_oleh = "-1";
if (isset($_GET['data'])) {
  $colname_dianalisa_oleh = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_dianalisa_oleh = sprintf("SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM q_cpar, h_employee WHERE q_cpar.id = %s AND h_employee.id = q_cpar.dianalisa_oleh", GetSQLValueString($colname_dianalisa_oleh, "int"));
$dianalisa_oleh = mysql_query($query_dianalisa_oleh, $core) or die(mysql_error());
$row_dianalisa_oleh = mysql_fetch_assoc($dianalisa_oleh);
$totalRows_dianalisa_oleh = mysql_num_rows($dianalisa_oleh);

$colname_penanggung_jawab = "-1";
if (isset($_GET['data'])) {
  $colname_penanggung_jawab = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_penanggung_jawab = sprintf("SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname   FROM q_cpar, h_employee WHERE q_cpar.id = %s AND q_cpar.penanggung_jawab = h_employee.id", GetSQLValueString($colname_penanggung_jawab, "int"));
$penanggung_jawab = mysql_query($query_penanggung_jawab, $core) or die(mysql_error());
$row_penanggung_jawab = mysql_fetch_assoc($penanggung_jawab);
$totalRows_penanggung_jawab = mysql_num_rows($penanggung_jawab);

$colname_diperiksa_oleh = "-1";
if (isset($_GET['data'])) {
  $colname_diperiksa_oleh = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_diperiksa_oleh = sprintf("SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname  FROM q_cpar, h_employee WHERE q_cpar.id = %s AND h_employee.id  = q_cpar.diperiksa_oleh", GetSQLValueString($colname_diperiksa_oleh, "int"));
$diperiksa_oleh = mysql_query($query_diperiksa_oleh, $core) or die(mysql_error());
$row_diperiksa_oleh = mysql_fetch_assoc($diperiksa_oleh);
$totalRows_diperiksa_oleh = mysql_num_rows($diperiksa_oleh);

$colname_qmr = "-1";
if (isset($_GET['data'])) {
  $colname_qmr = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_qmr = sprintf("SELECT h_employee.firstname, h_employee.midlename, h_employee.lastname   FROM q_cpar, h_employee WHERE q_cpar.id = %s AND q_cpar.diketahui_oleh = h_employee.id", GetSQLValueString($colname_qmr, "int"));
$qmr = mysql_query($query_qmr, $core) or die(mysql_error());
$row_qmr = mysql_fetch_assoc($qmr);
$totalRows_qmr = mysql_num_rows($qmr);

$colname_q_cpar = "-1";
if (isset($_GET['data'])) {
  $colname_q_cpar = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_q_cpar = sprintf("SELECT q_cpar.*, h_department.department FROM q_cpar, h_department WHERE q_cpar.kepada = h_department.id AND q_cpar.id = %s", GetSQLValueString($colname_q_cpar, "int"));
$q_cpar = mysql_query($query_q_cpar, $core) or die(mysql_error());
$row_q_cpar = mysql_fetch_assoc($q_cpar);
$totalRows_q_cpar = mysql_num_rows($q_cpar);

$year = date(Y);
$month = date("Y-m-d");
$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM q_cpar ORDER BY no_urutcpar DESC LIMIT 1"));
$cekQ = $ceknomor[no_urutcpar];
#menghilangkan huruf
$awalQ = substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next = (int)$awalQ+1;

if ($next <10){
// pengecekan nilai increment
$nextString = "00" . $next; // jadinya J005
//
}
else if($nextIncrement >=100){
// pengecekan nilai increment
$nextString = "" . $next; // jadinya J005
//
}
else {
// pengecekan nilai increment
$nextString = "0" . $next; // jadinya J005
//
}
$nextno = sprintf ($nextString);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include('../library/mrom.php');?>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

</head>

<body>
  <?php {
include "../date.php"; include "../dateformat_funct.php"; }?>

<form id="form1" name="form1" >
  <table width="847" border="1" style="border-collapse:collapse">
    <tr>
      <td colspan="3"><img src="../images/bukaka.jpg" alt="" width="120" height="27" />        <label for="no_urutcpar"></label></td>
      <td colspan="2">Nomor : <?php echo $row_q_cpar['no_cpar']; ?></td>
    </tr>
    <tr>
      <td colspan="5" align="center">PERMINTAAN TINDAKAN PERBAIKAN / PENCEGAHAN</td>
    </tr>
    <tr>
      <td colspan="5" align="center">( CORRECTIVE &amp; PREVENTIVE ACTION REQUEST )</td>
    </tr>
    <tr>
      <td width="135">Kepada (Dept.):</td>
      <td width="479"><label for="kepada"><?php echo $row_q_cpar['department']; ?></label></td>
      <td colspan="2">Masalah:</td>
      <td width="265"><?php echo $row_q_cpar['masalah']; ?></td>
    </tr>
    <tr>
      <td>Dari (Penemu):</td>
      <td colspan="4">
        <label for="dari"><?php echo $row_q_cpar['dari']; ?></label></td>
    </tr>
    <tr>
      <td>Tanggal:</td>
      <td colspan="4"><label for="tanggal"><?php echo functddmmmyyyy($row_q_cpar['tanggal']); ?></label></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">1. Uraian Ketidakpuasan / Potensi Ketidaksesuaian</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="7"><label for="uraian_ketidakpuasan"></label>
      <textarea name="uraian_ketidakpuasan" id="uraian_ketidakpuasan"  readonly="readonly" cols="100" rows="10"><?php echo $row_q_cpar['uraian_ketidakpuasan']; ?></textarea></td>
      <td>Dibuat Oleh</td>
    </tr>
    <tr>
      <td><label for="dibuat_oleh"></label>
      <?php echo $row_dibuat_oleh['firstname']; ?>      <?php echo $row_dibuat_oleh['midlename']; ?><?php echo $row_dibuat_oleh['lastname']; ?></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_dibuat"></label>
        <?php echo functddmmmyyyy($row_q_cpar['tanggal_dibuat']); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Disetujui Oleh</td>
    </tr>
    <tr>
      <td><label for="disetujui_oleh"></label>
      <?php echo $row_disetujui_oleh['firstname']; ?><?php echo $row_disetujui_oleh['midlename']; ?> <?php echo $row_disetujui_oleh['lastname']; ?></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_disetujui"></label>
        <?php echo functddmmmyyyy($row_q_cpar['tanggal_disetujui']); ?></td>
    </tr>
    <tr>
      <td colspan="5">2. Analisa Penyebab Ketidakpuasan / Potensi Ketidaksesuaian</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="4"><label for="analisa_penyebab"></label>
      <textarea readonly="readonly" name="analisa_penyebab" id="analisa_penyebab" cols="100" rows="10"><?php echo $row_q_cpar['analisa_penyebab']; ?></textarea></td>
      <td>Dianalisa Oleh</td>
    </tr>
    <tr>
      <td><label for="dianalisa_oleh"></label>
      <?php echo $row_dianalisa_oleh['firstname']; ?> <?php echo $row_dianalisa_oleh['midlename']; ?> <?php echo $row_dianalisa_oleh['lastname']; ?></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_dianalisa"></label>
        <?php echo functddmmmyyyy($row_q_cpar['tanggal_dianalisa']); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">3.Tindakan Perbaikan / Pencegahan</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="6"><label for="tindakan_perbaikan"></label>
      <textarea readonly="readonly" name="tindakan_perbaikan" id="tindakan_perbaikan" cols="100" rows="10"><?php echo $row_q_cpar['tindakan_perbaikan']; ?></textarea></td>
      <td>Penanggung Jawab</td>
    </tr>
    <tr>
      <td><label for="penanggung_jawab"><?php echo $row_penanggung_jawab['firstname']; ?> <?php echo $row_penanggung_jawab['midlename']; ?> <?php echo $row_penanggung_jawab['lastname']; ?></label></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tgl_penanggung_jwb"></label>
        <?php echo functddmmmyyyy($row_q_cpar['tgl_penanggung_jwb']); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Target Selesai</td>
    </tr>
    <tr>
      <td><label for="target_selesai"><?php echo functddmmmyyyy($row_q_cpar['target_selesai']); ?></label></td>
    </tr>
    <tr>
      <td colspan="5">4. Pemeriksaan Tindakan Perbaikan / Pencegahan</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="8"><label for="pemeriksaan_tindakan"></label>
      <textarea readonly="readonly" name="pemeriksaan_tindakan" id="pemeriksaan_tindakan" cols="100" rows="10"><?php echo $row_q_cpar['pemeriksaan_tindakan']; ?></textarea></td>
      <td>Diperiksa Oleh</td>
    </tr>
    <tr>
      <td><label for="diperiksa_oleh"></label>
      <?php echo $row_diperiksa_oleh['firstname']; ?> <?php echo $row_diperiksa_oleh['midlename']; ?> <?php echo $row_diperiksa_oleh['lastname']; ?></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_diperiksa"></label>
        <?php echo functddmmmyyyy($row_q_cpar['tanggal_diperiksa']); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Diketahui Oleh </td>
    </tr>
    <tr>
      <td>(QMR)</td>
    </tr>
    <tr>
      <td><?php echo $row_qmr['firstname']; ?> <?php echo $row_qmr['midlename']; ?><?php echo $row_qmr['lastname']; ?></td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_diketahui"></label>
        <?php echo functddmmmyyyy($row_q_cpar['tanggal_diketahui']); ?></td>
    </tr>
  </table>
</form>


</body>
</html>
<?php
mysql_free_result($h_employee_dari);

mysql_free_result($dibuat_oleh);

mysql_free_result($disetujui_oleh);

mysql_free_result($dianalisa_oleh);

mysql_free_result($penanggung_jawab);

mysql_free_result($diperiksa_oleh);

mysql_free_result($qmr);

mysql_free_result($q_cpar);
?>
