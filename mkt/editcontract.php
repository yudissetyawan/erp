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
  $updateSQL = sprintf("UPDATE a_proj_code SET project_code=%s, projecttitle=%s, qty=%s, customer=%s, receivedorder=%s, typeorder=%s, contractno=%s, commdate=%s, completiondate=%s, projectvalue=%s, status=%s, complete=%s, fileupload=%s WHERE pracode=%s",
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['projecttitle'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['receivedorder'], "text"),
                       GetSQLValueString($_POST['typeorder'], "text"),
                       GetSQLValueString($_POST['contractno'], "text"),
                       GetSQLValueString($_POST['commdate'], "text"),
                       GetSQLValueString($_POST['completiondate'], "text"),
                       GetSQLValueString($_POST['projectvalue'], "text"),
                       GetSQLValueString($_POST['projectstatus'], "text"),
                       GetSQLValueString(isset($_POST['complete']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['fileupload'], "text"),
                       GetSQLValueString($_POST['pracode'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "view_contract.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && (isset($_POST['complete']))) {	
//GIVE NOTIF ACTION IF COMPLETE
	mysql_select_db($database_core, $core);
	$query_rsidempdept = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Commercial' OR h_employee.userlevel = 'administrator'";
	$rsidempdept = mysql_query($query_rsidempdept, $core) or die(mysql_error());
	$row_rsidempdept = mysql_fetch_assoc($rsidempdept);
	$totalRows_rsidempdept = mysql_num_rows($rsidempdept);
	
	do {
		$insertSQL = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi, ntf_goto, id_msgcat) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString("5", "int"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($row_rsidempdept['id'], "int"),
                       GetSQLValueString('Project Code : '.$_POST['projectcode'].' '.$_POST['projecttitle'].' has been completed', "text"),
					   GetSQLValueString('../com/inputctr.php?data='.$_POST['projectcode'], "text"),
					   GetSQLValueString("2", "int"));

		mysql_select_db($database_core, $core);
		$Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	} while ($row_rsidempdept = mysql_fetch_assoc($rsidempdept));

//GIVE NOTIF INFO IF COMPLETE
	mysql_select_db($database_core, $core);
	$query_rsidempdept2 = "SELECT h_employee.id, h_employee.department, h_employee.userlevel FROM h_employee WHERE h_employee.department = 'Marketing' OR h_employee.department = 'Finance' OR h_employee.userlevel = 'branchmanager' AND userlevel <> ''";
	$rsidempdept2 = mysql_query($query_rsidempdept2, $core) or die(mysql_error());
	$row_rsidempdept2 = mysql_fetch_assoc($rsidempdept2);
	$totalRows_rsidempdept2 = mysql_num_rows($rsidempdept2);
																	
	do {
		$insertSQL2 = sprintf("INSERT INTO log_pesan (id_inisial, id_pekerjaan, id_empdept, isi) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString("5", "int"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($row_rsidempdept['id'], "int"),
                       GetSQLValueString('Project Code : '.$_POST['projectcode'].' '.$_POST['projecttitle'].' has been completed', "text"));

		mysql_select_db($database_core, $core);
		$Result2 = mysql_query($insertSQL2, $core) or die(mysql_error());
	} while ($row_rsidempdept2 = mysql_fetch_assoc($rsidempdept2));
	
	
  $insertGoTo = "view_contract.php";
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
$query_Recordset1 = sprintf("SELECT * FROM a_proj_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

<link href="../css/induk.css" rel="stylesheet" type="text/css">
<?php { include "../date.php"; include "uploadtender.php"; } ?>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="798" border="0">
    <tr>
      <td class="General">Pra Code</td>
      <td>:</td>
      <td><input name="pracode" type="text" id="pracode" value="<?php echo $row_Recordset1['pracode']; ?>" readonly="readonly" /></td>
      <td><span class="General">Type Of Order</span></td>
      <td>:</td>
      <td><select name="typeorder" id="typeorder">
        <option>Type Order</option>
        <option value="DA">DA</option>
        <option value="DS">DS</option>
        <option value="Tender">Tender</option>
        <option value="Ammend">Ammend</option>
        <option value="DO">DO</option>
        <option value="PO">PO</option>
      </select></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><input name="projectcode" type="text" class="General" id="projectcode" title="Project Code Silahkan Diisi" value="<?php echo $row_Recordset1['project_code']; ?>" readonly="readonly"/></td>
      <td><span class="General">Contract No</span></td>
      <td>:</td>
      <td><input name="contractno" type="text" class="General" id="contractno2" value="<?php echo $row_Recordset1['contractno']; ?>" /></td>
    </tr>
    <tr>
      <td width="154" class="General">Project Title</td>
      <td width="14">:</td>
      <td width="236"><textarea name="projecttitle" cols="25" id="projecttitle"><?php echo $row_Recordset1['projecttitle']; ?></textarea></td>
      <td width="144"><span class="General">Commencement Date</span></td>
      <td width="13">:</td>
      <td width="211"><input name="commdate" type="text" id="tanggal3" value="<?php echo $row_Recordset1['commdate']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">QTY / OPRS Periode</td>
      <td>:</td>
      <td><input name="qty" type="text" id="qty" value="<?php echo $row_Recordset1['qty']; ?>" /></td>
      <td><span class="General">Completion date</span></td>
      <td>:</td>
      <td><span class="General">
        <input name="completiondate" type="text" id="tanggal2" value="<?php echo $row_Recordset1['completiondate']; ?>" />
      </span></td>
    </tr>
    <tr>
      <td class="General">Owner</td>
      <td>:</td>
      <td><textarea name="customer" cols="25" readonly="readonly" id="customer"><?php echo $row_Recordset1['customer']; ?></textarea></td>
      <td><span class="General">Received Order</span></td>
      <td>:</td>
      <td><input name="receivedorder" type="text" id="tanggal1" value="<?php echo $row_Recordset1['receivedorder']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Contract Value</td>
      <td>:</td>
      <td><span class="General">
        <input name="projectvalue" type="text" class="General" id="projectvalue" value="<?php echo $row_Recordset1['projectvalue']; ?>" />
      </span></td>
      <td><span class="General">Project Status</span></td>
      <td>:</td>
      <td><span class="General">
        <select name="projectstatus" id="projectstatus" class="required" title="Pilih Status">
          <option value="">-- Pilih Project Status --</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </span></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center" colspan="6" class="General">
        <label>
          
          <input type="checkbox" name="complete" id="checkbox" />
Complete <br/>
<input type="submit" name="Save" id="Save" value="Save" />
        </label>
      <span class="hidentext">
      <input name="fileupload" type="hidden" id="fileupload" value="<?php if ($nama_file==""){echo $row_Recordset1['fileupload'];} else {echo $nama_file;} ?>" />
      </span></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($Recordset1);
?>
