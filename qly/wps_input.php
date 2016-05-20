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
	include "../dateformat_funct.php";
	
  $insertSQL = sprintf("INSERT INTO q_wps (wps_no, supp_pqrno, wps_std_code, wps_rev, wps_date, welding_process, welding_type, wps_remark) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['wps_no'], "text"),
                       GetSQLValueString($_POST['supp_pqrno'], "text"),
                       GetSQLValueString($_POST['wps_std_code'], "text"),
                       GetSQLValueString($_POST['wps_rev'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['wps_date']), "text"),
                       GetSQLValueString($_POST['welding_process'], "text"),
                       GetSQLValueString($_POST['welding_type'], "text"),
                       GetSQLValueString($_POST['wps_remark'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
    echo "<script>
  	alert(\"Document has been saved\");
	self.close();
	
	window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>";
}

/*
$ceknomor = mysql_fetch_array(mysql_query("SELECT qsop_id, qsop_title FROM s_qsop ORDER BY qsop_id DESC LIMIT 1"));
$cekQ = $ceknomor['qsop_id'];
$next = $cekQ + 1;
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input WPS</title>

<link href="/css/induk.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	function periksa() {
		if (document.form1.id_xdoc_catg.value == "") {
			alert("Select Category of Department Document");
			document.form1.id_xdoc_catg.focus();
			return false;
		} else if (document.form1.id_dept.value == "") {
			alert("Select Department");
			document.form1.id_xdoc_catg.focus();
			return false;
		} else if (document.form1.xdoc_no.value == "") {
			alert("Fill Document No. !");
			document.form1.xdoc_no.focus();
			return false;
		} else if (document.form1.xdoc_rev.value == "") {
			alert("Fill Revision of Document !");
			document.form1.xdoc_no.focus();
			return false;
		} else if (document.form1.xdoc_title.value == "") {
			alert("Fill Title of Document");
			document.form1.xdoc_title.focus();
			return false;
		} else if (document.form1.effective_date.value == "") {
			alert("Fill Effective Date of Document");
			document.form1.effective_date.focus();
			return false;
		}
	}
</script>
</head>

<body class="General" onLoad="document.form1.qsop_no.focus();">
<h3>Input WPS</h3>

<?php { include "../date.php"; include "uploadqsop.php"; }?>
<table width="600" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="120">Attachment File </td>
      <td width="20">:</td>
      <td width="307" ><form method="post" enctype="multipart/form-data" name="form2" class="General" id="form2">
        <input name="fileps" type="file" style="cursor:pointer;" />
        <input type="submit" name="upload" value="Upload" />
      </form></td>
    </tr>
  </table>

<br /><br />
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="600">
    <tr>
      <td width="120">WPS No.</td>
      <td width="20" align="center">:</td>
      <td width="307"><input type="text" name="wps_no" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Supporting PQR No.</td>
      <td align="center">:</td>
      <td><input type="text" name="supp_pqrno" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Standard / Code</td>
      <td align="center">:</td>
      <td><input type="text" name="wps_std_code" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Revision</td>
      <td align="center">:</td>
      <td><input type="text" name="wps_rev" value="" size="2" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td align="center">:</td>
      <td><input type="text" name="wps_date" value="" size="12" id="tanggal8" /></td>
    </tr>
    <tr>
      <td>Welding Process</td>
      <td align="center">:</td>
      <td><input type="text" name="welding_process" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Type</td>
      <td align="center">:</td>
      <td>
      <select name="welding_type" id="welding_type">
        <option value="">- Select Welding Type -</option>
        <option value="Automatic">Automatic</option>
        <option value="Manual">Manual</option>
        <option value="Machine">Machine</option>
        <option value="Semi Auto">Semi Auto</option>
      </select>
      </td>
    </tr>
    <tr>
      <td>Remark</td>
      <td align="center">:</td>
      <td><textarea name="wps_remark" id="remark" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><input type="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="nama_fileps" id="nama_fileps" value="<?php echo $nama_file;?>"/>
  <input type="hidden" name="MM_insert" value="form1" />
</form>                                                                                                                                
</body>
</html>