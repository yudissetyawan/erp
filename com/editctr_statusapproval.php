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
  $insertSQL = sprintf("INSERT INTO pr_header_wpr (idctr, project_title, `description`, contract_no, wo_no, aff_no, const_eng, pic_name, ctr_approval, type_ofwork, ctr_reqd, ctr_no, location, startdate, finishdate, projectcode) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_ctr'], "text"),
                       GetSQLValueString($_POST['projecttitle'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['contract_no'], "text"),
                       GetSQLValueString($_POST['wo_no'], "text"),
                       GetSQLValueString($_POST['aff_no'], "text"),
                       GetSQLValueString($_POST['const_eng'], "text"),
                       GetSQLValueString($_POST['pic_name'], "text"),
                       GetSQLValueString($_POST['ctr_approval'], "text"),
                       GetSQLValueString($_POST['type_ofwork'], "text"),
                       GetSQLValueString($_POST['ctr_reqd'], "text"),
                       GetSQLValueString($_POST['ctrno2'], "text"),
                       GetSQLValueString($_POST['locatiion'], "text"),
                       GetSQLValueString($_POST['startdate'], "text"),
                       GetSQLValueString($_POST['finishdate'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "../com/input_detailctr.php?data=" . $row_Recordset1['id'] . "";
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
if ($kata=="Approved") {$goto="input_detailctr.php";} else {$goto="form_comm.php";}
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
  <table width="920" border="0" cellpadding="3">
    <tr>
      <td colspan="6" align="center"><label for="id_ctr"></label>
      WORK ORDER</td>
    </tr>
    <tr>
      <td width="95">CTR No.</td>
      <td width="4">:</td>
      <td width="290"><input name="ctrno2" type="text" id="ctrno2"  value="<?php echo $row_Recordset1['ctrno']; ?>" />        <?php if ($row_Recordset1['statusrev']==1) {echo "Active";} else {echo "Inactive";}; ?></td>
      <td width="105">Location</td>
      <td width="4">:</td>
      <td width="374"><?php echo $row_Recordset1['location']; ?><input type="hidden" name="locatiion" value="<?php echo $row_Recordset1['location']; ?>" /></td>
    </tr>
    <tr>
      <td>Project Code</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['projectcode']; ?><input type="hidden" name="projectcode" value="<?php echo $row_Recordset1['projectcode']; ?>" /></td>
      <td>Quantity</td>
      <td>:</td> 
      <td><?php echo $row_Recordset1['quantity']; ?></td>
    </tr>
    <tr>
      <td>Customer</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['customer']; ?></td>
      <td>Contact Person</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['contactperson']; ?></td>
    </tr>
    <tr>
      <td>Date Created</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['dateest']; ?><input type="hidden" name="ctr_issuedate" value="<?php echo $row_Recordset1['dateest']; ?>" /></td>
      <td>References</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['reference']; ?></td>
    </tr>
    <tr>
      <td>Estimator</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['estimator']; ?></td>
      <td>Date Reference</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['dateref']; ?></td>
    </tr>
    <tr>
      <td>Job Title</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['projecttitle']; ?><input type="hidden" name="projecttitle" value="<?php echo $row_Recordset1['projecttitle']; ?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php if ($row_Recordset1[fileupload]=="") { echo "-"; } 
		  else { 
		  echo "<a href='../com/upload_comm/$row_Recordset1[fileupload]'>View Ref. Document</a>";
		  };?></td>
    </tr>
    <tr>
      <td>Requestor</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['requestor']; ?></td>
      <td>Remark</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['remark']; ?></td>
    </tr>
    <tr>
      <td>Date Request</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['datereq']; ?> <input type="hidden" name="ctr_reqd" value="<?php echo $row_Recordset1['datereq']; ?>" /></td>
      <td>WO No</td>
      <td>:</td>
      <td><input type="text" name="wo_no" id="wo_no" />
      <input name="ctrno" type="hidden" id="ctrno" value="<?php echo $row_Recordset1['ctrno']; ?>"/></td>
    </tr>
    <tr>
      <td>Commencement Date</td>
      <td>:</td>
      <td><input type="text" name="startdate" id="tanggal6" /></td>
      <td>Finish Date</td>
      <td>:</td>
      <td><input type="text" name="finishdate" id="tanggal7" /></td>
    </tr>
    <tr>
      <td>Contract Manager</td>
      <td>:</td>
      <td><input type="text" name="const_eng" id="const_eng" /></td>
      <td>Contarctor PIC Name</td>
      <td>:</td>
      <td><input type="text" name="pic_name" id="pic_name" /></td>
    </tr>
    <tr>
      <td>Type of Work</td>
      <td>:</td>
      <td><label>
        <input type="text" name="type_ofwork" id="type_ofwork" />
      </label></td>
      <td> Approval Date</td>
      <td>:</td>
      <td><label>
        <input type="text" name="ctr_approval" id="tanggal8" />
      </label></td>
    </tr>
   
    <tr>
      <td>AFE/CC No</td>
      <td>:</td>
      <td><input type="text" name="aff_no" id="aff_no" /></td>
      <td rowspan="2">Description</td>
      <td rowspan="2">:</td>
      <td rowspan="2"><textarea name="description" id="description" cols="45" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>Contract No</td>
      <td>:</td>
      <td>
        <input type="text" name="contract_no" id="contract_no" />
      </td>
    </tr>
    <tr>
      <td colspan="8" align="center"><input type="hidden" name="id_ctr" id="id_ctr" value="<?php echo $_GET['data']; ?>" />        <input type="submit" name="Save" id="Save" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update2" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
