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
  $updateSQL = sprintf("UPDATE contact_us SET respond=%s, timeofrespond=%s, status_respond=%s WHERE id=%s",
                       GetSQLValueString($_POST['respond'], "text"),
                       GetSQLValueString($_POST['timeofrespond'], "text"),
                       GetSQLValueString($_POST['status_respond'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "contactus_viewheader.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rscontact_us = "-1";
if (isset($_GET['data'])) {
  $colname_rscontact_us = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rscontact_us = sprintf("SELECT contact_us.*, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM contact_us, h_employee WHERE contact_us.id = %s AND h_employee.id = contact_us.name", GetSQLValueString($colname_rscontact_us, "int"));
$rscontact_us = mysql_query($query_rscontact_us, $core) or die(mysql_error());
$row_rscontact_us = mysql_fetch_assoc($rscontact_us);
$totalRows_rscontact_us = mysql_num_rows($rscontact_us);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h3 { font-size:14px; font-weight:bold; }
	p {font-size:12px; font-weight:bold;}
	input { padding: 1px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <a href="contactus_viewheader.php"><input type="submit" name="Back" id="Back" value="Back" /></a>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1" id="form1">
  <table width="846" border="0">
<tr class="tabel_header">
<td colspan="6"><p>This Comment is about
<?php
if($row_rscontact_us['type']=='1'){
echo "Information";
}
elseif ($row_rscontact_us['type']=='2'){
echo "Suggestion";
}
elseif ($row_rscontact_us['type']=='3'){
echo "Complaints";
} 
?> for Bi-SmartS</p></td>
</tr>
<tr>
<td width="115">Name </td>
<td width="5">:</td>
<td width="323"><?php echo $row_rscontact_us['nik']; ?>- <?php echo $row_rscontact_us['firstname']; ?> <?php echo $row_rscontact_us['midlename']; ?> <?php echo $row_rscontact_us['lastname']; ?></td>
<td width="72">Comment </td>
<td width="5">:</td>
<td width="300">
<label for="Comment"></label>
<textarea name="Comment" readonly="readonly" style="border:none" id="Comment" cols="45" rows="5"><?php echo $row_rscontact_us['comment']?></textarea></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><?php echo $row_rscontact_us['email']; ?></td>
<td>Respond </td>
<td>:</td>
<td>
<label for="respond"></label>
<textarea name="respond" id="respond" cols="45" rows="5"><?php echo $row_rscontact_us['respond']; ?></textarea></td>
</tr>
<tr valign="top">
<td>Phone Number </td>
<td>:</td>
<td><?php echo $row_rscontact_us['ph']; ?></td>
<td colspan="3" rowspan="2" valign="middle"><b>
<?php
date_default_timezone_set('Asia/Balikpapan');
//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$today = date('l, F j, Y');
$jam = date("H:i");
$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
echo $sekarang; ?>
<p><input name="timeofrespond" type="hidden" id="timeofrespond" value="<?php echo $sekarang; ?>" /></p>
</b></td>
</tr>
<tr valign="top">
<td>Time of comment</td>
<td>:</td>
<td><?php echo $row_rscontact_us['timeofcomment']; ?></td>
</tr>
<tr>
<td colspan="6" align="center"><label for="status_respond"></label>
  <input type="hidden" name="status_respond" id="status_respond" value="1" />  <input type="submit" value="Update record" /></td>
</tr>
</table>
<input type="hidden" name="id" value="<?php echo $row_rscontact_us['id']; ?>" />
<input type="hidden" name="MM_update" value="form1" />
</form> 
</body>
</html>
<?php
mysql_free_result($rscontact_us);
?>
