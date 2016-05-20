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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO p_statusengine (merk, thn_prod, no_mesin, serial_no, skid_no, lokasi, owner, engine_condition, project, kode_proyek, keterangan, status, issued_user, last_update) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['merk'], "text"),
                       GetSQLValueString($_POST['thn_prod'], "int"),
                       GetSQLValueString($_POST['no_mesin'], "text"),
                       GetSQLValueString($_POST['sn'], "text"),
                       GetSQLValueString($_POST['skid_no'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['condition'], "text"),
                       GetSQLValueString($_POST['project'], "text"),
                       GetSQLValueString($_POST['kd_project'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_SESSION['empID'], "text"),
					   GetSQLValueString(date("Y-m-d"), "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewmonoftoolsusage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_rsmontools = "SELECT * FROM p_mon_tools";
$rsmontools = mysql_query($query_rsmontools, $core) or die(mysql_error());
$row_rsmontools = mysql_fetch_assoc($rsmontools);
$totalRows_rsmontools = mysql_num_rows($rsmontools);

mysql_select_db($database_core, $core);
$query_rsmonloc = "SELECT * FROM p_mon_location";
$rsmonloc = mysql_query($query_rsmonloc, $core) or die(mysql_error());
$row_rsmonloc = mysql_fetch_assoc($rsmonloc);
$totalRows_rsmonloc = mysql_num_rows($rsmonloc);

$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM p_statusengine ORDER BY id DESC LIMIT 1"));
$cekQ = $ceknomor['id'];
$next = $cekQ + 1;
/* #menghilangkan huruf
$awalQ =substr($cekQ,3-5);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextpracode=sprintf ($next);
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry Monitoring of Tools Usage</title>
</head>

<body onLoad="document.form1.cmbtools.focus();">
<?php { include "../date.php";  include "uploads.php"; } ?>
<b>Entry Monitoring of Tools Usage</b>

<br /><br />

<form action="<?php echo $editFormAction; ?>"  method="POST" name="form1" class="General" id="form1">
  <table border="0">
    
    <tr>
      <td width="150" class="General">Description</td>
      <td width="16">:</td>
      <td width="225">
      	<select name="cmbtools">
        <?php do { ?>
        <option value="<?php echo $row_rsmontools['id_inctools']?>"> <?php echo $row_rsmontools['name_of_tools']?> <?php echo $row_rsmontools['brand']; ?> <?php echo $row_rsmontools['spec']; ?> <?php echo $row_rsmontools['descr']; ?> &nbsp; [ <?php echo $row_rsmontools['id_tools']?> ]</option>
        <?php } while ($row_rsmontools = mysql_fetch_assoc($rsmontools)); ?>
      	</select>
      </td>
    </tr>
    <tr>
      <td class="General">Outgoing Date</td>
      <td>:</td>
      <td><input name="outg_date" maxlength="4" type="text" size="15" id="tanggal8" /></td>
    </tr>
    <tr>
      <td class="General">Outgoing Qty</td>
      <td>:</td>
      <td><input type="text" name="outg_qty" id="outg_qty" size="8" /></td>
    </tr>
    <tr>
      <td class="General">Incoming Date</td>
      <td>:</td>
      <td><input type="text" name="incm_date" id="tanggal9" size="15" /></td>
    </tr>
    <tr>
      <td class="General">Incoming Qty</td>
      <td>:</td>
      <td><input type="text" name="incm_qty" id="incm_qty" size="8" /></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td>
      	<select name="cmbloc" id="cmbloc">
        <?php do { ?>
        <option value="<?php echo $row_rsmonloc['id_location']?>"> <?php echo $row_rsmonloc['location_of_tools']?> <?php echo $row_rsmonloc['location_desc']?></option>
        <?php } while ($row_rsmonloc = mysql_fetch_assoc($rsmonloc)); ?>
      	</select>
      </td>
    </tr>
    <tr>
      <td class="General">TB / SCM / RC</td>
      <td>:</td>
      <td><input type="text" name="tborscmorrc" id="tborscmorrc" /></td>
    </tr>
    <tr>
      <td class="General">Project Code / User</td>
      <td>:</td>
      <td><input type="text" name="proj_code" id="proj_code" /></td>
    </tr>
    <tr>
      <td class="General">Remarks</td>
      <td>:</td>
      <td><textarea cols="30" name="remarks" id="remarks"></textarea></td>
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
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
	mysql_free_result($rsmontools);
	mysql_free_result($rsmonloc);
?>