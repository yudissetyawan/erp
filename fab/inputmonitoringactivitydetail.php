<?php require_once('Connections/core.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO f_monitoring_activity_core (monitoringactivityheader, itemparts, `description`, specmaterial, qty, cutting, forming, assembly, welding, ndetest, blastingpainting, others, remark) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nocrf'], "int"),
                       GetSQLValueString($_POST['itemparts'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['specmaterial'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['cutting'], "int"),
                       GetSQLValueString($_POST['forming'], "int"),
                       GetSQLValueString($_POST['assembly'], "int"),
                       GetSQLValueString($_POST['welding'], "int"),
                       GetSQLValueString($_POST['ndtest'], "int"),
                       GetSQLValueString($_POST['blastingpainting'], "int"),
                       GetSQLValueString($_POST['others'], "int"),
                       GetSQLValueString($_POST['remark'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "prj/viewmonitoringactivitydetail.php?data=" . $row_Recordset2['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$get_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $get_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT  a_crf.nocrf, f_monitoring_activity_header.id, f_monitoring_activity_header.crf, f_monitoring_activity_header.`date`, f_monitoring_activity_header.revisi, f_monitoring_activity_header.preparedby, f_monitoring_activity_header.approvedby, f_monitoring_activity_header.status FROM f_monitoring_activity_header, a_crf WHERE f_monitoring_activity_header.crf=a_crf.id AND f_monitoring_activity_header.id = %s", GetSQLValueString($get_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM f_monitoring_activity_header WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">


<table width="588" border="0">
Input Material
    <tr>
      <td width="240">Monitoring Activity Header</td>
      <td width="27">:</td>
      <td width="307"><input name="nocrfaja" type="monitoring" id="textfield"  disabled="disabled" value="<?php echo $row_Recordset2['nocrf']; ?>" /></td>
    </tr>
    <tr>
      <td>Item Parts</td>
      <td>:</td>
      <td><input type="text" name="itemparts" id="itemparts" /></td>
    </tr>
    <tr>
      <td>Description</td>
      <td>:</td>
      <td><textarea name="description" id="description" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>Speck Material</td>
      <td>:</td>
      <td><input type="text" name="specmaterial" id="specmaterial"/></td>
    </tr>
    <tr>
      <td>Qty</td>
      <td>:</td>
      <td><input name="qty" type="text" id="qty" size="3"/></td>
    </tr>
    <tr>
      <td>Cutting</td>
      <td>:</td>
      <td><input name="cutting" type="text" id="cutting" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>Forming</td>
      <td>:</td>
      <td><input name="forming" type="text" id="forming" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>Assembly</td>
      <td>:</td>
      <td><input name="assembly" type="text" id="assembly" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>Welding</td>
      <td>:</td>
      <td><input name="welding" type="text" id="welding" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>NDTEST</td>
      <td>:</td>
      <td><input name="ndtest" type="text" id="ndtest" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>Blasting &amp; Painting</td>
      <td>:</td>
      <td><input name="blastingpainting" type="text" id="blastingpainting" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>Others</td>
      <td>:</td>
      <td><input name="others" type="text" id="others" size="3"/>
      Item</td>
    </tr>
    <tr>
      <td>Remark</td>
      <td>:</td>
      <td><label>
        <textarea name="remark" id="remark" cols="45" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td><input name="nocrf" type="hidden" id="nocrf" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Save" id="Save" value="Save" onClick="saveForm(); return false;" /></td>
    </tr>
  </table>

  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset1);
?>
