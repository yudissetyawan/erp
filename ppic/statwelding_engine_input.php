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

  $insertGoTo = "status_welding_engine.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
<title>Entry Status of Welding Engine</title>
</head>

<body onLoad="document.form1.merk.focus();">
<?php { include "uploads.php"; } ?>
<b>Entry Status of Welding Engine</b><br><br>

<table border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3"><input type="hidden" name="idmsps" id="idmsps" value="<?php echo $row_recordset1['idms'];?>" />
  </tr>
  <tr>
    <td width="181"><b>Attachment File</b></td>
    <td width="17">:</td>
    <td><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit1" value="Upload" />
    </form></td>
  </tr>
</table>
<br /><br />

<form action="<?php echo $editFormAction; ?>"  method="POST" name="form1" class="General" id="form1">
  <table border="0">
    
    <tr>
      <td width="184" class="General">Brand</td>
      <td width="16">:</td>
      <td width="337"><label for="merk"></label>
      <input type="text" name="merk" id="merk" /></td>
    </tr>
    <tr>
      <td class="General">Year of Production</td>
      <td>:</td>
      <td>
      <select name="thn_prod" id="thn_prod" class="General">
        <?php for ($i = 1998; $i <= date("Y"); $i++) {
            echo '<option value='.$i.'>'.$i.'</option>';
        } ?>
		</select>
		</td>
    </tr>
    <tr>
      <td class="General">Engine No.</td>
      <td>:</td>
      <td><input type="text" name="no_mesin" id="no_mesin" /></td>
    </tr>
    <tr>
      <td class="General">Serial No. </td>
      <td>:</td>
      <td><input type="text" name="sn" id="sn" /></td>
    </tr>
    <tr>
      <td class="General">SKID No. </td>
      <td>:</td>
      <td><input type="text" name="skid_no" id="skid_no" /></td>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td><input type="text" name="lokasi" id="lokasi" /></td>
    </tr>
    <tr>
      <td class="General">Owner</td>
      <td>:</td>
      <td><input type="text" name="owner" id="owner" /></td>
    </tr>
    <tr>
      <td class="General">Condition</td>
      <td>:</td>
      <td><input type="text" name="condition" id="condition" /></td>
    </tr>
    <tr>
      <td class="General">Project</td>
      <td>:</td>
      <td><input type="text" name="project" id="project" /></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><input type="text" name="kd_project" id="kd_project" /></td>
    </tr>
    <tr>
      <td class="General">Notes</td>
      <td>:</td>
      <td><textarea cols="40" name="keterangan" id="keterangan"></textarea></td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Status</td>
      <td>:</td>
      <td valign="middle"><input type="radio" name="status" id="Rental" value="Rental" /><label for="Rental"><b>Rental</b></label>
      	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	<input type="radio" name="status" id="Bukaka Property" value="Bukaka Property" /><label for="Property"><b>Property of PT. Bukaka Teknik Utama</b></label></td>
    </tr>
    <tr>
      <td colspan="3" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" class="General"><input type="submit" name="SUBMIT" id="SUBMIT" value="Save" /></td>
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

