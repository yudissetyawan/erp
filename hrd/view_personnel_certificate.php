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

$colname_h_training = "-1";
if (isset($_GET['data'])) {
  $colname_h_training = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_training = sprintf("SELECT h_training.*, h_kategori_training.nama_kategori FROM h_training, h_kategori_training WHERE id_h_employee = %s AND h_training.kategori = h_kategori_training.id_kategori", GetSQLValueString($colname_h_training, "int"));
$h_training = mysql_query($query_h_training, $core) or die(mysql_error());
$row_h_training = mysql_fetch_assoc($h_training);
$totalRows_h_training = mysql_num_rows($h_training);

$colname_h_employee = "-1";
if (isset($_GET['data'])) {
  $colname_h_employee = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_h_employee = sprintf("SELECT * FROM h_employee WHERE id = %s", GetSQLValueString($colname_h_employee, "int"));
$h_employee = mysql_query($query_h_employee, $core) or die(mysql_error());
$row_h_employee = mysql_fetch_assoc($h_employee);
$totalRows_h_employee = mysql_num_rows($h_employee);

$colname_rshmcu = "-1";
if (isset($_GET['data'])) {
  $colname_rshmcu = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rshmcu = sprintf("SELECT * FROM h_mcu WHERE id_h_employee = %s", GetSQLValueString($colname_rshmcu, "int"));
$rshmcu = mysql_query($query_rshmcu, $core) or die(mysql_error());
$row_rshmcu = mysql_fetch_assoc($rshmcu);
$totalRows_rshmcu = mysql_num_rows($rshmcu);

$colname_rshsim = "-1";
if (isset($_GET['data'])) {
  $colname_rshsim = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rshsim = sprintf("SELECT h_sim.* FROM h_sim WHERE id_h_employee = %s", GetSQLValueString($colname_rshsim, "int"));
$rshsim = mysql_query($query_rshsim, $core) or die(mysql_error());
$row_rshsim = mysql_fetch_assoc($rshsim);
$totalRows_rshsim = mysql_num_rows($rshsim);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detail Personnel Certification</title>
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />
<link href="../../css/table.css" rel="stylesheet" type="text/css" />
<link href="../../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />

</head>

<body class="General">
<?php { require_once "../dateformat_funct.php"; } ?>
<b>
<table width="400">
    <tr>
        <td width="130">Name of Employee</td>
        <td width="10">:</td>
        <td width="260"><?php echo $row_h_employee['firstname']; ?> <?php echo $row_h_employee['midlename']; ?> <?php echo $row_h_employee['lastname']; ?></td>
	</tr>
    <tr>
        <td>N I K</td>
        <td>:</td>
        <td><?php echo $row_h_employee['nik']; ?></td>
	</tr>
    <tr>
        <td>Department</td>
        <td>:</td>
        <td><?php echo $row_h_employee['department']; ?></td>
    </tr>
</table>
</b>


<table width="1120"> <!-- border="1" style="border-collapse:collapse;" -->
  <tr class="tabel_header" height="30">
    <td colspan="10">T R A I N I N G</td>
  </tr>
  <tr class="tabel_header" height="30">
    <td width="20">No.</td>
    <td width="110">Category</td>
    <td width="170">Type of Training</td>
    <td width="150">Certificate No.</td>
    <td>Provider</td>
    <td width="125">Date</td>
    <td width="80">Expired<br />Date</td>
    <td width="125">Remark</td>
    <td width="60"><i>Status</i></td>
    <td width="50"><i>Day<br />Remaining</i></td>
  </tr> 
  <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $a=$a+1; echo $a; ?></td>
      <td align="center"><?php echo $row_h_training[nama_kategori]; ?></td>
      <td><?php echo $row_h_training['jenis_training']; ?></td>
      <td align="center"><?php echo $row_h_training['no_certificate']; ?></td>
      <td><?php echo $row_h_training['provider']; ?></td>
      <td align="center"><?php echo $row_h_training['date']; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_h_training['exp_date']); ?></td>
      <td><?php echo $row_h_training['remark']; ?></td>

      <?php
		if (($row_h_training['exp_date'] == "") || ($row_h_training['exp_date'] == "-") || ($row_h_training['exp_date'] == "--")) {
			?> <td>&nbsp;</td> <?php
		} else {
			if (($row_h_training['exp_date']) > date("Y-m-d")) {
				echo '<td align="center" bgcolor="#35C7F3"><b>Valid<b></td>';
			} else {
				echo '<td align="center" bgcolor="#F00"><b>Expired</b></font></td>';
			}
		}
	  ?>
      
      <td align="center">
      <?php
		if (($row_h_training['exp_date'] == "") || ($row_h_training['exp_date'] == "-") || ($row_h_training['exp_date'] == "--")) {
			?> &nbsp; <?php
		} else {
			list($month1, $date1, $year1) = functddmmyyyy($row_h_training['exp_date']);
			list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
			$jd1 = GregorianToJD($month1, $date1, $year1);
			$jd2 = GregorianToJD($month2, $date2, $year2);
			$selisih = $jd1 - $jd2;
			
			if (($row_h_training['exp_date']) > date("Y-m-d")) {
				echo '<font size="1">'.$selisih.' days</font>';
			} else {
				echo '<font size="1" color="#FF0000">'.$selisih.' days</font>';
			}
		}
	  ?>
      </td>

    </tr>
    <?php } while ($row_h_training = mysql_fetch_assoc($h_training)); ?>   
</table>


<br /><br />
<table width="500">
  <tr class="tabel_header" height="30">
    <td colspan="9">MEDICAL CHECK UP  ( M C U )</td>
  </tr>
  <tr class="tabel_header" height="30">
    <td width="20">No.</td>
    <td width="90">Date</td>
    <td width="90">Expired Date</td>
    <td width="60"><i>Status</i></td>
    <td width="50"><i>Day<br />Remaining</i></td>
  </tr> 
  <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $b = $b + 1; echo $b; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rshmcu['date']); ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rshmcu['exp_date']); ?></td>
      
      <?php
		if (($row_rshmcu['exp_date'] == "") || ($row_rshmcu['exp_date'] == "-")) {
			?> <td>&nbsp;</td> <?php
		} else {
			if (($row_rshmcu['exp_date']) > date("Y-m-d")) {
				echo '<td align="center" bgcolor="#35C7F3"><b>Valid<b></td>';
			} else {
				echo '<td align="center" bgcolor="#F00"><b>Expired</b></font></td>';
			}
		}
	  ?>
      
      <td align="center">
      <?php
		if (($row_rshmcu['exp_date'] == "") || ($row_rshmcu['exp_date'] == "-")) {
			?> &nbsp; <?php
		} else {
			list($month1, $date1, $year1) = functddmmyyyy($row_rshmcu['exp_date']);
			list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
			$jd1 = GregorianToJD($month1, $date1, $year1);
			$jd2 = GregorianToJD($month2, $date2, $year2);
			$selisih = $jd1 - $jd2;
			
			if (($row_rshmcu['exp_date']) > date("Y-m-d")) {
				echo '<font size="1">'.$selisih.' days</font>';
			} else {
				echo '<font size="1" color="#FF0000">'.$selisih.' days</font>';
			}
		}
	  ?>
      </td>
      
    </tr>
    <?php } while ($row_rshmcu = mysql_fetch_assoc($rshmcu)); ?>  
