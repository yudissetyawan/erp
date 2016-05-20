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
  $insertSQL = sprintf("INSERT INTO f_monitoring_activity_header (crf, preparedby, approvedby, status) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['crf'], "int"),
                       GetSQLValueString($_POST['preparedby'], "int"),
                       GetSQLValueString($_POST['approvedby'], "int"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "../fab/viewmonitoringactivity.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT id, nocrf, projectcode, productioncode FROM a_crf ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_employee ORDER BY id ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<p>Input New Monitoring Activity
</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="439" border="0">
    <tr>
      <td width="141">CRF Number</td>
      <td width="10">&nbsp;</td>
      <td width="274"><label for="crf2"></label>
        <select name="crf" id="crf2">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['nocrf']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td>Revision Number</td>
      <td>&nbsp;</td>
      <td><label for="revision"></label>
        <input type="text" name="revision" id="revision" /></td>
    </tr>
    <tr>
      <td>Prepared By</td>
      <td>&nbsp;</td>
      <td><label for="preparedby"></label>
        <select name="preparedby" id="preparedby">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['firstname'];
		echo " ";
		echo $row_Recordset2['laststname'];?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td>Approved By</td>
      <td>&nbsp;</td>
      <td><label for="approvedby"></label>
        <select name="approvedby" id="approvedby">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['id']?>"><?php echo $row_Recordset2['firstname'];
		echo " ";
		echo $row_Recordset2['laststname'];?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td>Status</td>
      <td>&nbsp;</td>
      <td><select name="status" id="status">
        <option value="Status not Assigned">--Select Status--</option>
        <option value="Complete">Complete</option>
        <option value="On Progress">On Progress</option>
        <option value="Waiting List">Waiting List</option>
        <option value="Declined">Declined</option>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label for="status">
        <input type="submit" name="Submit" id="Submit" value="Submit" />
      </label></td>
    </tr>
  </table>
  <p></p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
