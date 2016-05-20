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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO c_material (materialname, materialdescription, services, spec, vendor) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['maerial'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['servis'], "text"),
                       GetSQLValueString($_POST['textarea2'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  if($_GET['act']=='edit'){$deleteGoTo = "../editbom.php?data=".$_GET['data'] ; }
  else{$deleteGoTo = "../inputcorebom.php?data=".$_GET['data'];}
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT id, vendorname FROM c_vendor ORDER BY vendorname ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<form name="form" action="<?php echo $editFormAction; ?>" method="POST">
  <table width="411">
    <tr>
      <td width="101">Material Name</td>
      <td width="10">:</td>
      <td width="291"><input type="text" name="maerial" id="textfield"></td>
    </tr>
    <tr>
      <td>Material Description</td>
      <td>:</td>
      <td><textarea name="description" id="textarea" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>Service</td>
      <td>:</td>
      <td><select name="servis" id="select">
      <option value="no">Tidak</option>
        <option value="yes">Ya</option>
      </select></td>
    </tr>
    <tr>
      <td>Specification</td>
      <td>:</td>
      <td><textarea name="textarea2" id="textarea2" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Submit"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form">
</form>
<?php
mysql_free_result($Recordset1);
?>
