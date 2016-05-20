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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE q_ccomplaint SET status_cpar=%s WHERE id=%s",
                       GetSQLValueString($_POST['status_cpar'], "int"),
                       GetSQLValueString($_POST['id_complaint'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO q_cpar (id_complaint, no_urutcpar, no_cpar, masalah, kepada, dari, tanggal, uraian_ketidakpuasan, analisa_penyebab, tindakan_perbaikan, pemeriksaan_tindakan, dibuat_oleh, disetujui_oleh, dianalisa_oleh, penanggung_jawab, target_selesai, diperiksa_oleh, diketahui_oleh, tanggal_dibuat, tanggal_disetujui, tanggal_dianalisa, tgl_penanggung_jwb, tanggal_diperiksa, tanggal_diketahui) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_complaint'], "int"),
                       GetSQLValueString($_POST['no_urutcpar'], "int"),
                       GetSQLValueString($_POST['no_cpar'], "text"),
                       GetSQLValueString($_POST['masalah'], "text"),
                       GetSQLValueString($_POST['kepada'], "text"),
                       GetSQLValueString($_POST['dari'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal']), "date"),
                       GetSQLValueString($_POST['uraian_ketidakpuasan'], "text"),
                       GetSQLValueString($_POST['analisa_penyebab'], "text"),
                       GetSQLValueString($_POST['tindakan_perbaikan'], "text"),
                       GetSQLValueString($_POST['pemeriksaan_tindakan'], "text"),
                       GetSQLValueString($_POST['dibuat_oleh'], "int"),
                       GetSQLValueString($_POST['disetujui_oleh'], "int"),
                       GetSQLValueString($_POST['dianalisa_oleh'], "int"),
                       GetSQLValueString($_POST['penanggung_jawab'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['target_selesai']), "int"),
                       GetSQLValueString(functyyyymmdd($_POST['diperiksa_oleh']), "int"),
                       GetSQLValueString(functyyyymmdd($_POST['diketahui_oleh']), "int"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal_dibuat']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal_disetujui']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal_dianalisa']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['tgl_penanggung_jwb']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal_diperiksa']), "date"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal_diketahui']), "date"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "cpar_complaint_header.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_q_ccomplaint = "-1";
if (isset($_GET['data'])) {
  $colname_q_ccomplaint = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_q_ccomplaint = sprintf("SELECT id FROM q_ccomplaint WHERE id = %s", GetSQLValueString($colname_q_ccomplaint, "int"));
$q_ccomplaint = mysql_query($query_q_ccomplaint, $core) or die(mysql_error());
$row_q_ccomplaint = mysql_fetch_assoc($q_ccomplaint);
$totalRows_q_ccomplaint = mysql_num_rows($q_ccomplaint);

mysql_select_db($database_core, $core);
$query_h_dept = "SELECT id, department FROM h_department";
$h_dept = mysql_query($query_h_dept, $core) or die(mysql_error());
$row_h_dept = mysql_fetch_assoc($h_dept);
$totalRows_h_dept = mysql_num_rows($h_dept);

mysql_select_db($database_core, $core);
$query_h_employee_dari = "SELECT id, firstname, midlename, lastname FROM h_employee";
$h_employee_dari = mysql_query($query_h_employee_dari, $core) or die(mysql_error());
$row_h_employee_dari = mysql_fetch_assoc($h_employee_dari);
$totalRows_h_employee_dari = mysql_num_rows($h_employee_dari);

mysql_select_db($database_core, $core);
$query_dibuat_oleh = "SELECT id, firstname, midlename, lastname FROM h_employee";
$dibuat_oleh = mysql_query($query_dibuat_oleh, $core) or die(mysql_error());
$row_dibuat_oleh = mysql_fetch_assoc($dibuat_oleh);
$totalRows_dibuat_oleh = mysql_num_rows($dibuat_oleh);

mysql_select_db($database_core, $core);
$query_disetujui_oleh = "SELECT id, firstname, midlename, lastname, `level` FROM h_employee WHERE h_employee.`level` = '0'";
$disetujui_oleh = mysql_query($query_disetujui_oleh, $core) or die(mysql_error());
$row_disetujui_oleh = mysql_fetch_assoc($disetujui_oleh);
$totalRows_disetujui_oleh = mysql_num_rows($disetujui_oleh);

mysql_select_db($database_core, $core);
$query_dianalisa_oleh = "SELECT id, firstname, midlename, lastname FROM h_employee";
$dianalisa_oleh = mysql_query($query_dianalisa_oleh, $core) or die(mysql_error());
$row_dianalisa_oleh = mysql_fetch_assoc($dianalisa_oleh);
$totalRows_dianalisa_oleh = mysql_num_rows($dianalisa_oleh);

mysql_select_db($database_core, $core);
$query_penanggung_jawab = "SELECT id, firstname, midlename, lastname FROM h_employee";
$penanggung_jawab = mysql_query($query_penanggung_jawab, $core) or die(mysql_error());
$row_penanggung_jawab = mysql_fetch_assoc($penanggung_jawab);
$totalRows_penanggung_jawab = mysql_num_rows($penanggung_jawab);

mysql_select_db($database_core, $core);
$query_diperiksa_oleh = "SELECT id, firstname, midlename, lastname FROM h_employee";
$diperiksa_oleh = mysql_query($query_diperiksa_oleh, $core) or die(mysql_error());
$row_diperiksa_oleh = mysql_fetch_assoc($diperiksa_oleh);
$totalRows_diperiksa_oleh = mysql_num_rows($diperiksa_oleh);

mysql_select_db($database_core, $core);
$query_qmr = "SELECT id, firstname, midlename, lastname FROM h_employee";
$qmr = mysql_query($query_qmr, $core) or die(mysql_error());
$row_qmr = mysql_fetch_assoc($qmr);
$totalRows_qmr = mysql_num_rows($qmr);

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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
  <?php {
include "../date.php";} ?>

<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="847" border="1" align="center">
    <tr>
      <td width="102"><img src="../images/bukaka.jpg" alt="" width="120" height="27" /></td>
      <td colspan="2"><input name="id_complaint" type="hidden" id="id_complaint" value="<?php echo $row_q_ccomplaint['id']; ?>" />
        <label for="no_urutcpar"></label>
      <input type="hidden" name="no_urutcpar" id="no_urutcpar" value="<?php echo $next; ?>" /></td>
      <td colspan="3">Nomor. 
        <label for="no_cpar"></label>
      <input type="text" name="no_cpar" id="no_cpar" size="32" value="<?php echo $nextno."/CPAR-BB/".MMRomawi($month)."/".$year; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td colspan="6" align="center">PERMINTAAN TINDAKAN PERBAIKAN / PENCEGAHAN</td>
    </tr>
    <tr>
      <td colspan="6" align="center">( CORRECTIVE &amp; PREVENTIVE ACTION REQUEST )</td>
    </tr>
    <tr>
      <td>Kepada (Dept.):</td>
      <td width="311"><label for="kepada"></label>
        <select name="kepada" id="kepada">
        <option value="">- Department -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_dept['id']?>"><?php echo $row_h_dept['department']?></option>
          <?php
} while ($row_h_dept = mysql_fetch_assoc($h_dept));
  $rows = mysql_num_rows($h_dept);
  if($rows > 0) {
      mysql_data_seek($h_dept, 0);
	  $row_h_dept = mysql_fetch_assoc($h_dept);
  }
?>
      </select></td>
      <td width="132">Masalah</td>
      <td width="1">:</td>
      <td colspan="2"><label for="masalah"></label>
        <label for="masalah"></label>
      <textarea name="masalah" id="masalah" cols="40" rows="3"></textarea></td>
    </tr>
    <tr>
      <td>Dari (Penemu):</td>
      <td>
        <label for="dari"></label>
      <input type="text" name="dari" id="dari" size="32" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Tanggal:</td>
      <td><label for="tanggal"></label>
        <span id="sprytextfield1">
        <input type="text" name="tanggal" id="tanggal1" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6">1. Uraian Ketidakpuasan / Potensi Ketidaksesuaian</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="7"><label for="uraian_ketidakpuasan"></label>
      <textarea name="uraian_ketidakpuasan" id="uraian_ketidakpuasan" cols="100" rows="10"></textarea></td>
      <td width="267">Dibuat Oleh</td>
      <td width="1">&nbsp;</td>
    </tr>
    <tr>
      <td><label for="dibuat_oleh"></label>
        <select name="dibuat_oleh" id="dibuat_oleh">
        <option value="">- Dibuat Oleh -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_dibuat_oleh['id']?>"><?php echo $row_dibuat_oleh['firstname']?></option>
          <?php
} while ($row_dibuat_oleh = mysql_fetch_assoc($dibuat_oleh));
  $rows = mysql_num_rows($dibuat_oleh);
  if($rows > 0) {
      mysql_data_seek($dibuat_oleh, 0);
	  $row_dibuat_oleh = mysql_fetch_assoc($dibuat_oleh);
  }
?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_dibuat"></label>
        <span id="sprytextfield2">
        <input type="text" name="tanggal_dibuat" id="tanggal8" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Disetujui Oleh</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label for="disetujui_oleh"></label>
        <select name="disetujui_oleh" id="disetujui_oleh">
        <option value="">- Disetujui Oleh -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_disetujui_oleh['id']?>"><?php echo $row_disetujui_oleh['firstname']?></option>
          <?php
} while ($row_disetujui_oleh = mysql_fetch_assoc($disetujui_oleh));
  $rows = mysql_num_rows($disetujui_oleh);
  if($rows > 0) {
      mysql_data_seek($disetujui_oleh, 0);
	  $row_disetujui_oleh = mysql_fetch_assoc($disetujui_oleh);
  }
