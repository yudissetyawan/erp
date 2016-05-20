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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO h_daily_report_header (day_date) VALUES (%s)",
                       GetSQLValueString($_POST['date'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewdailyreport.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//Record daily report header
mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT a.id, a.day_date, a.location, a.foreman, b.firstname FROM h_daily_report_header a LEFT JOIN h_employee b ON a.supervisor=b.id"; // 
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link href="../css/induk.css" type="text/css" rel="stylesheet" />
<title>Daily Report</title>
</head>

<body>
<?php {include "../date.php";} ?>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
Create New Daily Report | Day/Date :
  <label for="date"></label>
  <input name="date" type="text" id="tanggal1" maxlength="25" />
  <input type="submit" name="button" id="button" value="Submit" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table width="1096" >
  <tr bgcolor="#0066FF" class="tabel_header">
    <td width="39">No</td>
    <td width="378">Day/Date</td>
    <td width="158">Location</td>
    <td width="232">Foreman</td>
    <td width="235">Supervisor</td>
  </tr>
  <?php $i=0; do{ ?>
  <tr class="tabel_body">
    <td><?php $i++; echo $i; ?></td>
    <?php // link ke dailyreport detail sesuai degan id headernya ?>
    <td><a href="viewdailyreportdetail.php?data=<?php echo $row_Recordset1['id']; ?>"><?php echo $row_Recordset1['day_date']; ?></a></td>
    <td><?php echo $row_Recordset1['location']; ?></td>
    <td><?php echo $row_Recordset1['foreman']; ?></td>
    <td><?php echo $row_Recordset1['firstname']; ?></td>
    <td width="27">X</td>
  </tr>
  <?php }while($row_Recordset1 = mysql_fetch_assoc($Recordset1))?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
