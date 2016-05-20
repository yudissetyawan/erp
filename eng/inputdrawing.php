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
  $insertSQL = sprintf("INSERT INTO e_drawing_file (location, title, drawingno, revisi) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['drawingno'], "text"),
                       GetSQLValueString($_POST['revisi'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewdrawing.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form1").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body class="General">
<p>Input Drawing file</p>
<form action="inputdrawing.php" method="post"
enctype="multipart/form-data">
  <label for="file">Filename:</label>
  <input type="file" name="file" id="file" />
  <input type="submit" name="submit" value="Upload" />
</form>
<?php

  
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/drawing/" . $_FILES["file"]["name"]);
      echo "File has ben saved in : " . "upload/drawing/" . $_FILES["file"]["name"] . " Directory";
      
?> 

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="543" border="0">
    <tr>
      <td width="93">Title</td>
      <td width="27">:</td>
      <td width="409"><input type="text" name="title" id="title" class="required" title="Title is required" /></td>
    </tr>
    <tr>
      <td>Drawing No</td>
      <td>:</td>
      <td><input type="text" name="drawingno" id="drawingno" class="required" title="Drawing no is required" /></td>
    </tr>
    <tr>
      <td>Revisi</td>
      <td>:</td>
      <td><input type="text" name="revisi" id="revisi" class="required" title="Revisi is required" /></td>
    </tr>
    <tr>
      <td><input name="location" type="hidden" id="location" value=<?php echo $_FILES["file"]["name"]; ?> /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit2" id="submit" value="Submit" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>