?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_disetujui"></label>
        <span id="sprytextfield3">
        <input type="text" name="tanggal_disetujui" id="tanggal2" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6">2. Analisa Penyebab Ketidakpuasan / Potensi Ketidaksesuaian</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="4"><label for="analisa_penyebab"></label>
      <textarea name="analisa_penyebab" id="analisa_penyebab" cols="100" rows="10"></textarea></td>
      <td colspan="2">Dianalisa Oleh</td>
    </tr>
    <tr>
      <td colspan="2"><label for="dianalisa_oleh"></label>
        <select name="dianalisa_oleh" id="dianalisa_oleh">
        <option value="">- Dianalisa Oleh -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_dianalisa_oleh['id']?>"><?php echo $row_dianalisa_oleh['firstname']?></option>
          <?php
} while ($row_dianalisa_oleh = mysql_fetch_assoc($dianalisa_oleh));
  $rows = mysql_num_rows($dianalisa_oleh);
  if($rows > 0) {
      mysql_data_seek($dianalisa_oleh, 0);
	  $row_dianalisa_oleh = mysql_fetch_assoc($dianalisa_oleh);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">Tgl. 
        <label for="tanggal_dianalisa"></label>
        <span id="sprytextfield4">
        <input type="text" name="tanggal_dianalisa" id="tanggal3" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6">3.Tindakan Perbaikan / Pencegahan</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="6"><label for="tindakan_perbaikan"></label>
      <textarea name="tindakan_perbaikan" id="tindakan_perbaikan" cols="100" rows="10"></textarea></td>
      <td colspan="2">Penanggung Jawab</td>
    </tr>
    <tr>
      <td colspan="2"><label for="penanggung_jawab"></label>
        <select name="penanggung_jawab" id="penanggung_jawab">
        <option value="">- Penanggung Jawab -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_penanggung_jawab['id']?>"><?php echo $row_penanggung_jawab['firstname']?></option>
          <?php
} while ($row_penanggung_jawab = mysql_fetch_assoc($penanggung_jawab));
  $rows = mysql_num_rows($penanggung_jawab);
  if($rows > 0) {
      mysql_data_seek($penanggung_jawab, 0);
	  $row_penanggung_jawab = mysql_fetch_assoc($penanggung_jawab);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">Tgl. 
        <label for="tgl_penanggung_jwb"></label>
        <span id="sprytextfield5">
        <input type="text" name="tgl_penanggung_jwb" id="tanggal4" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Target Selesai</td>
    </tr>
    <tr>
      <td colspan="2"><label for="target_selesai"></label>
        <span id="sprytextfield6">
        <input type="text" name="target_selesai" id="tanggal5" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="6">4. Pemeriksaan Tindakan Perbaikan / Pencegahan</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="8"><label for="pemeriksaan_tindakan"></label>
      <textarea name="pemeriksaan_tindakan" id="pemeriksaan_tindakan" cols="100" rows="10"></textarea></td>
      <td>Diperiksa Oleh</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label for="diperiksa_oleh"></label>
        <select name="diperiksa_oleh" id="diperiksa_oleh">
        <option value="">- Diperiksa Oleh -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_diperiksa_oleh['id']?>"><?php echo $row_diperiksa_oleh['firstname']?></option>
          <?php
} while ($row_diperiksa_oleh = mysql_fetch_assoc($diperiksa_oleh));
  $rows = mysql_num_rows($diperiksa_oleh);
  if($rows > 0) {
      mysql_data_seek($diperiksa_oleh, 0);
	  $row_diperiksa_oleh = mysql_fetch_assoc($diperiksa_oleh);
  }
