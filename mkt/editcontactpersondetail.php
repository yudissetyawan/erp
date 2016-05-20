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
  $updateSQL = sprintf("UPDATE a_contactperson SET department=%s, `position`=%s, customer=%s, firstname=%s, lastname=%s, phone1=%s, phone2=%s, address=%s, email=%s WHERE id=%s",
                       GetSQLValueString($_POST['department'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['phone1'], "text"),
                       GetSQLValueString($_POST['phone2'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_contactperson WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
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

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="453" border="0">
    <tr>
      <td width="75">First Name</td>
      <td width="13">&nbsp;</td>
      <td width="290"><input name="firstname" type="text" class="required" id="firstname" title="Firstname is required" value="<?php echo $row_Recordset1['firstname']; ?>" /></td>
    </tr>
    <tr>
      <td>Last Name</td>
      <td>&nbsp;</td>
      <td><input name="lastname" type="text" class="required" id="lastname" title="Lastname is required" value="<?php echo $row_Recordset1['lastname']; ?>"/></td>
    </tr>
    <tr>
      <td>Customer </td>
      <td>&nbsp;</td>
      <td><input name="customer" type="text" id="customer" value="<?php echo $row_Recordset1['customer']; ?>" /></td>
    </tr>
    <tr>
      <td>Department</td>
      <td>&nbsp;</td>
      <td><label for="department"></label>
        <input name="department" type="text" class="required" id="department" title="Department is required" value="<?php echo $row_Recordset1['department']; ?>" /></td>
    </tr>
    <tr>
      <td>Position</td>
      <td>&nbsp;</td>
      <td><label for="position"></label>
        <input name="position" type="text" class="required" id="position" title="Position is required" value="<?php echo $row_Recordset1['position']; ?>" /></td>
    </tr>
    <tr>
      <td>Phone 1</td>
      <td>&nbsp;</td>
      <td><span id="sprytextfield1">
        <input name="phone3" type="text" id="phone3" value="<?php echo $row_Recordset1['phone1']; ?>" />
        <span class="textfieldRequiredMsg">Phone 1 is Required</span><span class="textfieldInvalidFormatMsg">Phone 1 is Required</span></span></td>
</tr>
    <tr>
      <td>Phone 2</td>
      <td>&nbsp;</td>
      <td><input name="phone2" type="text" id="phone2" title="Phone 2 is required" value="<?php echo $row_Recordset1['phone2']; ?>"/></td>
    </tr>
    <tr>
      <td>Address</td>
      <td>&nbsp;</td>
      <td><textarea name="address" id="address" class="required" title="Address is required"><?php echo $row_Recordset1['address']; ?></textarea></td>
    </tr>
    <tr>
      <td>Email</td>
      <td>&nbsp;</td>
      <td><input name="email" type="text" class="required" id="email" title="Email Harus diisi" value="<?php echo $row_Recordset1['email']; ?>"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="save" id="save" value="Submit" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1['id']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
