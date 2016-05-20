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
$query_h_employee = "SELECT * FROM h_employee ORDER BY firstname ASC";
$h_employee = mysql_query($query_h_employee, $core) or die(mysql_error());
$row_h_employee = mysql_fetch_assoc($h_employee);
$totalRows_h_employee = mysql_num_rows($h_employee);

$colname_h_employee_apprv = "-1";
if (isset($_GET['0'])) {
  $colname_h_employee_apprv = $_GET['0'];
}
mysql_select_db($database_core, $core);
$query_h_employee_apprv = sprintf("SELECT * FROM h_employee WHERE `level` = %s", GetSQLValueString($colname_h_employee_apprv, "text"));
$h_employee_apprv = mysql_query($query_h_employee_apprv, $core) or die(mysql_error());
$row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv);
$totalRows_h_employee_apprv = mysql_num_rows($h_employee_apprv);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO h_suratizin (id_employee, tanggal, keperluan, jenis_izin, disetujui_oleh) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_employee'], "int"),
                       GetSQLValueString(functyyyymmdd($_POST['tanggal']), "date"),
                       GetSQLValueString($_POST['keperluan'], "text"),
                       GetSQLValueString($_POST['jenis_izin'], "int"),
                       GetSQLValueString($_POST['approved_by'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$chosenapprover = $_POST['approved_by'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$nama = $_POST['nama'];
	$dept = $_POST['dept'];
	$izin = $_POST['jenis_izin'];
	$keperluan = $_POST['keperluan'];
	//$issued_date = $_POST['issueddate'];
	$approverfname = $row_rsapprovedby['fname'];
	$approvermname = $row_rsapprovedby['mname'];
	$approverlname = $row_rsapprovedby['lname'];
	$isipsn = "$nama meminta izin untuk $keperluan dan menunggu Approval dari $approverfname $approvermname $approverlname";
	
	do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString('63', "int"),
						   GetSQLValueString($izin, "text"),
						   GetSQLValueString($row_rsemployeedept['empID'], "int"),
						   GetSQLValueString($isipsn, "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	}
	while ($row_rsemployeedept = mysql_fetch_assoc($rsemployeedept));
	
	//NOTIF APPROVAL (SAVE IN TBL LOG_PESAN)
	$ceknomor = mysql_fetch_array(mysql_query("SELECT id FROM a_crf ORDER BY id DESC LIMIT 1"));
	$idcrf = $ceknomor['id'];
	
	$isipsn2 = "$nama meminta izin untuk $keperluan dan menunggu Approval dari $approverfname $approvermname $approverlname";
	$goto = "crf_approval.php?data=$idcrf";
	
	$insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
						   GetSQLValueString('52', "int"),
						   GetSQLValueString($idcrf, "text"),
						   GetSQLValueString($chosenapprover, "int"),
						   GetSQLValueString($isipsn2, "text"),
						   GetSQLValueString($goto, "text"),
						   GetSQLValueString('3', "text"));
	
	mysql_select_db($database_core, $core);
	$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
		
	echo "<script>
			alert(\"CRF No : $no_crf has been issued and waiting for approval by $approverfname $approvermname $approverlname\");
			document.location=\"form_project.php\";
			parent.window.location.reload(true);
		</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
* { font:Tahoma, Geneva, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

</head>

<body>
<h3>Form Izin</h3>
<?php {include "../date.php";} ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="985" class="General">
    <tr>
      <td width="127">Nama </td>
      <td width="18">:</td>
      <td width="351"><select name="namaemployee" id="namaemployee">
        <option value="">-- Nama Employee --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_h_employee['id']?>"><?php echo $row_h_employee['firstname']?></option>
        <?php
} while ($row_h_employee = mysql_fetch_assoc($h_employee));
  $rows = mysql_num_rows($h_employee);
  if($rows > 0) {
      mysql_data_seek($h_employee, 0);
	  $row_h_employee = mysql_fetch_assoc($h_employee);
  }
?>
      </select></td>
      <td width="58">Disetujui Oleh</td>
      <td width="12">:</td>
      <td width="391"><label for="approved_by"></label>
        <label for="approved_by"></label>
        <select name="approved_by" id="approved_by">
          <option value="">-- Disetujui Oleh --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_h_employee_apprv['id']?>"><?php echo $row_h_employee_apprv['firstname']?></option>
          <?php
} while ($row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv));
  $rows = mysql_num_rows($h_employee_apprv);
  if($rows > 0) {
      mysql_data_seek($h_employee_apprv, 0);
	  $row_h_employee_apprv = mysql_fetch_assoc($h_employee_apprv);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td>Hari</td>
      <td>:</td>
      <td><select name="hari" id="hari">
        <option value="SENIN">SENIN</option>
        <option value="SELASA">SELASA</option>
        <option value="RABU">RABU</option>
        <option value="KAMIS">KAMIS</option>
        <option value="JUM'AT">JUM'AT</option>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td><select name="tanggal" id="tanggal">
        <option value="h01">01</option>
        <option value="h02">02</option>
        <option value="h03">03</option>
        <option value="h04">04</option>
        <option value="h05">05</option>
        <option value="h06">06</option>
        <option value="h07">07</option>
        <option value="h08">08</option>
        <option value="h09">09</option>
        <option value="h10">10</option>
        <option value="h11">11</option>
        <option value="h12">12</option>
        <option value="h13">13</option>
        <option value="h14">14</option>
        <option value="h15">15</option>
        <option value="h16">16</option>
        <option value="h17">17</option>
        <option value="h18">18</option>
        <option value="h19">19</option>
        <option value="h20">20</option>
        <option value="h21">21</option>
        <option value="h22">22</option>
        <option value="h23">23</option>
        <option value="h24">24</option>
        <option value="h25">25</option>
        <option value="h26">26</option>
        <option value="h27">27</option>
        <option value="h28">28</option>
        <option value="h29">29</option>
        <option value="h30">30</option>
        <option value="h31">31</option>
      </select> <select name="bulan" id="bulan">
        <option value="1">JANUARI</option>
        <option value="2">FEBRUARY</option>
        <option value="3">MARET</option>
        <option value="4">APRIL</option>
        <option value="5">MEI</option>
        <option value="6">JUNI</option>
        <option value="7">JULI</option>
        <option value="8">AGUSTUS</option>
        <option value="9">SEPTEMBER</option>
        <option value="10">OKTOBER</option>
        <option value="11">NOVEMBER</option>
        <option value="12">DESEMBER</option>
      </select>
      <select name="tahun" id="tahun">
        <option value="2014">2014</option>
        <option value="2015">2015</option>
      </select></td>
      <td>Pukul </td>
      <td>:</td>
      <td><label for="pukul"></label>
        <?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i:s");
			$sekarang = $jam;
			 ?>

      <input type="text" name="pukul" id="pukul" value="<?php echo $sekarang; ?>" /> 
      s/d 
      <label for="pukul_akhir"></label>
      <input type="text" name="pukul_akhir" id="pukul_akhir" /></td>
    </tr>
    <tr>
      <td>Untuk Keperluan</td>
      <td>:</td>
      <td><label for="keperluan"></label>
      <textarea name="keperluan" id="keperluan" cols="45" rows="5"></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><h3>
        <label>
          <input type="radio" name="jenis_izin" value="1" id="jenis_izin_0" />
          Izin Terlambat</label>
        <br />
        <label>
          <input type="radio" name="jenis_izin" value="2" id="jenis_izin_1" />
          Izin Pulang Awal</label>
        <br />
        <label>
          <input type="radio" name="jenis_izin" value="3" id="jenis_izin_2" />
          Izin Meninggalkan Pekerjaan</label>
        <br />
      </h3></td>
    </tr>
    
    <tr>
      <td colspan="6"  align="center"><label>
        <input type="submit" name="submit" id="submit" value="Submit" />
      </label></td>
    </tr>
  </table>
  <input name="id_employee" type="hidden" id="id_employee" value="<?php echo $row_h_employee['id']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($h_employee);

mysql_free_result($h_employee_apprv);
?>
