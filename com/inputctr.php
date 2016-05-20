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
  $insertSQL = sprintf("INSERT INTO c_ctr (ctrno, projectcode, customer, dateest, estimator, projecttitle, location, quantity, contactperson, reference, fileupload, dateref, remark, status, datereq, requestor, statusrev) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ctrno'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['dateest'], "text"),
                       GetSQLValueString($_POST['estimator'], "text"),
                       GetSQLValueString($_POST['projecttitle'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['quantity'], "text"),
                       GetSQLValueString($_POST['contactperson'], "text"),
                       GetSQLValueString($_POST['reference'], "text"),
                       GetSQLValueString($_POST['fileupload'], "text"),
                       GetSQLValueString($_POST['dateref'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['datereq'], "text"),
                       GetSQLValueString($_POST['requestor'], "text"),
                       GetSQLValueString(isset($_POST['statusrev']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "form_comm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

/*
	$sqlIdJob = "SELECT id_pekerjaan FROM log_pesan WHERE id_pekerjaan = '$idcp' AND id_inisial = '59'";
	$cmdIdJob = mysql_query($sqlIdJob) or die(mysql_error());
	$nData = mysql_num_rows($cmdIdJob);
	
	if ($nData == 0) {
		do {
			$idemp = $rstEmp['id'];
			$sqlMsg = "UPDATE log_pesan SET (id_inisial, id_pekerjaan, id_empdept, isi, removable_ntf, ntf_goto)
									WHERE ('59', '$idcp', '$idemp', '$msgcnt', 'UR', '../ppic/editcertificateproduct$catg.php?data=$idcp')";
						$cmdMsg = mysql_query($sqlMsg) or die(mysql_error());
					} while ($rstEmp = mysql_fetch_assoc($cmdEmp));			
	}
*/

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_proj_code WHERE project_code = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Procurement' OR h_employee.department = 'Commercial' OR h_employee.department = 'Project' OR h_employee.department = 'Engineering' AND h_employee.level = '0' OR h_employee.userlevel = 'administrator' OR h_employee.userlevel = 'branchmanager'";
$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
$totalRows_rsidempdept = mysql_num_rows($rsidempdept);

//if ($_POST['status'] == '1') {
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString(59, "int"),
						   GetSQLValueString($_POST['hfidprodcode'], "text"),
						   GetSQLValueString($row_rsidempdept['id'], "int"),
						   GetSQLValueString('CTR No. : '.$_POST['hfidprodcode'].', Contract Name : '.$_POST['projecttitle'].' has been created, status = '.$_POST['status'], "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	
	} while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));	
	
	  $insertGoTo = "form_comm.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	}
//}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input CTR</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php
	$cari=$row_Recordset1['project_code'];
	 // cari panjang max dari string yg di dapat dari query
	$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM c_ctr WHERE projectcode LIKE '%$cari%' ORDER BY ctrno DESC LIMIT 1"));
	$cekQ=$ceknomor[ctrno];
	$project=$row_Recordset1['project_code'];
	#menghilangkan huruf
	$awalQ=substr($cekQ,0,3);
	#ketemu angka awal(angka sebelumnya) + dengan 1
	$next=(int)$awalQ+1;
	$projectcode=$ceknomor[projectcode];
	$nextctr=sprintf ("%03d", $next).'-'.$project.'-'.'R0';
?>

<?php { include "../date.php"; include "upload.php"; } ?>
<form id="form2" name="form2" method="post" action=""><?php { include "uploadctr.php"; }?>

</form>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" class="General" id="form1">
  <table width="783" border="0">
    <tr>
      <td width="129" class="General">CTR No.</td>
      <td width="9">:</td>
      <td colspan="5" class="General"><input name="ctrno" type="text" id="ctrno" value="<?php echo $nextctr;?>" readonly="readonly" />      
      *Auto Increment</td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td class="General"><input name="projectcode" type="text" id="projectcode" value="<?php echo $row_Recordset1['project_code']; ?>"  readonly="readonly" /></td>
      <td width="70" class="General">Customer</td>
      <td width="4">:</td>
      <td colspan="2" class="General"><textarea name="customer" cols="30" readonly="readonly" id="customer"><?php echo $row_Recordset1['customer']; ?></textarea></td>
    </tr>
    <tr>
      <td class="General">End User</td>
      <td>:</td>
      <td colspan="5" class="General"><input type="text" name="contactperson" id="contactperson" /></td>
    </tr>
    <tr>
      <td class="General">Job Title</td>
      <td>:</td>
      <td colspan="5" class="General"><textarea name="projecttitle" id="projecttitle"></textarea></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td colspan="5" class="General"><input type="text" name="location" id="location" /></td>
    </tr>
    <tr>
      <td class="General">Quantity</td>
      <td>:</td>
      <td colspan="5" class="General"><input type="text" name="quantity" id="quantity" /></td>
    </tr>
    <tr>
      <td class="General">References</td>
      <td>:</td>
      <td width="211" class="General"><textarea name="reference" id="reference"></textarea></td>
      <td class="General">Date</td>
      <td class="General">:</td>
      <td width="182" class="General"><input type="text" name="dateref" id="tanggal2" /></td>
      <td width="148" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Requestor</td>
      <td>:</td>
      <td class="General"><input type="text" name="requestor" id="requestor" /></td>
      <td class="General">Date</td>
      <td class="General">:</td>
      <td class="General"><input type="text" name="datereq" id="tanggal1" /></td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Estimator</td>
      <td>:</td>
      <td class="General"><input type="text" name="estimator" id="estimator" /></td>
      <td class="General">Date </td>
      <td class="General">:</td>
      <td class="General"><input type="text" name="dateest" id="tanggal3" /></td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Remark</td>
      <td>:</td>
      <td colspan="5" class="General"><textarea name="remark" cols="35" rows="4" id="remark"></textarea>
        <input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php echo $nama_file; ?>" />
      <input name="statusrev" type="checkbox" class="hidentext" id="statusrev" checked="checked" /></td>
    </tr>
    <tr>
      <td class="General">Status</td>
      <td>:</td>
      <td colspan="5" class="General">
      <select name="status" id="status">
        <option value="Hold">Hold</option>
        <option value="Cancel">Cancel</option>
        <option value="Submitted">Submitted</option>
      </select>
      <input type="hidden" name="hfidprodcode" id="hfidprodcode" value="<?php echo $nextctr; ?>" />
      </td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5" class="General"><label>
        <input type="submit" name="Save" id="Save" value="Save" />
      </label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
	mysql_free_result($rsidempdept);
?>