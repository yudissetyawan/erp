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
  $updateSQL = sprintf("UPDATE c_ctr SET projectcode=%s, customer=%s, dateest=%s, estimator=%s, projecttitle=%s, location=%s, quantity=%s, contactperson=%s, reference=%s, fileupload=%s, dateref=%s, remark=%s, status=%s, datereq=%s, requestor=%s WHERE ctrno=%s",
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['dateest'], "text"),
                       GetSQLValueString($_POST['estimator'], "text"),
                       GetSQLValueString($_POST['projecttitle2'], "text"),
                       GetSQLValueString($_POST['location2'], "text"),
                       GetSQLValueString($_POST['quantity2'], "text"),
                       GetSQLValueString($_POST['contactperson'], "text"),
                       GetSQLValueString($_POST['reference'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"),
                       GetSQLValueString($_POST['dateref'], "text"),
                       GetSQLValueString($_POST['remark2'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['datereq'], "text"),
                       GetSQLValueString($_POST['requestor'], "text"),
                       GetSQLValueString($_POST['ctrno'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "form_comm.php";
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
$query_Recordset1 = sprintf("SELECT * FROM c_ctr WHERE ctrno = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM c_ctr WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
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
<?php {
include "../date.php";
}
?>
<form id="form2" name="form2" method="post" action="">
  <?php {include "uploadctr.php";}?>
</form>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="783" border="0">
    <tr>
      <td colspan="8" align="center"><strong>EDIT CTR</strong></td>
    </tr>
    <tr>
      <td colspan="8" >&nbsp;</td>
    </tr>
    <tr>
      <td width="160" >CTR No.</td>
      <td width="4" >:</td>
      
      <td colspan="6" ><input name="ctrno" type="text" id="ctrno" value="<?php echo $row_Recordset1['ctrno']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td >Project Code</td>
      <td >:</td>
      
      <td colspan="6" ><input name="projectcode" type="text" id="projectcode" value="<?php echo $row_Recordset1['projectcode']; ?>"  readonly="readonly" /></td>
    </tr>
    <tr>
      <td >Customer</td>
      <td >:</td>
      
      <td colspan="6" ><textarea name="customer" readonly="readonly" id="customer"><?php echo $row_Recordset1['customer']; ?></textarea></td>
    </tr>
    <tr>
      <td >End User</td>
      <td >:</td>
      
      <td colspan="6" ><input name="contactperson" type="text" id="contactperson" value="<?php echo $row_Recordset1['contactperson']; ?>" /></td>
    </tr>
    <tr>
      <td >Job Title</td>
      <td >:</td>
      
      <td colspan="6" ><textarea name="projecttitle2" id="projecttitle2"><?php echo $row_Recordset1['projecttitle']; ?></textarea></td>
    </tr>
    <tr>
      <td >Location</td>
      <td >:</td>
      
      <td colspan="6" ><input name="location2" type="text" id="location2" value="<?php echo $row_Recordset1['location']; ?>" /></td>
    </tr>
    <tr>
      <td >Quantity</td>
      <td >:</td>
      
      <td colspan="6" ><input name="quantity2" type="text" id="quantity2" value="<?php echo $row_Recordset1['quantity']; ?>" /></td>
    </tr>
    <tr>
      <td >References</td>
      <td >:</td>
      
      <td width="269" ><textarea name="reference" id="reference"><?php echo $row_Recordset1['reference']; ?></textarea></td>
      <td width="35"  valign="middle">Date</td>
      <td width="1"  valign="middle">:</td>
      <td width="175" ><input name="dateref" type="text" id="tanggal2" value="<?php echo $row_Recordset1['dateref']; ?>" /></td>
      <td width="184" ><input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php if ($nama_file==""){echo $row_Recordset1['fileupload'];} else {echo $nama_file;} ?>" /></td>
    </tr>
    <tr>
      <td >Requestor</td>
      <td >:</td>
      
      <td ><input name="requestor" type="text" id="requestor" value="<?php echo $row_Recordset1['requestor']; ?>" /></td>
      <td >Date</td>
      <td >:</td>
      <td ><input name="datereq" type="text" id="tanggal1" value="<?php echo $row_Recordset1['datereq']; ?>" /></td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td >Estimator</td>
      <td >:</td>
      
      <td ><input name="estimator" type="text" id="estimator" value="<?php echo $row_Recordset1['estimator']; ?>" /></td>
      <td >Date </td>
      <td >:</td>
      <td ><input name="dateest" type="text" id="tanggal3" value="<?php echo $row_Recordset1['dateest']; ?>" /></td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td >Remark</td>
      <td >:</td>
      
      <td colspan="6" ><textarea name="remark2" cols="35" rows="4" id="remark2"><?php echo $row_Recordset1['remark']; ?></textarea></td>
    </tr>
    <tr>
      <td >Status</td>
      <td >:</td>
      
      <td colspan="6" >
        <select name="status" id="status">
          <option value="Hold" <?php if ($row_Recordset1['status'] == 'Hold') { ?> selected="selected" <?php } ?>>Hold</option>
          <option value="Cancel" <?php if ($row_Recordset1['status'] == 'Cancel') { ?> selected="selected" <?php } ?>>Cancel</option>
          <option value="Submitted" <?php if ($row_Recordset1['status'] == 'Submitted') { ?> selected="selected" <?php } ?>>Submitted</option>
        </select>   	
      </td>
    </tr>
    <tr>
      <td colspan="9"  align="center"><label>
        <input type="submit" name="Save" id="Save" value="Save" />
      </label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
