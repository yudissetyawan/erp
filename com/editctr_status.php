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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE c_ctr SET status=%s WHERE ctrno=%s",
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['ctrno'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM c_ctr WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE c_ctr SET status=%s WHERE ctrno=%s",
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['ctrno'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
 $kata=$_POST['status'];
if ($kata=="Approved") {$goto="editctr_statusapproval.php";} else {$goto="form_comm.php";}
  $updateGoTo = "$goto";
  
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM c_ctr WHERE ctrno = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php {
include "../date.php";
}
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="88" >CTR No.</td>
      <td width="4">:</td>
      <td width="293"><input name="ctrno" type="text" id="ctrno"  value="<?php echo $row_Recordset1['ctrno']; ?>" /><?php if ($row_Recordset1['statusrev']==1) {echo "Active";} else {echo "Inactive";}; ?></td>
      <td width="88" >Location</td>
      <td width="4" >:</td>
      <td colspan="2" width="293"><?php echo $row_Recordset1['location']; ?><input type="hidden" name="locatiion" value="<?php echo $row_Recordset1['location']; ?>" /></td>
    </tr>
    <tr>
      <td >Project Code</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['projectcode']; ?><input type="hidden" name="projectcode" value="<?php echo $row_Recordset1['projectcode']; ?>" /></td>
      <td >Quantity</td>
      <td >:</td> 
      <td colspan="2"><?php echo $row_Recordset1['quantity']; ?></td>
    </tr>
    <tr>
      <td >Customer</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['customer']; ?></td>
      <td >Contact Person</td>
      <td >:</td>
      <td colspan="2"><?php echo $row_Recordset1['contactperson']; ?></td>
    </tr>
    <tr>
      <td >Date Created</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['dateest']; ?><input type="hidden" name="ctr_issuedate" value="<?php echo $row_Recordset1['dateest']; ?>" /></td>
      <td >References</td>
      <td >:</td>
      <td colspan="2"><?php echo $row_Recordset1['reference']; ?></td>
    </tr>
    <tr>
      <td >Estimator</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['estimator']; ?></td>
      <td >Date Reference</td>
      <td >:</td>
      <td width="295"><?php echo $row_Recordset1['dateref']; ?></td>
      <td width="109"><?php if ($row_Recordset1[fileupload]=="") { echo " "; } 
		  else { 
		  echo "<a href='../com/upload_comm/$row_Recordset1[fileupload]'>View Ref. Document</a>";
		  };?></td>
    </tr>
    <tr>
      <td >Job Title</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['projecttitle']; ?><input type="hidden" name="projecttitle" value="<?php echo $row_Recordset1['projecttitle']; ?>" /></td>
      <td >Status</td>
      <td >:</td>
      <td colspan="2"><select name="status" id="status">
          <option>Pilih Status CTR</option>
          <option value="Approved">Approved</option>
          <option value="Hold">Hold</option>
          <option value="Cancel">Cancel</option>
          <option value="Submited">Submited</option>
      </select></td>
    </tr>
    <tr>
      <td >Requestor</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['requestor']; ?></td>
      <td > Remark</td>
      <td >:</td>
      <td colspan="2"><?php echo $row_Recordset1['remark']; ?></td>
    </tr>
    <tr>
      <td >Date Request</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['datereq']; ?>
      <input type="hidden" name="ctr_reqd" value="<?php echo $row_Recordset1['datereq']; ?>" /></td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="9"  align="center"><input type="submit" name="Save" id="Save" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="MM_update2" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
