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
  $insertSQL = sprintf("INSERT INTO a_crf_schedulle (crf, designstart, designend, drawingstart, drawingend, itpstart, itpend, materialstart, materialend, fabricationstart, fabricationend, testingstart, testingend, blastingpaintingstart, blastingpaintingend, instalationstart, instalationend, deliverystart, deliveryend, othersstart, othersend) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['crf'], "int"),
                       GetSQLValueString($_POST['designstart'], "text"),
                       GetSQLValueString($_POST['designend'], "text"),
                       GetSQLValueString($_POST['drawingstart'], "text"),
                       GetSQLValueString($_POST['drawingend'], "text"),
                       GetSQLValueString($_POST['itpstart'], "text"),
                       GetSQLValueString($_POST['itpend'], "text"),
                       GetSQLValueString($_POST['materialstart'], "text"),
                       GetSQLValueString($_POST['materialend'], "text"),
                       GetSQLValueString($_POST['fabricationstart'], "text"),
                       GetSQLValueString($_POST['fabricationend'], "text"),
                       GetSQLValueString($_POST['testingstart'], "text"),
                       GetSQLValueString($_POST['testingend'], "text"),
                       GetSQLValueString($_POST['blastingpaintingstart'], "text"),
                       GetSQLValueString($_POST['blastingpaintingend'], "text"),
                       GetSQLValueString($_POST['instalationstart'], "text"),
                       GetSQLValueString($_POST['instalationend'], "text"),
                       GetSQLValueString($_POST['deliverystart'], "text"),
                       GetSQLValueString($_POST['deliveryend'], "text"),
                       GetSQLValueString($_POST['othersstart'], "text"),
                       GetSQLValueString($_POST['othersend'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewcrfschedulle.php?data=" . $row_Recordset1['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
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

<body class="General" >
  <?php
  {include "date.php";}
?>
<p>Input CRF Schedulle <?php echo $row_Recordset1['nocrf']; ?></p>

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="437" border="0" class="General">
    <tr class="judul">
      <td colspan="2">Tipe Pekerjaan</td>
      <td>Start Date</td>
      <td>Finish Date</td>
    </tr>
    <tr>
      <td width="119">Design</td>
      <td width="11">:</td>
      <td width="148"><input name="designstart" type="text" class="required" id="tanggal21" title="Date is required" /></td>
      <td width="141"><input name="designend" type="text" class="required" id="tanggal22" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Drawing</td>
      <td>:</td>
      <td><input name="drawingstart" type="text" class="required" id="tanggal3" title="Date is required" /></td>
      <td><input name="drawingend" type="text" class="required" id="tanggal4" title="Date is required" /></td>
    </tr>
    <tr>
      <td>ITP</td>
      <td>:</td>
      <td><input name="itpstart" type="text" class="required" id="tanggal5" title="Date is required" /></td>
      <td><input name="itpend" type="text" class="required" id="tanggal6" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Material</td>
      <td>:</td>
      <td><input name="materialstart" type="text" class="required" id="tanggal7" title="Date is required" /></td>
      <td><input name="materialend" type="text" class="required" id="tanggal8" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Fabrication</td>
      <td>:</td>
      <td><input name="fabricationstart" type="text" class="required" id="tanggal9" title="Date is required" /></td>
      <td><input name="fabricationend" type="text" class="required" id="tanggal10" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Test/NDE</td>
      <td>:</td>
      <td><input name="testingstart" type="text" class="required" id="tanggal11" title="Date is required" /></td>
      <td><input name="testingend" type="text" class="required" id="tanggal12" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Blasting Painting</td>
      <td>:</td>
      <td><input name="blastingpaintingstart" type="text" class="required" id="tanggal13" title="Date is required" /></td>
      <td><input name="blastingpaintingend" type="text" class="required" id="tanggal14" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Delivery</td>
      <td>:</td>
      <td><input name="deliverystart" type="text" class="required" id="tanggal15" title="Date is required" /></td>
      <td><input name="deliveryend" type="text" class="required" id="tanggal16" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Instalation</td>
      <td>:</td>
      <td><input name="instalationstart" type="text" class="required" id="tanggal17" title="Date is required" /></td>
      <td><input name="instalationend" type="text" class="required" id="tanggal18" title="Date is required" /></td>
    </tr>
    <tr>
      <td>Others</td>
      <td>:</td>
      <td><input name="othersstart" type="text" class="required" id="tanggal19" title="Date is required" /></td>
      <td><input name="othersend" type="text" class="required" id="tanggal20" title="Date is required" /></td>
    </tr>
    <tr>
      <td><input name="crf" type="hidden" id="crf" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      <td>&nbsp;</td>
      <td colspan="2"><input type="submit" name="Submit" id="Submit" value="Submit" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <pre></pre>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
