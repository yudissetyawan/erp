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

/* if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO s_qsop (qsop_fileupload) VALUES (%s)",
                       GetSQLValueString($_POST['nama_fileps'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
} */

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	include "../dateformat_funct.php";
	
  $insertSQL = sprintf("INSERT INTO s_qsop (loc_orplatform, project_name, qsop_no, ppha_no, qsop_title, draft_issued, sentdraft_tocvx, review_on, sentfinal_tocvx, rev_addcomment, apprv_bycvx, soclz_bybkk, qsop_upload, remark) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['loc_orplatform'], "text"),
                       GetSQLValueString($_POST['project_name'], "text"),
                       GetSQLValueString($_POST['qsop_no'], "text"),
                       GetSQLValueString($_POST['ppha_no'], "text"),
                       GetSQLValueString($_POST['qsop_title'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['draft_issued']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['sentdraft_tocvx']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['review_on']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['sentfinal_tocvx']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['rev_addcomment']), "text"),
					   GetSQLValueString(functyyyymmdd($_POST['apprv_bycvx']), "text"),
                       GetSQLValueString(functyyyymmdd($_POST['soclz_bybkk']), "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"),
					   GetSQLValueString($_POST['remark'], "text"));

  mysql_select_db($database_core, $core);
  $Result2 = mysql_query($insertSQL, $core) or die(mysql_error());
  
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
$query_rssite = "SELECT f_site_platform.PlatformID, f_site_platform.AreaID, f_site_platform.PlatformName, f_site_platform.PlatformCode FROM f_site_platform";
$rssite = mysql_query($query_rssite, $core) or die(mysql_error());
$row_rssite = mysql_fetch_assoc($rssite);
$totalRows_rssite = mysql_num_rows($rssite);

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
<title>Input SOP Project</title>

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
<h3>Input SOP Project</h3>

<?php { include "../date.php"; include "uploadqsop.php"; }?>
<table width="600" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="120">Attachment File </td>
      <td width="20">:</td>
      <td width="307" ><form method="post" enctype="multipart/form-data" name="form1" class="General" id="form1">
        <input name="fileps" type="file" style="cursor:pointer;" />
        <input type="submit" name="upload" value="Upload" />
      </form></td>
    </tr>
  </table>

<br /><br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table width="600">
    <tr>
      <td width="120">Location (Platform, or etc)</td>
      <td align="center" width="20">:</td>
      <td width="307">
        <select name="loc_orplatform" id="loc_orplatform">
          <option value="">- Select Location -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rssite['PlatformID']?>"><?php echo $row_rssite['PlatformName']?></option>
          <?php
} while ($row_rssite = mysql_fetch_assoc($rssite));
  $rows = mysql_num_rows($rssite);
  if($rows > 0) {
      mysql_data_seek($rssite, 0);
	  $row_rssite = mysql_fetch_assoc($rssite);
  }
?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Project Name</td>
      <td align="center">:</td>
      <td><input type="text" name="project_name" value="" size="32" /></td>
    </tr>
    <tr>
      <td>QSOP No.</td>
      <td align="center">:</td>
      <td><input type="text" name="qsop_no" value="" size="32" />
      <input name="qsop_id" type="hidden" id="qsop_id" value="<?php echo $next; ?>" size="5" /></td>
    </tr>
    <tr>
      <td>PPHA No.</td>
      <td align="center">:</td>
      <td><input type="text" name="ppha_no" value="" size="32" /></td>
    </tr>
    <tr>
      <td>Title of QSOP</td>
      <td align="center">:</td>
      <td><input type="text" name="qsop_title" value="" size="60" /></td>
    </tr>
    <tr>
      <td>Draft Iissued</td>
      <td align="center">:</td>
      <td><input type="text" name="draft_issued" value="" size="12" id="tanggal8" /></td>
    </tr>
    <tr>
      <td>Sent Draft to USER</td>
      <td align="center">:</td>
      <td><input type="text" name="sentdraft_tocvx" value="" size="12" id="tanggal9" /></td>
    </tr>
    <tr>
      <td>Review on</td>
      <td align="center">:</td>
      <td><input type="text" name="review_on" value="" size="12" id="tanggal10" /></td>
    </tr>
    <tr>
      <td>Sent Final to USER</td>
      <td align="center">:</td>
      <td><input type="text" name="sentfinal_tocvx" value="" size="12" id="tanggal11" /></td>
    </tr>
    <tr>
      <td>Revision (Add Comment)</td>
      <td align="center">:</td>
      <td><input type="text" name="rev_addcomment" value="" size="12" id="tanggal2" /></td>
    </tr>
    <tr>
      <td>Approved by USER</td>
      <td align="center">:</td>
      <td><input type="text" name="apprv_bycvx" value="" size="12" id="tanggal3" /></td>
    </tr>
    <tr>
      <td>Socialized by Bukaka</td>
      <td align="center">:</td>
      <td><input type="text" name="soclz_bybkk" value="" size="12" id="tanggal4" /></td>
    </tr>
    <tr>
      <td>Remark</td>
      <td align="center">:</td>
      <td><textarea name="remark" id="remark" cols="45" rows="5"></textarea></td>
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
  <input type="hidden" name="MM_insert" value="form2" />
</form>                                                                                                                                                               
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rssite);
?>