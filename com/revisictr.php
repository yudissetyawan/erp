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
  $updateSQL = sprintf("UPDATE c_ctr SET statusrev=%s WHERE ctrno=%s",
                       GetSQLValueString(isset($_POST['statusbefore']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['noctrbefore'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "preproduction/input_detailctr.php?data=" . $row_Recordset1['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM c_ctr WHERE ctrno = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Procurement' OR h_employee.department = 'Commercial' OR h_employee.department='Project' OR h_employee.department='Engineering' AND h_employee.level='0' OR h_employee.userlevel = 'administrator' OR h_employee.userlevel = 'branchmanager'";
$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
$totalRows_rsidempdept = mysql_num_rows($rsidempdept);

if ($_POST['status'] == '1') {
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		do {
	  $insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($_POST['hfidinisial'], "int"),
						   GetSQLValueString($_POST['hfidprodcode'], "text"),
						   GetSQLValueString($row_rsidempdept['id'], "int"),
						   GetSQLValueString($_POST['hfisi'], "text"));
	
	  mysql_select_db($database_core, $core);
	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	
	}
		while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));	
	
	  $insertGoTo = "form_comm.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body class="General">
Revisi CTR<?php 
$cari=$row_Recordset1['ctrno'];
 // cari panjang max dari string yg di dapat dari query
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM c_ctr WHERE ctrno LIKE '%$cari%' ORDER BY ctrno DESC "));
$cekQ=$ceknomor[ctrno];
#mendefinisikan nilai awal
$rev=substr($cekQ,10,1);
#mengambil nilai no. revisi
$noawal=substr($cekQ,0,10);
#ketemu angka awal(angka sebelumnya) + dengan 1
$norev=(int)$rev+1;
$norevisi=sprintf ($noawal.$norev);
?>
<?
	  $cari=$noawal;
	  $sql=mysql_query("SELECT * FROM c_ctr  WHERE ctrno LIKE '%$cari%' ");
	 
	  ?>
<form id="form2" name="form2" method="post" action="">
  <?php {
include "../date.php";}
{include "uploadctr.php";}?>
</form>
<table width="210" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="783" border="0">
        <tr>
          <td colspan="7">&nbsp;</td>
          </tr>
        <tr>
          <td width="112">CTR No.</td>
          
          <td><input name="ctrno" type="text" id="ctrno" value="<?php echo $norevisi; ?>" /></td>
          <td width="40">&nbsp;</td>
          <td width="64">Status Revisi :</td>
          <td width="105"><input name="statusrev" type="checkbox" id="statusrev" checked="checked" />
Active</td>
          <td width="167">&nbsp;</td>
          <td width="69">&nbsp;</td>
        </tr>
        <tr>
          <td>Project Code</td>
          
          <td colspan="6"><input name="projectcode" type="text" id="projectcode" value="<?php echo $row_Recordset1['projectcode']; ?>"  readonly="readonly" /></td>
        </tr>
        <tr>
          <td>Customer</td>
          
          <td colspan="6"><textarea name="customer" readonly="readonly" id="customer"><?php echo $row_Recordset1['customer']; ?></textarea></td>
        </tr>
        <tr>
          <td>End User</td>
          
          <td colspan="6"><input name="contactperson" type="text" id="contactperson" value="<?php echo $row_Recordset1['contactperson']; ?>" /></td>
        </tr>
        <tr>
          <td>Job Title</td>
          
          <td colspan="6"><textarea name="projecttitle2" id="projecttitle2"><?php echo $row_Recordset1['projecttitle']; ?></textarea></td>
        </tr>
        <tr>
          <td>Location</td>
          
          <td colspan="6"><input name="location2" type="text" id="location2" value="<?php echo $row_Recordset1['location']; ?>" /></td>
        </tr>
        <tr>
          <td>Quantity</td>
          
          <td colspan="6"><input name="quantity2" type="text" id="quantity2" value="<?php echo $row_Recordset1['quantity']; ?>" /></td>
        </tr>
        <tr>
          <td>References</td>
          
          <td width="196"><textarea name="reference" id="reference"><?php echo $row_Recordset1['reference']; ?></textarea></td>
          <td>Date</td>
          
          <td colspan="2"><input name="dateref" type="text" id="tanggal2" value="<?php echo $row_Recordset1['dateref']; ?>" /></td>
          <td width="167"><input name="fileupload" type="text" class="hidentext" id="fileupload" value="<?php if ($nama_file==""){echo $row_Recordset3['fileupload'];} else {echo $nama_file;} ?>" /></td>
        </tr>
        <tr>
          <td>Requestor</td>
          
          <td><input name="requestor" type="text" id="requestor" value="<?php echo $row_Recordset1['requestor']; ?>" /></td>
          <td>Date</td>
          
          <td colspan="2"><input name="datereq" type="text" id="tanggal1" value="<?php echo $row_Recordset1['datereq']; ?>" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Estimator</td>
          
          <td><input name="estimator" type="text" id="estimator" value="<?php echo $row_Recordset1['estimator']; ?>" /></td>
          <td>Date </td>
          
          <td colspan="2"><input name="dateest" type="text" id="tanggal3" value="<?php echo $row_Recordset1['dateest']; ?>" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Remark</td>
          
          <td colspan="6"><textarea name="remark2" id="remark2"><?php echo $row_Recordset1['remark']; ?></textarea></td>
        </tr>
        <tr>
          <td >Status</td>
          
          <td><select name="status" id="status">
          	<option value="Submitted">Submitted</option>
            <option value="Hold">Hold</option>
            <option value="Cancel">Cancel</option>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="hidden" name="hfidinisial" id="hfidinisial" value="59" />
            <input type="hidden" name="hfidprodcode" id="hfidprodcode" value="<?php echo $norevisi; ?>" />
            <input type="hidden" name="hfisi" id="hfisi" value="CTR No. : <?php echo $norevisi; ?>, Contract Name : <?php echo $row_Recordset1['projecttitle']; ?> has been created " /></td>
          <td colspan="6"><?php if ($row_Recordset1[fileupload]=="") { echo "Tidak ada File Dilampirkan "; } 
		  else { 
		  echo "<a href='../com/upload_comm/$row_Recordset1[fileupload]'>View Document</a>";
		  };?>
            <input name="noctrbefore" type="text" class="hidentext" id="noctrbefore" value="<?php echo $row_Recordset1['ctrno']; ?>" />
            <input name="statusbefore" type="checkbox" class="hidentext" id="statusbefore" /></td>
        </tr>
        <tr align="center" >
          <td colspan="8" ><label>
            <input type="submit" name="Save" id="Save" value="Save" />
          </label></td>
          </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="MM_update" value="form1" />
    </form></td>
    <td valign="top"><table width="210" border="0" cellspacing="0" cellpadding="0">
      <tr class="tabel_header">
        <td>Recent CTR</td>
      </tr>
       <? 
	  while($sql1=mysql_fetch_array($sql)){
	  ?>
      <tr class="tabel_body">
        <td onclick="MM_openBrWindow('viewctr.php?data=<?php echo $sql1[id];?>','viewctr','width=800,height=400')"><a href="#"><?php echo $sql1[ctrno];?></a></td>
        </tr>
        <?
		}
		?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsidempdept);
?>
