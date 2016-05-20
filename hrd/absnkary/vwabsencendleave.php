<?php require_once('../../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$usrid = $_SESSION['empID'];
mysql_select_db($database_core, $core);
if (isset($_GET['cmbmo']) && $_GET['cmbye']) {
	$cmbmo = $_GET['cmbmo'];
	$cmbye = $_GET['cmbye'];
	$bln = $cmbmo; $thn = $cmbye;
	$query_rsabsen = "SELECT h_absen.* FROM h_employee, h_absen, h_absen_header WHERE h_employee.id = h_absen.employee AND h_employee.id = '$usrid' AND h_absen_header.id = h_absen.idheader AND bulan = '$cmbmo' AND tahun = '$cmbye'";
} else {
	$mo = date("F"); // 'March'
	$ye = date("Y");
	$bln = $mo; $thn = $ye;
	$query_rsabsen = "SELECT h_absen.* FROM h_employee, h_absen, h_absen_header WHERE h_employee.id = h_absen.employee AND h_employee.id = '$usrid' AND h_absen_header.id = h_absen.idheader AND bulan = '$mo' AND tahun = '$ye'";
}
$rsabsen = mysql_query($query_rsabsen, $core) or die(mysql_error());
$row_rsabsen = mysql_fetch_assoc($rsabsen);
$totalRows_rsabsen = mysql_num_rows($rsabsen);

if ($totalRows_rsabsen == 0) {
	$psn = "<i>Maaf, data absen Anda untuk periode ini belum tersedia</i>";
} else {
	$psn = '';
}

mysql_select_db($database_core, $core);
$query_rsket = "SELECT h_absen_inisial.* FROM h_absen_inisial";
$rsket = mysql_query($query_rsket, $core) or die(mysql_error());
$row_rsket = mysql_fetch_assoc($rsket);
$totalRows_rsket = mysql_num_rows($rsket);

mysql_select_db($database_core, $core);
$query_rsemp = "SELECT h_employee.id AS id_emp, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.nik, h_employee.department, h_employee.jabatan, h_employee.date_of_start FROM h_employee WHERE h_employee.id = '$usrid'";
$rsemp = mysql_query($query_rsemp, $core) or die(mysql_error());
$row_rsemp = mysql_fetch_assoc($rsemp);
$totalRows_rsemp = mysql_num_rows($rsemp);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Absence and Leave</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />

</head>

<body class="General">
<table width="375" border="0">
  <tr>
    <td width="90">Nama</td>
    <td width="20">:</td>
    <td><?php echo $row_rsemp['firstname']; ?> <?php echo $row_rsemp['midlename']; ?> <?php echo $row_rsemp['lastname']; ?></td>
  </tr>
  <tr>
    <td>NIK</td>
    <td>:</td>
    <td><?php echo $row_rsemp['nik']; ?></td>
  </tr>
  <tr>
    <td>Bagian</td>
    <td>:</td>
    <td><?php echo $row_rsemp['department']; ?></td>
  </tr>
  <tr>
    <td>Posisi</td>
    <td>:</td>
    <td><?php echo $row_rsemp['jabatan']; ?></td>
  </tr>
  <tr>
    <td>Status</td>
    <td>:</td>
    <td><?php echo $row_rsabsen['status']; ?></td>
  </tr>
</table>

<br />
<form method="get" action="" name="vwabsencendleave.php">
	Pilih Periode &nbsp;&nbsp; : &nbsp;&nbsp; Bulan
	<select name="cmbmo" class="General">
		<option value="January">January</option>
		<option value="February">February</option>
		<option value="March">March</option>
		<option value="April">April</option>
		<option value="May">May</option>
		<option value="June">June</option>
		<option value="July">July</option>
 		<option value="August">August</option>
		<option value="September">September</option>
		<option value="October">October</option>
		<option value="November">November</option>
		<option value="December">December</option>
    </select>
    Tahun
	<select name="cmbye" class="General">
        <?php for ($i = 2010; $i <= 2018; $i++) {
            echo '<option value='.$i.'>'.$i.'</option>';
        } ?>
    </select>
    <input type="submit" value="Go" style="cursor:pointer" class="General" />
</form>

	<br />
	<table width="750" border="0" class="General">
		<tr>
		<td colspan="31" align="center">ABSENSI KEHADIRAN</td>
	  </tr>
	  <tr>
		<td colspan="31" align="center"><b><?php echo "$bln $thn"; ?></b></td>
	  </tr>
	</table>
	
    <br />
	<table width="750" border="1">
	  <tr class="tabel_header">
		<td colspan="31">Tanggal</td>
	  </tr>
	  <tr class="tabel_header">
		<td class="tabel_header">1</td>
		<td class="tabel_header">2</td>
		<td class="tabel_header">3</td>
		<td class="tabel_header">4</td>
		<td class="tabel_header">5</td>
		<td class="tabel_header">6</td>
		<td class="tabel_header">7</td>
		<td class="tabel_header">8</td>
		<td class="tabel_header">9</td>
		<td class="tabel_header">10</td>
		<td class="tabel_header">11</td>
		<td class="tabel_header">12</td>
		<td class="tabel_header">13</td>
		<td class="tabel_header">14</td>
		<td class="tabel_header">15</td>
		<td class="tabel_header">16</td>
		<td class="tabel_header">17</td>
		<td class="tabel_header">18</td>
		<td class="tabel_header">19</td>
		<td class="tabel_header">20</td>
		<td class="tabel_header">21</td>
		<td class="tabel_header">22</td>
		<td class="tabel_header">23</td>
		<td class="tabel_header">24</td>
		<td class="tabel_header">25</td>
		<td class="tabel_header">26</td>
		<td class="tabel_header">27</td>
		<td class="tabel_header">28</td>
		<td class="tabel_header">29</td>
		<td class="tabel_header">30</td>
		<td class="tabel_header">31</td>
	  </tr>
	
		<tr>
		  <td align="center"><?php echo $row_rsabsen[h1]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h2]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h3]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h4]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h5]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h6]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h7]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h8]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h9]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h10]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h11]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h12]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h13]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h14]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h15]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h16]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h17]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h18]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h19]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h20]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h21]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h22]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h23]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h24]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h25]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h26]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h27]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h28]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h29]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h30]; ?></td>
		  <td align="center"><?php echo $row_rsabsen[h31]; ?></td>
		</tr>
	
	</table>
	
    <?php echo $psn; ?>
	<br><br>
	<?php
		$tdkmsk = $row_rsabsen['h1'];
		$tdkmsk2 = $row_rsabsen['h2'];
		$tdkmsk3 = $row_rsabsen['h3'];
		$tdkmsk4 = $row_rsabsen['h4'];
		$tdkmsk5 = $row_rsabsen['h5'];
		$tdkmsk6 = $row_rsabsen['h6'];
		$tdkmsk7 = $row_rsabsen['h7'];
		$tdkmsk8 = $row_rsabsen['h8'];
		$tdkmsk9 = $row_rsabsen['h9'];
		$tdkmsk10 = $row_rsabsen['h10'];
		$tdkmsk11 = $row_rsabsen['h11'];
		$tdkmsk12 = $row_rsabsen['h12'];
		$tdkmsk13 = $row_rsabsen['h13'];
		$tdkmsk14 = $row_rsabsen['h14'];
		$tdkmsk15 = $row_rsabsen['h15'];
		$tdkmsk16 = $row_rsabsen['h16'];
		$tdkmsk17 = $row_rsabsen['h17'];
		$tdkmsk18 = $row_rsabsen['h18'];
		$tdkmsk19 = $row_rsabsen['h19'];
		$tdkmsk20 = $row_rsabsen['h20'];
		$tdkmsk21 = $row_rsabsen['h21'];
		$tdkmsk22 = $row_rsabsen['h22'];
		$tdkmsk23 = $row_rsabsen['h23'];
		$tdkmsk24 = $row_rsabsen['h24'];
		$tdkmsk25 = $row_rsabsen['h25'];
		$tdkmsk26 = $row_rsabsen['h26'];
		$tdkmsk27 = $row_rsabsen['h27'];
		$tdkmsk28 = $row_rsabsen['h28'];
		$tdkmsk29 = $row_rsabsen['h29'];
		$tdkmsk30 = $row_rsabsen['h30'];
		$tdkmsk31 = $row_rsabsen['h31'];	
		$absensi = "$tdkmsk $tdkmsk2 $tdkmsk3 $tdkmsk4 $tdkmsk5 $tdkmsk6 $tdkmsk7 $tdkmsk8 $tdkmsk9 $tdkmsk10 $tdkmsk11 $tdkmsk12 $tdkmsk13 $tdkmsk14 $tdkmsk15 $tdkmsk16 $tdkmsk17 $tdkmsk18 $tdkmsk19 $tdkmsk20 $tdkmsk21 $tdkmsk22 $tdkmsk23 $tdkmsk24 $tdkmsk25 $tdkmsk26 $tdkmsk27 $tdkmsk28 $tdkmsk29 $tdkmsk30 $tdkmsk31";	
		$telat = $tdkmsk + $tdkmsk2 + $tdkmsk3 + $tdkmsk4 + $tdkmsk5 + $tdkmsk6 + $tdkmsk7 + $tdkmsk8 + $tdkmsk9 + $tdkmsk10 + $tdkmsk11 + $tdkmsk12 + $tdkmsk13 + $tdkmsk14 + $tdkmsk15 + $tdkmsk16 + $tdkmsk17 + $tdkmsk18 + $tdkmsk19 + $tdkmsk20 + $tdkmsk21 + $tdkmsk22 + $tdkmsk23 + $tdkmsk24 + $tdkmsk25 + $tdkmsk26 + $tdkmsk27 + $tdkmsk28 + $tdkmsk29 + $tdkmsk30 + $tdkmsk31;
	?>
	
	<table width="600" border="0">
	  <tr>
		<td width="90">Total Sakit</td>
		<td width="20">:</td>
		<td width="200"><?php echo substr_count($absensi, "skt"); ?> hari</td>
		<td colspan="3"><?php /* */
			{ include "../../dateformat_funct.php"; }
			$noyear = substr($row_rsemp['date_of_start'], 4);
			$dateofstart = ltrim(substr($row_rsemp['date_of_start'], 5, 2), '0');
			$monow = ltrim (date("m"), '0');
			if ($dateofstart <= $monow) {
				$yenow = date("Y");
				$ye2 = date("Y") + 1;
			} else {
				$yenow = date("Y") - 1;
				$ye2 = date("Y");		
			} //echo $dateofstart2;
			
			$dateofstart2 = "$yenow$noyear";
			list($month1, $date1, $year1) = functddmmyyyy($row_rsemp['date_of_start']);
			list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
			$jd1 = GregorianToJD($month1, $date1, $year1);
			$jd2 = GregorianToJD($month2, $date2, $year2);
			$selisih = $jd2 - $jd1;		//echo "$jd2 - $jd1 = $selisih";
			?>
            Dari <?php echo functddmmmyyyy($dateofstart2); ?> , hingga <?php echo functddmmmyyyy("$ye2$noyear") ?></td>
	  </tr>
	  <tr>
		<td>Total Izin</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "iz"); ?> hari</td>
		<td width="80">Total Cuti</td>
		<td width="20">:</td>
		<td><?php if ($selisih < 360) {
				echo "0";
			} else {
				$totalct = substr_count($absensi, "ct"); echo $totalct;
			} ?> hari</td>
	  </tr>
	  <tr>
		<td>Total Alpa</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "a"); ?> hari</td>
		<td>Sisa Cuti</td>
		<td>:</td>
		<td><?php if ($selisih < 360) {
				echo "0";
			} else {
				$sisact = 12 - $totalct; echo $sisact;
			} ?> hari</td>
	  </tr>
	  <tr>
		<td>Total IP</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "ip"); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Total IK</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "ik"); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Total IT</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "it"); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Total TTM</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "ttm"); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Total TTK</td>
		<td>:</td>
		<td><?php echo substr_count($absensi, "ttk"); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Total Terlambat</td>
		<td>:</td>
		<td><?php echo $telat; ?> menit</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<br><br>
	<table width="264" border="0">
	  <tr class="tabel_header">
		<td width="18">No</td>
		<td width="60">Inisial</td>
		<td width="137">Keterangan</td>
	  </tr>
	  <?php do { ?>
		<tr class="tabel_body"><?php $b=$b+1 ?>
		  <td align="center"><?php echo $b; ?></td>
		  <td align="center"><?php echo $row_rsket['inisial']; ?></td>
		  <td><?php echo $row_rsket['jenis']; ?></td>
		</tr>
		<?php } while ($row_rsket = mysql_fetch_assoc($rsket)); ?>
	</table>

<?php
if (($_SESSION['userlvl'] == 'hrd') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
		echo '<p align="center"><a href="vwabsence_rev.php" title="Revision of Form Absence" target="_blank">View Absence</a></p>';
	}
?>

</body>
</html>
<?php
	mysql_free_result($rsabsen);
	mysql_free_result($rsket);
	mysql_free_result($rsemp);
?>