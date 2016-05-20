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
if ($kata=="Approved") {$goto="inputproductioncode.php";} else {$goto="form_comm.php";}
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
<form method="POST" name="form1" class="General" id="form1">
  <table width="920" border="0">
    <tr>
      <td width="123" class="General">CTR No.</td>
      <td width="10">:</td>
      <td width="258" class="General"><?php echo $row_Recordset1['ctrno']; ?></td>
      <td width="135" class="General">Location</td>
      <td width="10">:</td>
      <td colspan="2" class="General"><?php echo $row_Recordset1['location']; ?></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['projectcode']; ?></td>
      <td class="General">Quantity</td>
      <td>:</td>
      <td colspan="2" class="General"><?php echo $row_Recordset1['quantity']; ?></td>
    </tr>
    <tr>
      <td class="General">Customer</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['customer']; ?></td>
      <td class="General">Contact Person</td>
      <td>:</td>
      <td colspan="2" class="General"><?php echo $row_Recordset1['contactperson']; ?></td>
    </tr>
    <tr>
      <td class="General">Date Created</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['dateest']; ?></td>
      <td class="General">References</td>
      <td>:</td>
      <td colspan="2" class="General"><?php echo $row_Recordset1['reference']; ?></td>
    </tr>
    <tr>
      <td class="General">Estimator</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['estimator']; ?></td>
      <td class="General">Date Reference</td>
      <td>:</td>
      <td width="204" class="General"><?php echo $row_Recordset1['dateref']; ?></td>
      <td width="150" class="General"><?php if ($row_Recordset1[fileupload]=="") { echo " "; } 
		  else { 
		  echo "<a href='../com/upload_comm/$row_Recordset1[fileupload]'>View Ref. Document</a>";
		  };?></td>
    </tr>
    <tr>
      <td class="General">Job Title</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['projecttitle']; ?></td>
      <td class="General">Remark</td>
      <td>:</td>
      <td colspan="2" class="General"><?php echo $row_Recordset1['remark']; ?></td>
    </tr>
    <tr>
      <td class="General">Requestor</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['requestor']; ?></td>
      <td class="General">Status</td>
      <td class="General">:</td>
      <td colspan="2" class="General"><?php echo $row_Recordset1['status']; ?></td>
    </tr>
    <tr>
      <td class="General">Date Request</td>
      <td>:</td>
      <td class="General"><?php echo $row_Recordset1['datereq']; ?></td>
      <td class="General">Status Revisi</td>
      <td class="General">:</td>
      <td colspan="2" class="General"><?php if ($row_Recordset1['statusrev']==1) {echo "Active";} else {echo "Inactive";}; ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
