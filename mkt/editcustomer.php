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
  $updateSQL = sprintf("UPDATE a_customer SET customername=%s, address1=%s, adress2=%s, city=%s, zip=%s, country=%s, phone1=%s, phone2=%s, fax=%s, email=%s, reference=%s, remark=%s, npwp=%s WHERE id=%s",
                       GetSQLValueString($_POST['customername'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['adress2'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['phone1'], "text"),
                       GetSQLValueString($_POST['phone2'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['reference'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['npwp'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "viewcustomer.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_customer WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
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
<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

</head>

<body> 
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST"  class="General">
  <table width="690" border="0" class="General">
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td width="111" >No</td>
      <td width="13" >:</td>
      
      <td width="178"><label>
        <input name="id" type="text" id="id" value="<?php echo $row_Recordset1['id']; ?>" />
      </label></td>
      <td width="111" >Phone 1</td>
      <td width="13" >:</td>
      <td width="178"><span >
        <input name="phone1" type="text" id="phone1" value="<?php echo $row_Recordset1['phone1']; ?>" />
      </span></td>
    </tr>
    <tr>
      <td >Customer Name</td>
      <td >:</td>
      
      <td><label>
        <input name="customername" type="text" id="customername" value="<?php echo $row_Recordset1['customername']; ?>" />
      </label></td>
      <td >Phone 2</td>
      <td >:</td>
      <td><input name="phone2" type="text" id="phone2" value="<?php echo $row_Recordset1['phone2']; ?>" /></td>
    </tr>
    <tr>
      <td >Address 1</td>
      <td >:</td>
      
      <td>
        <textarea name="address1" id="address1"><?php echo $row_Recordset1['address1']; ?></textarea>
      </td>
      <td >Fax</td>
      <td >:</td>
      <td><input name="fax" type="text" id="fax" value="<?php echo $row_Recordset1['fax']; ?>" /></td>
    </tr>
    <tr>
      <td >Address 2</td>
      <td >:</td>
      
      <td><label>
        <textarea name="adress2" id="adress2"><?php echo $row_Recordset1['adress2']; ?></textarea>
      </label></td>
      <td >Email</td>
      <td >:</td>
      <td><input name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" /></td>
    </tr>
    <tr>
      <td >City</td>
      <td >:</td>
      
      <td><label>
        <input name="city" type="text" id="city" value="<?php echo $row_Recordset1['city']; ?>" />
      </label></td>
      <td >Reference</td>
      <td >:</td>
      <td><input name="reference" type="text" id="reference" value="<?php echo $row_Recordset1['reference']; ?>" /></td>
    </tr>
    <tr>
      <td >ZIP Code</td>
      <td >:</td>
      
      <td><label>
        <input name="zip" type="text" id="zip" value="<?php echo $row_Recordset1['zip']; ?>" />
      </label></td>
      <td >NPWP</td>
      <td >:</td>
      <td><input name="npwp" type="text" id="npwp" value="<?php echo $row_Recordset1['npwp']; ?>" /></td>
    </tr>
    <tr>
      <td >Country</td>
      <td >:</td>
      
      <td><label>
        <input name="country" type="text" id="country" value="<?php echo $row_Recordset1['country']; ?>" />
      </label></td>
      <td >Remark</td>
      <td >:</td>
      <td><textarea name="remark" id="remark"><?php echo $row_Recordset1['remark']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><input type="submit" name="save" id="save" value="Save" /></td>
    </tr>
    
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
