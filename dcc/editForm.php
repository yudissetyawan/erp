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
  $updateSQL = sprintf("UPDATE d_sop SET id_dept=%s, doc_no=%s, title=%s, rev=%s, efect_date=%s, catg_doc=%s, interval_review=%s, retention_time=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_dept'], "int"),
                       GetSQLValueString($_POST['doc_no'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['rev'], "text"),
                       GetSQLValueString($_POST['efect_date'], "text"),
                       GetSQLValueString($_POST['doc_no'], "text"),
                       GetSQLValueString($_POST['interval_review'], "text"),
                       GetSQLValueString($_POST['retention_time'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  // on update close window handler
  // --> by yudis
  echo "<script>
  	alert(\"Document has been saved\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
}


mysql_select_db($database_core, $core);
$query_rsdept = "SELECT * FROM h_department ORDER BY urutan ASC";
$rsdept = mysql_query($query_rsdept, $core) or die(mysql_error());
$row_rsdept = mysql_fetch_assoc($rsdept);
$totalRows_rsdept = mysql_num_rows($rsdept);

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM d_sop WHERE id = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM d_sop ORDER BY id DESC LIMIT 1"));
$cekQ = $ceknomor['id'];
/* #menghilangkan huruf */
$awalQ = $cekQ;

#ketemu angka awal(angka sebelumnya) + dengan 1
$next = $awalQ + 1;
// $nextpracode=sprintf ($next);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Form</title>

<link href="/css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<?php { include "../date.php"; include "uploadsop.php"; } ?>
<table width="800" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td width="114">Attachment File </td>
    <td width="3">:</td>
    <td class="contenthdr"><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
      <input name="fileps" type="file" style="cursor:pointer;" />
      <input type="submit" name="submit" value="Upload" />
    </form></td>
  </tr>
</table>
<br />

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="800" cellpadding="3" cellspacing="3">
    <tr>
      <td width="114">Category</td>
      <td width="3">:</td>
      <td width="357"><select name="inisial_pekerjaan" id="inisial_pekerjaan">
        <option value="WI" <?php if (isset($_GET['data'])) if ($_GET['data'] = 'WI') ?> selected="selected">Work Instruction </option>
        <option value="SOP" <?php if (isset($_GET['data'])) if ($_GET['data'] = 'SOP') ?> selected="selected">Standard Operating System</option>
        <option value="form" <?php if (isset($_GET['data'])) if ($_GET['data'] = 'form') ?> selected="selected">Form</option>
      </select></td>
    </tr>
    <tr>
      <td>Department</td>
      <td>:</td>
      <td><select name="id_dept" id="id_dept" title="<?php echo $row_Recordset1['id_dept']; ?>">
        <option value="">- Select Department -</option>
        <?php
	do {  
	?>
        <option value="<?php echo $row_rsdept['id']?>" <?php if ($row_rsdept['id'] == $row_Recordset1['id_dept']) { ?> selected="selected" <?php } ?>><?php echo $row_rsdept['department']?></option>
        <?php
	} while ($row_rsdept = mysql_fetch_assoc($rsdept));
	  $rows = mysql_num_rows($rsdept);
	  if($rows > 0) {
		  mysql_data_seek($rsdept, 0);
		  $row_rsdept = mysql_fetch_assoc($rsdept);
	  }
	?>
      </select></td>
    </tr>
    <tr>
      <td>Document No.</td>
      <td>:</td>
      <td><input type="text" name="doc_no" value="<?php echo $row_Recordset1['doc_no']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td>Title</td>
      <td>:</td>
      <td><textarea name="title" id="title" cols="50" rows="2"><?php echo $row_Recordset1['title']; ?></textarea></td>
    </tr>
    <tr>
      <td>Revision</td>
      <td>:</td>
      <td><input type="text" name="rev" value="<?php echo $row_Recordset1['rev']; ?>" size="3" /></td>
    </tr>
    <tr>
      <td>Effective Date</td>
      <td>:</td>
      <td><input type="text" name="efect_date" id="tanggal8" value="<?php echo $row_Recordset1['efect_date']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td>Interval Review (SOP &amp; WI)</td>
      <td>:</td>
      <td><input type="text" name="interval_review" value="<?php echo $row_Recordset1['interval_review']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td>Retention Time (Form)</td>
      <td>:</td>
      <td><input type="text" name="retention_time" value="<?php echo $row_Recordset1['retention_time']; ?>" size="20" /></td>
    </tr>
    <tr>
      <td valign="top"><em>Distribution to Dept. <br />
      <b>(Please ignore this field is in progress)</b></em></td>
      <td valign="top"><em>:</em></td>
      <td><table width="600" border="0">
        <tr>
          <td><em>
            <input name="tm" type="checkbox" id="tm" value="1" />
            Top Management</em></td>
          <td><em>
            <input name="hse" type="checkbox" id="hse" value="1" />
            HSE</em></td>
          <td><em>
            <input name="it" type="checkbox" id="it" value="1" />
IT</em></td>
          <td><em>
            <input type="checkbox" name="maintenance" id="maintenance" value="1"/>
Maintenance</em></td>
          <td><em>
            <input type="checkbox" name="file" id="file" value="1" />
MR/DCC</em></td>
        </tr>
        <tr>
          <td><em>
            <input name="marketing" type="checkbox" id="marketing" value="1" />
            Marketing</em></td>
          <td><em>
            <input name="engineering" type="checkbox" id="engineering" value="1" />
            Engineering</em></td>
          <td><em>
            <input name="production" type="checkbox" id="production" value="1" />
            PPIC</em></td>
          <td><em>
            <input name="hrd" type="checkbox" id="hrd" value="1" />
HRD </em></td>
          <td><em>
            <input name="siteproject" type="checkbox" id="siteproject" value="1" />
           Project</em></td>
        </tr>
        <tr>
          <td><em>
            <input name="commercial" type="checkbox" id="commercial" value="1" />
            Commercial</em></td>
          <td><em>
            <input name="procurement" type="checkbox" id="procurement" value="1"  />
            Procurement</em></td>
          <td><em>
            <input name="fabrication" type="checkbox" id="fabrication" value="1" />
            Fabrication</em></td>
          <td><em>
            <input name="acc" type="checkbox" id="acc" value="1" />
Finance &amp; Acc.</em></td>
          <td><em>
            <input name="pmc" type="checkbox" id="pmc" value="1" />
            PMC</em></td>
        </tr>
        <tr>
          <td><em>
            <input name="quality" type="checkbox" id="quality" value="1" />
            Quality </em></td>
          <td colspan="4">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><input type="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="nama_fileps" id="nama_fileps" value="<?php echo $row_Recordset1['nama_file'];?>"/>
  <input type="hidden" name="id" id="id" value="<?php echo $row_Recordset1['id'];?>"/>
  <input type="hidden" name="idms" id="idms" value="<?php echo $next;?>" />
  <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rsdept);

mysql_free_result($Recordset1);
	
?>