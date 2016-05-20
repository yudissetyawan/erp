<?php require_once('../Connections/core.php'); ?>
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
$query_rsneedurapproval = "SELECT log_pesan.*, inisial_pekerjaan.inisial_pekerjaan FROM log_pesan, inisial_pekerjaan WHERE log_pesan.id_empdept = '$usrid' AND log_pesan.id_msgcat = '3' AND inisial_pekerjaan.id_inisial = log_pesan.id_inisial ORDER BY log_pesan.waktu_notif DESC";
$rsneedurapproval = mysql_query($query_rsneedurapproval, $core) or die(mysql_error());
$row_rsneedurapproval = mysql_fetch_assoc($rsneedurapproval);
$totalRows_rrsneedurapproval = mysql_num_rows($rsneedurapproval);

$rowidcrf = mysql_fetch_row($rsunapprovedcrf);

mysql_select_db($database_core, $core);
$query_rsunapprovedcrf = "SELECT log_pesan.*, inisial_pekerjaan.inisial_pekerjaan FROM log_pesan, inisial_pekerjaan WHERE log_pesan.id_empdept <> '$usrid' AND log_pesan.id_msgcat = '3' AND inisial_pekerjaan.id_inisial = log_pesan.id_inisial ORDER BY log_pesan.waktu_notif DESC";
$rsunapprovedcrf = mysql_query($query_rsunapprovedcrf, $core) or die(mysql_error());
$row_rsunapprovedcrf = mysql_fetch_assoc($rsunapprovedcrf);
$totalRows_rsunapprovedcrf = mysql_num_rows($rsunapprovedcrf);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Need for Approval</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p><font size="2"><blink><b>Need Your Approval</b></blink></font></p>
<table border="0" width="800" height="30">
  <tr class="tabel_header">
    <td width="17">NO.</td>
    <td width="363">JOB TITLE</td>
    <td width="177">ISSUED DATE</td>
    <td width="177">JOB INITIAL</td>
  </tr>
  <?php
  	{ include "../dateformat_funct.php"; }
	do { ?>
    <tr class="tabel_body"><?php $a++; ?>
      <td align="center"><?php echo $a; ?></td>
      <td><a href="<?php echo $row_rsneedurapproval['ntf_goto']; ?>" style="text-decoration:none"><?php echo $row_rsneedurapproval['isi']; ?></a></td>
      <td align="center">
	  	<?php echo functddmmmyyyy($row_rsneedurapproval['waktu_notif']); ?> <?php echo substr($row_rsneedurapproval['waktu_notif'], -8); ?>
      </td>
      <td align="center"><?php echo $row_rsneedurapproval['inisial_pekerjaan']; ?></td>
    </tr>
    <?php } while ($row_rsneedurapproval = mysql_fetch_assoc($rsneedurapproval)); ?>
</table>

<br /><br /><br />
<p><font size="2"><b><i>Need the Approval of Others</i></b></font></p>
<table border="0" width="800">
  <tr class="tabel_header">
    <td width="17">NO.</td>
    <td width="363">JOB TITLE</td>
    <td width="177">ISSUED DATE</td>
    <td width="177">JOB INITIAL</td>
  </tr>
  <?php
	do { ?>
    <tr class="tabel_body"><?php $w++; ?>
      <td align="center"><?php echo $w; ?></td>
      <td><a href="<?php echo $row_rsunapprovedcrf['ntf_goto']; ?>" style="text-decoration:none"><?php echo $row_rsunapprovedcrf['isi']; ?></a></td>
      <td align="center">
	  	<?php echo functddmmmyyyy($row_rsunapprovedcrf['waktu_notif']); ?> <?php echo substr($row_rsunapprovedcrf['waktu_notif'], -8); ?>
      </td>
      <td align="center"><?php echo $row_rsunapprovedcrf['inisial_pekerjaan']; ?></td>
    </tr>
    <?php } while ($row_rsunapprovedcrf = mysql_fetch_assoc($rsunapprovedcrf)); ?>
</table>

</body>
</html>
<?php
	mysql_free_result($rsneedurapproval);
	mysql_free_result($rsunapprovedcrf);
?>