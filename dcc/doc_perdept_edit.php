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
	
  $updateSQL = sprintf("UPDATE d_org_chart SET id_doccatg=%s, doc_no=%s, rev=%s, id_dept=%s, `date`=%s, title=%s, remark=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_xdoc_catg'], "int"),
                       GetSQLValueString($_POST['xdoc_no'], "text"),
                       GetSQLValueString($_POST['rev'], "text"),
					   GetSQLValueString($_POST['id_dept'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['effective_date']), "text"),
                       GetSQLValueString($_POST['xdoc_title'], "text"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  	if ($_POST['nama_fileps'] == '') {
		$nfile = $_POST['nama_fileps2'];
		$orifile = "";
	} else {
		$nfile = $_POST['nama_fileps'];
		$orifile = $_POST['nama_fileps2'];
	}
	
	/* echo "<script type='text/javascript'>alert('$nfile');</script>"; */
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
$query_rsxdoccatg = "SELECT * FROM d_orgdoc_catg";
$rsxdoccatg = mysql_query($query_rsxdoccatg, $core) or die(mysql_error());
$row_rsxdoccatg = mysql_fetch_assoc($rsxdoccatg);
$totalRows_rsxdoccatg = mysql_num_rows($rsxdoccatg);

$colname_rsxdoc = "-1";
if (isset($_GET['data'])) {
  $colname_rsxdoc = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsxdoc = sprintf("SELECT d_org_chart.*, d_orgdoc_catg.doccatg_name, dms.idms, dms.id AS id_dms, dms.fileupload FROM d_org_chart, d_orgdoc_catg, dms WHERE d_org_chart.id_doccatg = d_orgdoc_catg.id_doccatg AND dms.idms = d_org_chart.id AND dms.inisial_pekerjaan = 'DDOC' AND d_org_chart.id = %s", GetSQLValueString($colname_rsxdoc, "int"));
$rsxdoc = mysql_query($query_rsxdoc, $core) or die(mysql_error());
$row_rsxdoc = mysql_fetch_assoc($rsxdoc);
$totalRows_rsxdoc = mysql_num_rows($rsxdoc);

mysql_select_db($database_core, $core);
$query_rsdept = "SELECT h_department.id, h_department.department FROM h_department WHERE DeptActiveYN=1 ORDER BY urutan ASC";
$rsdept = mysql_query($query_rsdept, $core) or die(mysql_error());
$row_rsdept = mysql_fetch_assoc($rsdept);
$totalRows_rsdept = mysql_num_rows($rsdept);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit External Document</title>
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

<body class="General" onLoad="document.form1.xdoc_no.focus();">
<h3>Edit Department Document</h3>

<?php { include "../date.php"; include "upload_deptdoc.php"; require_once "../dateformat_funct.php"; } ?>
<table width="600">
    <tr>
      <td width="150">Attachment File</td>
      <td align="center" width="20">:</td>
      <td width="315" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
        <p>
          <input name="fileps" type="file" style="cursor:pointer;" />
          <input type="submit" name="submit" value="Upload" />
          <input type="hidden" name="nama_fileps4" id="nama_fileps4" title="nama file yg sebelumnya/sudah tersimpan di database" value="<?php echo $row_rsxdoc['fileupload']; ?>"/>
        </p>
      </form></td>
    </tr>
  </table>

<br /><br />

<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table width="600" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="150">Category</td>
        <td align="right" width="20">:</td>
        <td width="315">
        <select name="id_xdoc_catg" id="id_xdoc_catg">
          <option value="">- Select Category -</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_rsxdoccatg['id_doccatg']; ?>" <?php if ($row_rsxdoccatg['id_doccatg'] == $row_rsxdoc['id_doccatg']) { ?> selected="selected" <?php } ?>><?php echo $row_rsxdoccatg['doccatg_name']; ?></option>
          <?php
		} while ($row_rsxdoccatg = mysql_fetch_assoc($rsxdoccatg));
		  $rows = mysql_num_rows($rsxdoccatg);
		  if($rows > 0) {
			  mysql_data_seek($rsxdoccatg, 0);
			  $row_rsxdoccatg = mysql_fetch_assoc($rsxdoccatg);
		  }
		?>
        </select>
        </td>
      </tr>
      <tr>
        <td>Document No.</td>
        <td align="right">:</td>
        <td><input type="text" name="xdoc_no" value="<?php echo $row_rsxdoc['doc_no']; ?>" size="20" />
        	<input type="hidden" name="id" id="id" value="<?php echo $row_rsxdoc['id']; ?>" /></td>
      </tr>
      <tr>
        <td>Revision</td>
        <td align="right">:</td>
        <td><input type="text" name="rev" value="<?php echo $row_rsxdoc['rev']; ?>" size="3" /></td>
      </tr>
      <tr>
        <td>Title</td>
        <td align="right">:</td>
        <td><input type="text" name="xdoc_title" value="<?php echo $row_rsxdoc['title']; ?>" size="50" /></td>
      </tr>
      <tr>
        <td>Department</td>
        <td align="right">:</td>
        <td><select name="id_dept" id="id_dept">
          <option value="">- Select Department -</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_rsdept['id']; ?>" <?php if ($row_rsxdoc['id_dept'] == $row_rsdept['id']) { ?> selected="selected" <?php } ?>><?php echo $row_rsdept['department']; ?></option>
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
        <td>Effective Date</td>
        <td align="right">:</td>
        <td><input type="text" name="effective_date" id="tanggal8" value="<?php echo functddmmmyyyy($row_rsxdoc['date']); ?>" size="12" /></td>
      </tr>
      <tr>
        <td>Name of File Upload <br /> 
          <b><i>(*Please name of file that will be uploaded is correctly follow the exist of format filename)</i><b></td>
        <td align="right">:</td>
        <td><textarea name="txtfileupload" id="txtfileupload" cols="40" rows="2" disabled="disabled"><?php echo $row_rsxdoc['fileupload']; ?></textarea></td>
      </tr>
      <tr>
        <td>Remark</td>
        <td align="right">:</td>
        <td><textarea name="note" id="note" cols="40" rows="3"><?php echo $row_rsxdoc['remark']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        <td><input type="submit" name="submit" id="submit" value="Save" style="cursor:pointer" onClick="return periksa();" />
        <input type="hidden" name="id_dms" id="id_dms" value="<?php echo $row_rsxdoc['id_dms']; ?>" />
      </tr>
    </table>
    
      <input type="hidden" name="nama_fileps" id="nama_fileps" title="nama file yg akan diupload" value="<?php echo $nama_file;?>"/>
      <input type="hidden" name="nama_fileps2" id="nama_fileps2" title="nama file yg sebelumnya/sudah tersimpan di database" value="<?php echo $row_rsxdoc['fileupload']; ?>"/>
      <input type="hidden" name="idms" id="idms" value="<?php echo $row_rsxdoc['idms']; ?>" />
    <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rsxdoccatg);
	mysql_free_result($rsxdoc);
	mysql_free_result($rsdept);
?>