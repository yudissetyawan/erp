<?php require_once('../Connections/core.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE a_crf SET approval=%s, dateapproval=%s WHERE nocrf=%s",
                       GetSQLValueString(isset($_POST['approval']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['approvaldate'], "text"),
                       GetSQLValueString($_POST['nocrf'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "../tm/form_tm.php";
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
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
mysql_free_result($Recordset1);
?>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="803" border="0">
    <tr>
      <td width="174">No CRF</td>
      <td width="13">:</td>
      <td colspan="5"><?php echo $row_Recordset1['nocrf']; ?></td>
    </tr>
    <tr>
      <td rowspan="3">Distribution List</td>
      <td rowspan="3">:</td>
      <td><? if ($row_Recordset1['marketing']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>Marketing</td>
      <td width="100"><? if ($row_Recordset1['quality']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>Quality </td>
      <td width="109"><? if ($row_Recordset1['procurement']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>        Procurement</td>
      <td width="111"> <? if ($row_Recordset1['hrd']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       HRD </td>
      <td width="149"> <? if ($row_Recordset1['it']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       IT</td>
    </tr>
    <tr>
      <td> <? if ($row_Recordset1['commercial']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       Commercial</td>
      <td> <? if ($row_Recordset1['hse']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       HSE</td>
      <td> <? if ($row_Recordset1['ppic']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       PPIC</td>
      <td>  <? if ($row_Recordset1['acc']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>      Accounting</td>
      <td> <? if ($row_Recordset1['siteproject']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       Site Project</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><? if ($row_Recordset1['engineering']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>        Engineering</td>
      <td><? if ($row_Recordset1['fabrication']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>      Fabrication</td>
      <td>  <? if ($row_Recordset1['maintenance']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>      Maintenance</td>
      <td> <? if ($row_Recordset1['file']==1) {echo  "<input name='checkbox' type='checkbox' checked='checked' />";}
		  else {echo  "<input name='checkbox' type='checkbox'/>";  } ?>       DCC</td>
    </tr>
    <tr>
      <td>Job Title</td>
      <td>:</td>
      <td colspan="5"><label for="jobtitle"><?php echo $row_Recordset1['jobtitle']; ?></label></td>
    </tr>
    <tr>
      <td>QTY</td>
      <td>:</td>
      <td colspan="5"><label for="qty"><?php echo $row_Recordset1['qty']; ?></label></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td colspan="5"><?php echo $row_Recordset1['date']; ?></td>
    </tr>
    <tr>
      <td>Project Code - Production Code - Customer</td>
      <td>:</td>
      <td colspan="5"><label for="productioncode"><?php echo $row_Recordset1['projectcode']; ?> - <?php echo $row_Recordset1['productioncode']; ?> - <?php echo $row_Recordset1['customer']; ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td>--- End User ---</td>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td>Name</td>
      <td>:</td>
      <td colspan="5"><label for="name"><?php echo $row_Recordset1['name']; ?></label></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>:</td>
      <td colspan="5"><label for="datw"><?php echo $row_Recordset1['datw']; ?></label></td>
    </tr>
    <tr>
      <td>Reference</td>
      <td>:</td>
      <td colspan="5"><label for="ref"><?php echo $row_Recordset1['ref']; ?></label></td>
    </tr>
    <tr>
      <td>Other</td>
      <td>:</td>
      <td colspan="5"><label for="others"><?php echo $row_Recordset1['others']; ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td>--- End User ---</td>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td>Drawing Sketch</td>
      <td>:</td>
      <td colspan="5"><label for="drawingsketch"><?php echo $row_Recordset1['drawingsketch']; ?></label></td>
    </tr>
    <tr>
      <td>Supplied Material</td>
      <td>:</td>
      <td colspan="5"><label for="suppliedmaterial"><?php echo $row_Recordset1['suppliedmaterial']; ?></label></td>
    </tr>
    <tr>
      <td>Other Terms Condition</td>
      <td>:</td>
      <td colspan="5"><label for="otherstermsandcondition"><?php echo $row_Recordset1['otherstermsandcondition']; ?></label></td>
    </tr>
    <tr>
      <td>Prepared By</td>
      <td>:</td>
      <td colspan="5"><label for="preparedby"><?php echo $row_Recordset1['preparedby']; ?></label></td>
    </tr>
    <tr>
      <td>Approved By</td>
      <td>:</td>
      <td colspan="5"><label for="approvedby"><?php echo $row_Recordset1['approvedby']; ?></label></td>
    </tr>
    <tr>
      <td>Client Verification</td>
      <td>:</td>
      <td colspan="5"><?php echo $row_Recordset1['clientverivication']; ?></td>
    </tr>
    <tr>
      <td>Issued Date</td>
      <td>:</td>
      <td colspan="5"><?php echo $row_Recordset1['issueddate']; ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
