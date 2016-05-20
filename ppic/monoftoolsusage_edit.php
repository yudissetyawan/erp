<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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
	$updateSQL = sprintf("UPDATE p_statusengine SET merk=%s, thn_prod=%s, no_mesin=%s, serial_no=%s, skid_no=%s, lokasi=%s, owner=%s, engine_condition=%s, project=%s, kode_proyek=%s, keterangan=%s, status=%s, issued_user=%s, last_update=%s WHERE id=%s",
                       GetSQLValueString($_POST['merk'], "text"),
                       GetSQLValueString($_POST['thn_prod'], "int"),
                       GetSQLValueString($_POST['no_mesin'], "text"),
                       GetSQLValueString($_POST['sn'], "text"),
                       GetSQLValueString($_POST['skid_no'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['engine_condition'], "text"),
                       GetSQLValueString($_POST['project'], "text"),
                       GetSQLValueString($_POST['kd_project'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_SESSION['empID'], "text"),
					   GetSQLValueString(date("Y-m-d"), "text"),
					   GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "status_welding_engine.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsmonoftoolsusage = "-1";
if (isset($_GET['data'])) {
  $colname_rsmonoftoolsusage = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsmonoftoolsusage = sprintf("SELECT * FROM p_monoftoolsusage WHERE id_usage = %s", GetSQLValueString($colname_rsmonoftoolsusage, "int"));
$rsmonoftoolsusage = mysql_query($query_rsmonoftoolsusage, $core) or die(mysql_error());
$row_rsmonoftoolsusage = mysql_fetch_assoc($rsmonoftoolsusage);
$totalRows_rsmonoftoolsusage = mysql_num_rows($rsmonoftoolsusage);

$vusr = $row_rsmonoftoolsusage['issued_user'];
mysql_select_db($database_core, $core);
$query_rsusr = "SELECT h_employee.firstname AS fname, h_employee.midlename AS mname, h_employee.lastname AS lname FROM h_employee WHERE h_employee.id = '$vusr'";
$rsusr = mysql_query($query_rsusr, $core) or die(mysql_error());
$row_rsusr = mysql_fetch_assoc($rsusr);
$totalRows_rsusr = mysql_num_rows($rsusr);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Monitoring of Tools Usage</title>
</head>

<body>
<?php { include "uploads.php"; } ?>
<b>Edit Monitoring of Tools Usage</b>
<br><br>

<form action="<?php echo $editFormAction; ?>"  method="POST" name="form1" class="General" id="form1">
  <table border="0">
    
    <tr>
      <td width="150" class="General">Description</td>
      <td width="16">:</td>
      <td width="225">
      <?php
	  	//$vidusg = $row_rsmonoftoolsusage['id_usage'];
		//WHERE id_inctools <> '$vidusg'
		mysql_select_db($database_core, $core);
		$query_rsmontools = "SELECT * FROM p_mon_tools";
		$rsmontools = mysql_query($query_rsmontools, $core) or die(mysql_error());
		$row_rsmontools = mysql_fetch_assoc($rsmontools);
		$totalRows_rsmontools = mysql_num_rows($rsmontools);
	  ?>
      <select name="cmbtools">
        <?php do { ?>
        <option value="<?php echo $row_rsmontools['id_inctools']?>" <?php if ($row_rsmontools['id_inctools'] == $row_rsmonoftoolsusage['id_inctools']) { ?> selected="selected" <?php } ?>>
			<?php echo $row_rsmontools['name_of_tools']?> <?php echo $row_rsmontools['brand']; ?> <?php echo $row_rsmontools['spec']; ?> <?php echo $row_rsmontools['descr']; ?> &nbsp; [ <?php echo $row_rsmontools['id_tools']?> ]
        </option>
        <?php } while ($row_rsmontools = mysql_fetch_assoc($rsmontools)); ?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Outgoing Date</td>
      <td>:</td>
      <td><input name="outg_date" type="text" id="tanggal8" value="<?php echo $row_rsmonoftoolsusage['outgoing_date']; ?>" size="15" maxlength="4" /></td>
    </tr>
    <tr>
      <td class="General">Outgoing Qty</td>
      <td>:</td>
      <td><input name="outg_qty" type="text" id="outg_qty" value="<?php echo $row_rsmonoftoolsusage['outgoing_qty']; ?>" size="8" /></td>
    </tr>
    <tr>
      <td class="General">Incoming Date</td>
      <td>:</td>
      <td><input name="incm_date" type="text" id="tanggal9" value="<?php echo $row_rsmonoftoolsusage['incoming_date']; ?>" size="15" /></td>
    </tr>
    <tr>
      <td class="General">Incoming Qty</td>
      <td>:</td>
      <td><input name="incm_qty" type="text" id="incm_qty" value="<?php echo $row_rsmonoftoolsusage['incoming_qty']; ?>" size="8" /></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td>
      <?php
	  	//WHERE id_location <> '$vidusg'
	  	mysql_select_db($database_core, $core);
		$query_rsmonloc = "SELECT * FROM p_mon_location";
		$rsmonloc = mysql_query($query_rsmonloc, $core) or die(mysql_error());
		$row_rsmonloc = mysql_fetch_assoc($rsmonloc);
		$totalRows_rsmonloc = mysql_num_rows($rsmonloc);
	  ?>
      	<select name="cmbloc" id="cmbloc">
        <?php do { ?>
        <option value="<?php echo $row_rsmonloc['id_location']?>" <?php if ($row_rsmonloc['id_location'] == $row_rsmonoftoolsusage['id_location']) { ?> selected="selected" <?php } ?>>
			<?php echo $row_rsmonloc['location_of_tools']?> <?php echo $row_rsmonloc['location_desc']?>
		</option>
        <?php } while ($row_rsmonloc = mysql_fetch_assoc($rsmonloc)); ?>
      	</select>
      </td>
    </tr>
    <tr>
      <td class="General">TB / SCM / RC</td>
      <td>:</td>
      <td><input name="tborscmorrc" type="text" id="tborscmorrc" value="<?php echo $row_rsmonoftoolsusage['TBorSCMorRC']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Project Code / User</td>
      <td>:</td>
      <td><input name="proj_code" type="text" id="proj_code" value="<?php echo $row_rsmonoftoolsusage['proj_code']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Remarks</td>
      <td>:</td>
      <td><textarea cols="30" name="remarks" id="remarks"><?php echo $row_rsmonoftoolsusage['remarks']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="SUBMIT" id="SUBMIT" value="Save" /></td>
    </tr>
  </table>
  <p>
    <input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_departemen" type="hidden" id="id_departemen" value="PPIC"/>
    <label for="idms"></label>
    <input type="hidden" name="idms" id="idms" value="<?php echo $nextpracode; ?>" />
  </p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($rsmonoftoolsusage);
	mysql_free_result($rsusr);
?>