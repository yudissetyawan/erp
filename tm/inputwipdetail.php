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
  $insertSQL = sprintf("INSERT INTO a_expnbal (jenisID, bulan, proj_code, nilai) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['plan'], "text"),
                       GetSQLValueString($_POST['wr'], "text"),
                       GetSQLValueString($_POST['proj_code'], "text"),
                       GetSQLValueString($_POST['planvalue'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO a_expnbal (jenisID, bulan, proj_code, nilai) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['actual'], "text"),
                       GetSQLValueString($_POST['wr'], "text"),
                       GetSQLValueString($_POST['proj_code'], "text"),
                       GetSQLValueString($_POST['actualvalue'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_proj_code WHERE project_code = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="828" border="0">
    <tr>
      <td colspan="4" class="tabel_header"><input name="proj_code" type="hidden" id="proj_code" value="<?php echo $row_Recordset1['project_code']; ?>" />
        Description Budget Cost For Project KLO - J134
      <label for="description"></label></td>
    </tr>
    <tr>
      <td width="230">Month </td>
      <td width="10">&nbsp;</td>
      <td colspan="2"><label for="wr2"></label>
        <select name="wr" id="wr2">
          <option value="Jan">Januari</option>
          <option value="Feb">Februari</option>
          <option value="Mar">Maret</option>
          <option value="Apr">April</option>
          <option value="May">May</option>
          <option value="Jun">Juni</option>
          <option value="Jul">July</option>
          <option value="Agt">Agustus</option>
          <option value="Sep">September</option>
          <option value="Okt">Oktober</option>
          <option value="Nov">November</option>
          <option value="Des">Desember</option>
          <?php
do {  
?>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select> </td>
    </tr>
    <tr>
      <td>Work Progress Percentage &amp; Value (Plan)</td>
      <td>&nbsp;</td>
      <td width="507">Rp. 
        <input type="text" name="planvalue" id="workprogressvalue" />
        <input name="plan" type="hidden" id="plan" value="1" />
wr value for IDR x 1000</td>
    </tr>
    <tr>
      <td>Work Progress Percentage &amp; Value (Actual)</td>
      <td>&nbsp;</td>
      <td>Rp. <input type="text" name="actualvalue" id="workprogresspercentage3" />
        <input name="actual" type="hidden" id="actual" value="2" />
wr value for IDR x 1000</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="Submit" id="Submit" value="Submit" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