</table>


<br /><br />
<table width="350">
  <tr class="tabel_header" height="30">
    <td colspan="10">DRIVING LICENSE  ( S I M )</td>
  </tr>
  <tr class="tabel_header" height="30">
    <td width="20">No.</td>
    <td>Type</td>
    <td width="100">Expired<br />Date</td>
    <td width="90"><i>Status</i></td>
    <td width="60"><i>Day<br />Remaining</i></td>
  </tr> 
  <?php do { ?>
    <tr class="tabel_body">
      <td align="center"><?php $c = $c + 1; echo $c; ?></td>
      <td align="center"><?php echo $row_rshsim['sim_gol']; ?></td>
      <td align="center"><?php echo functddmmmyyyy($row_rshsim['masaberlaku']); ?></td>

      <?php
		if (($row_rshsim['masaberlaku'] == "") || ($row_rshsim['masaberlaku'] == "-")) {
			?> <td>&nbsp;</td> <?php
		} else {
			if (($row_rshsim['masaberlaku']) > date("Y-m-d")) {
				echo '<td align="center" bgcolor="#35C7F3"><b>Valid<b></td>';
			} else {
				echo '<td align="center" bgcolor="#F00"><b>Expired</b></font></td>';
			}
		}
	  ?>
      
      <td align="center">
      <?php
		if (($row_rshsim['masaberlaku'] == "") || ($row_rshsim['masaberlaku'] == "-")) {
			?> &nbsp; <?php
		} else {
			list($month1, $date1, $year1) = functddmmyyyy($row_rshsim['masaberlaku']);
			list($month2, $date2, $year2) = functddmmyyyy2(date("Y-m-d"));
			$jd1 = GregorianToJD($month1, $date1, $year1);
			$jd2 = GregorianToJD($month2, $date2, $year2);
			$selisih = $jd1 - $jd2;
			
			if (($row_rshsim['masaberlaku']) > date("Y-m-d")) {
				echo '<font size="1">'.$selisih.' days</font>';
			} else {
				echo '<font size="1" color="#FF0000">'.$selisih.' days</font>';
			}
		}
	  ?>
      </td>

    </tr>
    <?php } while ($row_rshmcu = mysql_fetch_assoc($rshmcu)); ?>  
</table>

<br /><br />
<p><a href="view_personnel_certificate_header.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-arrow-1-w"></span>Back</a></p>

</body>
</html>
<?php
	mysql_free_result($h_training);
	mysql_free_result($h_employee);
	mysql_free_result($rshmcu);
	mysql_free_result($rshsim);
?>