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
  $updateSQL = sprintf("UPDATE pr_wpr_summary SET startdate=%s, finishdate=%s, forecast_comp=%s, onschedule=%s, planned_duration=%s, time_elapsed=%s, time_remaining=%s, cmltv_plan=%s, cmltv_actual=%s, variance=%s, incr_actual=%s, est_complete=%s WHERE id_wpr_tanggal=%s",
                       GetSQLValueString($_POST['startdate'], "text"),
                       GetSQLValueString($_POST['finishdate'], "text"),
                       GetSQLValueString($_POST['forecast_comp'], "text"),
                       GetSQLValueString($_POST['onschedule'], "double"),
                       GetSQLValueString($_POST['planned_duration'], "double"),
                       GetSQLValueString($_POST['time_elapsed'], "double"),
                       GetSQLValueString($_POST['time_remaining'], "double"),
                       GetSQLValueString($_POST['cmltv_plan'], "double"),
                       GetSQLValueString($_POST['cmltv_actual'], "double"),
                       GetSQLValueString($_POST['variance'], "double"),
                       GetSQLValueString($_POST['incr_actual'], "double"),
                       GetSQLValueString($_POST['est_complete'], "double"),
                       GetSQLValueString($_POST['id_tanggal'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM pr_header_wpr";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM pr_wpr_summary";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM pr_wpr_tanggal WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM pr_wpr_comulative WHERE id_wpr_tanggal = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php {
include "../date.php";} ?>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="377" height="450" border="1" cellpadding="2">
    <tr>
      <td colspan="3" bgcolor="#F8CBAD" align="center"><h3>SUMMARY</h3></td>
    </tr>
    <tr>
      <td width="140" class="sizewpr">Start Date</td>
      <td width="130"><input name="startdate" type="text" id="tanggal50" value="<?php echo $row_Recordset1['startdate']; ?>" /></td>
      <td width="58"><input name="tanggal" type="text" id="tanggal52" value="<?php echo $row_Recordset3['tanggal']; ?>" /></td>
    </tr>
    <tr>
      <td class="sizewpr">Finish Date</td>
      <td><input name="finishdate" type="text" id="tanggal51" value="<?php echo $row_Recordset1['finishdate']; ?>" /></td>
      <td><input name="id_tanggal" type="text" id="id_tanggal" value="<?php echo $row_Recordset3['id']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
    </tr>
    <tr>
      <td class="sizewpr">Forecast Completion</td>
      <td><input name="forecast_comp" type="text" id="tanggal1" value="<?php echo $row_Recordset1['finishdate']; ?>" /></td>
      <td >&nbsp; </td>
    </tr>
    <tr>
      <td class="sizewpr">On Schedule</td>
      <td><input type="text" name="onschedule" id="onschedule" value="<?php
$tglAwal  = $_POST[forecast_comp];
$tglAkhir = $_POST[finishdate];
print ((strtotime($tglAkhir)-strtotime($tglAwal))/86400);
// akan menghasilkan nilai 53, itu menunjukkan jaraknya adalah 53 hari
?>" /></td>
      <td align="center">days</td>
    </tr>
    <tr>
      <td class="sizewpr">Planned Duration</td>
      <td><input type="text" name="planned_duration" id="planned_duration" value="<?php
$tglAwal  = $_POST[startdate];
$tglAkhir = $_POST[finishdate];
print ((strtotime($tglAkhir)-strtotime($tglAwal))/86400);
// akan menghasilkan nilai 53, itu menunjukkan jaraknya adalah 53 hari
?>" /></td>
      <td align="center">days</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#A9D08E"></td>
    </tr>
    <tr>
      <td class="sizewpr">Time Elapsed</td>
      <td><input type="text" name="time_elapsed" id="time_elapsed" value="<?php
$tglAwal  = $_POST[startdate];
$tglAkhir = $_POST[tanggal];
print ((strtotime($tglAkhir)-strtotime($tglAwal))/86400);
// akan menghasilkan nilai 53, itu menunjukkan jaraknya adalah 53 hari
?>" /></td>
      <td align="center">days</td>
    </tr>
    <tr>
      <td class="sizewpr">Time Remaining</td>
      <td><input type="text" name="time_remaining" id="time_remaining" value="<?php
$tglAwal  = $_POST[finishdate];
$tglAkhir = $_POST[tanggal];
print ((strtotime($tglAwal)-strtotime($tglAkhir))/86400);
// akan menghasilkan nilai 53, itu menunjukkan jaraknya adalah 53 hari
?>" /></td>
      <td align="center">days</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
    </tr>
    <tr>
      <td class="sizewpr">Cm/tv Plan Progress</td>
      <td><input name="cmltv_plan" type="text" id="cmltv_plan" value="<?php echo $row_Recordset4['tot_plan']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="sizewpr">Cm/tv Actual Progress</td>
      <td><input name="cmltv_actual" type="text" id="cmltv_actual" value="<?php echo $row_Recordset4['tot_act']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#A9D08E">&nbsp;</td>
    </tr>
    <tr>
      <td class="sizewpr">Variance </td>
      <td><input name="variance" type="text" id="variance" value="<?php echo $row_Recordset4['tot_variance']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="sizewpr">Incr. Actual</td>
      <td><input name="incr_actual" type="text" id="incr_actual" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="sizewpr">Est. Complete</td>
      <td><input name="est_complete" type="text" id="est_complete" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#F8CBAD" align="center"><input type="submit" name="submit" id="submit" value="Refresh" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
