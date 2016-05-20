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
  $updateSQL = sprintf("UPDATE a_production_code SET projectcode=%s, productioncode=%s, wrno=%s, `date`=%s, Reference=%s, curency=%s, Location=%s, projecttitle=%s, quantity=%s, contactperson=%s, commdate=%s, completedate=%s, vendor=%s, remark=%s, fileupload=%s, statuscrf=%s WHERE id=%s",
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['productioncode'], "text"),
                       GetSQLValueString($_POST['wrno'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['Reference'], "text"),
                       GetSQLValueString($_POST['curency'], "text"),
                       GetSQLValueString($_POST['Location'], "text"),
                       GetSQLValueString($_POST['projecttitle'], "text"),
                       GetSQLValueString($_POST['quantity'], "text"),
                       GetSQLValueString($_POST['contactperson'], "text"),
                       GetSQLValueString($_POST['commdate'], "text"),
                       GetSQLValueString($_POST['completedate'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"),
                       GetSQLValueString($_POST['statuscrf'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
  $idprodcode = $_POST['id'];
  $updateGoTo = "view_productioncode.php?data=$idprodcode";
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
$query_Recordset1 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
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
* { font:"Times New Roman", Times, serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
  </style>

</head>

<body  class="General">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="956">
    <tr>
      <td class="General">Project code</td>
      <td>:</td>
      <td><input type="text" name="projectcode" value="<?php echo htmlentities($row_Recordset1['projectcode'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>Quantity</td>
      <td>:</td>
      <td><input type="text" name="quantity" value="<?php echo htmlentities($row_Recordset1['quantity'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td class="General">Production code</td>
      <td>:</td>
      <td><input type="text" name="productioncode" value="<?php echo htmlentities($row_Recordset1['productioncode'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>Vendor</td>
      <td>:</td>
      <td><input type="text" name="vendor" value="<?php echo htmlentities($row_Recordset1['vendor'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td class="General">Reference</td>
      <td>:</td>
      <td><input type="text" name="Reference" value="<?php echo htmlentities($row_Recordset1['Reference'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td> Contact person</td>
      <td>:</td>
      <td><input type="text" name="contactperson" value="<?php echo htmlentities($row_Recordset1['contactperson'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td>:</td>
      <td><input type="text" name="date" value="<?php echo htmlentities($row_Recordset1['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>Comm. date</td>
      <td>:</td>
      <td><input type="text" name="commdate" value="<?php echo htmlentities($row_Recordset1['commdate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      
      <td>Location</td>
      <td>:</td>
      <td><input type="text" name="Location" value="<?php echo htmlentities($row_Recordset1['Location'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td>Complete date</td>
      <td>:</td>
      <td><input type="text" name="completedate" value="<?php echo htmlentities($row_Recordset1['completedate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>

    </tr>
    <tr>
      <td class="General"> Projecttitle</td>
      <td>:</td>
      <td><input type="text" name="projecttitle" value="<?php echo htmlentities($row_Recordset1['projecttitle'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>WR. no</td>
      <td>:</td>
      <td><input type="text" name="wrno" value="<?php echo htmlentities($row_Recordset1['wrno'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td class="General">Remark</td>
      <td>:</td>
      <td><input type="text" name="remark" value="<?php echo htmlentities($row_Recordset1['remark'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>WR. Value</td>
      <td>:</td>
      <td><input type="text" name="curency" value="<?php echo htmlentities($row_Recordset1['curency'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><input type="submit" value="Update" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_Recordset1['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
