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
		
  $insertSQL = sprintf("INSERT INTO d_org_chart (id_doccatg, doc_no, rev, id_dept, `date`, title, remark) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_xdoc_catg'], "int"),
                       GetSQLValueString($_POST['xdoc_no'], "text"),
                       GetSQLValueString($_POST['xdoc_rev'], "text"),
                       GetSQLValueString($_POST['id_dept'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['effective_date']), "text"),
                       GetSQLValueString($_POST['xdoc_title'], "text"),
                       GetSQLValueString($_POST['note'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dms (idms, id_departemen, nocrf, inisial_pekerjaan, `date`, fileupload, keterangan) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idms'], "text"),
					   GetSQLValueString('DCC', "text"),
					   GetSQLValueString($_POST['id_xdoc_catg'], "text"),
					   GetSQLValueString('DDOC', "text"),
                       GetSQLValueString(date("Y-m-d"), "text"),
                       GetSQLValueString($_POST['nama_fileps'], "text"),
                       GetSQLValueString($_POST['xdoc_title'], "text"));

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

mysql_select_db($database_core, $core);
$query_rsdoccatg = "SELECT * FROM d_orgdoc_catg";
$rsdoccatg = mysql_query($query_rsdoccatg, $core) or die(mysql_error());
$row_rsdoccatg = mysql_fetch_assoc($rsdoccatg);
$totalRows_rsdoccatg = mysql_num_rows($rsdoccatg);

mysql_select_db($database_core, $core);
$query_rsdept = "SELECT h_department.id, h_department.department FROM h_department WHERE DeptActiveYN=1 ORDER BY h_department.urutan ASC";
$rsdept = mysql_query($query_rsdept, $core) or die(mysql_error());
$row_rsdept = mysql_fetch_assoc($rsdept);
$totalRows_rsdept = mysql_num_rows($rsdept);

$ceknomor = mysql_fetch_array(mysql_query("SELECT * FROM d_org_chart ORDER BY id DESC LIMIT 1"));
$cekQ = $ceknomor['id'];
$next = $cekQ + 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Department Document</title>
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

<body class="General" onLoad="document.form1.xdoc_no.focus();">
<h3>Input Department Document</h3>

<?php { include "../date.php"; include "upload_deptdoc.php"; }?>
<table width="600" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="120">Attachment File </td>
      <td width="20">:</td>
      <td width="307" ><form method="post" enctype="multipart/form-data" name="form" class="General" id="form">
        <input name="fileps" type="file" style="cursor:pointer;" />
        <input type="submit" name="submit" value="Upload" />
      </form></td>
    </tr>
  </table>

<br /><br />

<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table width="600" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="120">Category</td>
        <td width="20">:</td>
        <td width="307">
        <select name="id_xdoc_catg" id="id_xdoc_catg">
          <option value="">- Select Category -</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_rsdoccatg['id_doccatg']; ?>" <?php if ($row_rsdoccatg['id_doccatg'] == $_GET['data']) { ?> selected="selected" <?php } ?>><?php echo $row_rsdoccatg['doccatg_name']; ?></option>
          <?php
		} while ($row_rsdoccatg = mysql_fetch_assoc($rsdoccatg));
		  $rows = mysql_num_rows($rsdoccatg);
		  if($rows > 0) {
			  mysql_data_seek($rsdoccatg, 0);
			  $row_rsdoccatg = mysql_fetch_assoc($rsdoccatg);
		  }
		?>
        </select>
        </td>
      </tr>
      <tr>
        <td>Document No.</td>
        <td>:</td>
        <td><input type="text" name="xdoc_no" value="" size="20" /></td>
      </tr>
      <tr>
        <td>Revision</td>
        <td>:</td>
        <td><input type="text" name="xdoc_rev" value="" size="3" /></td>
      </tr>
      <tr>
        <td>Title</td>
        <td>:</td>
        <td><input type="text" name="xdoc_title" value="" size="50" /></td>
      </tr>
      <tr>
        <td>Department</td>
        <td>:</td>
        <td><select name="id_dept" id="id_dept">
          <option value="">- Select Department -</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_rsdept['id']; ?>"><?php echo $row_rsdept['department']; ?></option>
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
        <td>:</td>
        <td><input type="text" name="effective_date" id="tanggal8" value="" size="12" /></td>
      </tr>
      <tr>
        <td>Remark</td>
        <td>:</td>
        <td><textarea name="note" id="note" cols="30" rows="3"></textarea></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        <td><input type="submit" name="submit2" id="submit" value="Submit" onClick="return periksa();" /></td>
      </tr>
    </table>
    
      <input type="hidden" name="nama_fileps" id="nama_fileps" value="<?php echo $nama_file;?>"/>
      <input type="hidden" name="idms" id="idms" value="<?php echo $next; ?>" />
    <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rsdoccatg);
	mysql_free_result($rsdept);
?>