?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_diperiksa"></label>
        <span id="sprytextfield7">
        <input type="text" name="tanggal_diperiksa" id="tanggal6" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Diketahui Oleh </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>(QMR)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label for="diketahui_oleh"></label>
        <select name="diketahui_oleh" id="diketahui_oleh">
        <option value="">- Diketahui Oleh -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qmr['id']?>"><?php echo $row_qmr['firstname']?></option>
          <?php
} while ($row_qmr = mysql_fetch_assoc($qmr));
  $rows = mysql_num_rows($qmr);
  if($rows > 0) {
      mysql_data_seek($qmr, 0);
	  $row_qmr = mysql_fetch_assoc($qmr);
  }
?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tgl. 
        <label for="tanggal_diketahui"></label>
        <span id="sprytextfield8">
        <input type="text" name="tanggal_diketahui" id="tanggal7" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center"><label for="status_cpar"></label>
      <input type="hidden" name="status_cpar" id="status_cpar" value="1" />        <input type="submit" name="button" id="button" value="Submit" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>
</body>
</html>
<?php
mysql_free_result($q_ccomplaint);

mysql_free_result($q_ccomplaint);

mysql_free_result($h_dept);

mysql_free_result($h_employee_dari);

mysql_free_result($dibuat_oleh);

mysql_free_result($disetujui_oleh);

mysql_free_result($dianalisa_oleh);

mysql_free_result($penanggung_jawab);

mysql_free_result($diperiksa_oleh);

mysql_free_result($qmr);
?>
