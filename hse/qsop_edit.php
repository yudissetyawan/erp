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
	require_once "../dateformat_funct.php";
	
	if ($_POST['nama_fileps'] == '') {
		$nfile = $_POST['nama_fileps2'];
		$orifile = "";
	} else {
		$nfile = $_POST['nama_fileps'];
		$orifile = $_POST['nama_fileps2'];
	}
	
  $updateSQL = sprintf("UPDATE s_qsop SET loc_orplatform=%s, project_name=%s, qsop_no=%s, ppha_no=%s, qsop_title=%s, draft_issued=%s, sentdraft_tocvx=%s, review_on=%s, sentfinal_tocvx=%s, rev_addcomment=%s, apprv_bycvx=%s, soclz_bybkk=%s, qsop_upload=%s, remark=%s WHERE qsop_id=%s",
                       GetSQLValueString($_POST['loc_orplatform'], "int"),
                       GetSQLValueString($_POST['project_name'], "text"),
                       GetSQLValueString($_POST['rev'], "text"),
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
					   GetSQLValueString($nfile, "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['qsop_id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
  
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  	if ($_POST['nama_fileps'] == '') {
		$nfile = $_POST['nama_fileps2'];
		$orifile = "";
	} else {
		$nfile = $_POST['nama_fileps'];
		$orifile = $_POST['nama_fileps2'];
	}
	
	/* echo "<script type='text/javascript'>alert('$nfile');</script>";
	
  $updateSQL = sprintf("UPDATE dms SET nocrf=%s, `date`=%s, fileupload=%s, keterangan=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_xdoc_catg'], "text"),
                       GetSQLValueString(date("Y-m-d"), "text"),
                       GetSQLValueString($nfile, "text"),
                       GetSQLValueString($_POST['xdoc_title'], "text"),
                       GetSQLValueString($_POST['id_dms'], "int"));
					   
	//Menghapus file utk replace saat edit
	//unlink("upload_deptdoc/$orifile");

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

}
*/

$colname_rsqsop = "-1";
if (isset($_GET['data'])) {
  $colname_rsqsop = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsqsop = sprintf("SELECT s_qsop.*, f_site_platform.PlatformName FROM s_qsop, f_site_platform WHERE f_site_platform.PlatformID = s_qsop.loc_orplatform AND s_qsop.qsop_id = %s", GetSQLValueString($colname_rsqsop, "int"));
$rsqsop = mysql_query($query_rsqsop, $core) or die(mysql_error());
$row_rsqsop = mysql_fetch_assoc($rsqsop);
$totalRows_rsqsop = mysql_num_rows($rsqsop);

mysql_select_db($database_core, $core);
$query_rssite = "SELECT f_site_platform.PlatformID, f_site_platform.AreaID, f_site_platform.PlatformName, f_site_platform.PlatformCode FROM f_site_platform WHERE f_site_platform.HasQSOP = 1";
$rssite = mysql_query($query_rssite, $core) or die(mysql_error());
$row_rssite = mysql_fetch_assoc($rssite);
$totalRows_rssite = mysql_num_rows($rssite);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit SOP Project</title>
<link href="/css/induk.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	function periksa() {
		if (document.form1.id_xdoc_catg.value == "") {
			alert("Select Category of Dept. Document");
			document.form1.id_xdoc_catg.focus();
			return false;
		}
	}
</script>
</head>

<body class="General" onLoad="document.form1.project_name.focus();">
<h3>Edit SOP Project</h3>

<i><font color="#FF0000">Sorry, this page still on progress...</font></i><br />

<?php { include "../date.php"; include "uploadqsop.php"; require_once "../dateformat_funct.php"; } ?>
<table width="600">
    <tr>
      <td width="150">Attachment File</td>
      <td align="center" width="20">:</td>
      <td width="315" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
        <p>
          <input name="fileps" type="file" style="cursor:pointer;" />
          <input type="submit" name="upload" value="Upload" />
          <input type="hidden" name="nama_fileps3" id="nama_fileps3" title="nama file yg sebelumnya/sudah tersimpan di database" value="<?php echo $row_rsqsop['qsop_upload']; ?>"/> <!-- utk cek file ketika upload ke drive, jika sama maka yg lama akan terhapus -->
        </p>
      </form></td>
    </tr>
  </table>

<br />

<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table width="600" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="150">Location (Platform, or etc)</td>
        <td width="20" align="center">:</td>
        <td width="315"><select name="loc_orplatform" id="loc_orplatform">
          <option value="">- Select Location -</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rssite['PlatformID']?>" <?php if ($row_rssite['PlatformID'] == $row_rsqsop['loc_orplatform']) { ?> selected="selected" <?php } ?>><?php echo $row_rssite['PlatformName']?></option>
          <?php
} while ($row_rssite = mysql_fetch_assoc($rssite));
  $rows = mysql_num_rows($rssite);
  if($rows > 0) {
      mysql_data_seek($rssite, 0);
	  $row_rssite = mysql_fetch_assoc($rssite);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td>Project Name</td>
        <td align="center">:</td>
        <td><input type="text" name="project_name" value="<?php echo $row_rsqsop['project_name']; ?>" size="32" /></td>
      </tr>
      <tr>
        <td>QSOP No.</td>
        <td align="center">:</td>
        <td><input type="text" name="qsop_no" value="<?php echo $row_rsqsop['qsop_no']; ?>" size="32" />
        <input name="qsop_id" type="hidden" id="qsop_id" value="<?php echo $row_rsqsop['qsop_id']; ?>" size="5" /></td>
      </tr>
      <tr>
        <td>PPHA No.</td>
        <td align="center">:</td>
        <td><input type="text" name="ppha_no" value="<?php echo $row_rsqsop['ppha_no']; ?>" size="32" /></td>
      </tr>
      <tr>
        <td>Title of QSOP</td>
        <td align="center">:</td>
        <td><input type="text" name="qsop_title" value="<?php echo $row_rsqsop['qsop_title']; ?>" size="60" /></td>
      </tr>
      <tr>
        <td>Draft Iissued</td>
        <td align="center">:</td>
        <td><input type="text" name="draft_issued" value="<?php echo functddmmmyyyy($row_rsqsop['draft_issued']); ?>" size="12" id="tanggal8" /></td>
      </tr>
      <tr>
        <td>Sent Draft to USER</td>
        <td align="center">:</td>
        <td><input type="text" name="sentdraft_tocvx" value="<?php echo functddmmmyyyy($row_rsqsop['sentdraft_tocvx']); ?>" size="12" id="tanggal9" /></td>
      </tr>
      <tr>
        <td>Review on</td>
        <td align="center">:</td>
        <td><input type="text" name="review_on" value="<?php echo functddmmmyyyy($row_rsqsop['review_on']); ?>" size="12" id="tanggal10" /></td>
      </tr>
      <tr>
        <td>Sent Final to USER</td>
        <td align="center">:</td>
        <td><input type="text" name="sentfinal_tocvx" value="<?php echo functddmmmyyyy($row_rsqsop['sentfinal_tocvx']); ?>" size="12" id="tanggal11" /></td>
      </tr>
      <tr>
        <td>Revision (Add Comment)</td>
        <td align="center">:</td>
        <td><input type="text" name="rev_addcomment" value="<?php echo functddmmmyyyy($row_rsqsop['rev_addcomment']); ?>" size="12" id="tanggal2" /></td>
      </tr>
      <tr>
        <td>Approved by USER</td>
        <td align="center">:</td>
        <td><input type="text" name="apprv_bycvx" value="<?php echo functddmmmyyyy($row_rsqsop['apprv_bycvx']); ?>" size="12" id="tanggal3" /></td>
      </tr>
      <tr>
        <td>Socialized by Bukaka</td>
        <td align="center">:</td>
        <td><input type="text" name="soclz_bybkk" value="<?php echo functddmmmyyyy($row_rsqsop['soclz_bybkk']); ?>" size="12" id="tanggal4" /></td>
      </tr>
      <tr>
        <td>Name of File Upload <br /></td>
        <td align="right">:</td>
        <td><textarea name="txtfileupload" id="txtfileupload" cols="40" rows="2" disabled="disabled"><?php echo $row_rsqsop['qsop_upload']; ?></textarea></td>
      </tr>
      <tr>
        <td>Remark</td>
        <td align="right">:</td>
        <td><textarea name="note" id="note" cols="40" rows="2"><?php echo $row_rsqsop['remark']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        <td><input type="submit" name="submit" id="submit" value="Save" style="cursor:pointer" onClick="return periksa();" />
      </tr>
    </table>
    
      <input type="hidden" name="nama_fileps" id="nama_fileps" title="nama file yg akan diupload" value="<?php echo $nama_file;?>"/>
      <input type="hidden" name="nama_fileps2" id="nama_fileps2" title="nama file yg sebelumnya/sudah tersimpan di database" value="<?php echo $row_rsqsop['qsop_upload']; ?>"/> <!-- utk cek ketika update -->

    <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
mysql_free_result($rsqsop);
	mysql_free_result($rssite);
?>