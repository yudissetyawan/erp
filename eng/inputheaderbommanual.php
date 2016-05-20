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
  $insertSQL = sprintf("INSERT INTO e_header_bom (drawingno, createdby, location, customer, projectcode, productioncode, revision, checkedby, approvedby, type, bomfile) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['drawingno'], "text"),
                       GetSQLValueString($_POST['createdby'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['productioncode'], "text"),
                       GetSQLValueString($_POST['revision'], "text"),
                       GetSQLValueString($_POST['checkedby'], "text"),
                       GetSQLValueString($_POST['approvedby'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['bomfile'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewheaderbom.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO e_bom_file (localtion) VALUES (%s)",
                       GetSQLValueString($_POST['location2'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "inputheaderbommanual.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM a_customer ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_employee";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM a_proj_code";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT * FROM a_production_code";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_core, $core);
$query_Recordset5 = "SELECT * FROM e_drawing_file";
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_core, $core);
$query_Recordset6 = "SELECT * FROM e_bom_file";
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);
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
<form name="form" method="POST"
enctype="multipart/form-data">
  <label for="file">Filename:</label>
  <input type="file" name="file" id="file" />
  <input type="submit" name="submit" value="Upload" />
</form>
<p>
  <?php

  
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/BOM/" . $_FILES["file"]["name"]);
      echo "File has ben saved in : " . "upload/BOM/" . $_FILES["file"]["name"] . " Directory";
      
?> 
</p>
<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <input type="submit" name="save2" id="save2" value="Save BOM to Database" />
  <input name="location2" type="hidden" id="location2" value="<?php echo $_FILES["file"]["name"]; ?>" />
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<p>&nbsp; </p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="1022" border="0">
    <tr>
      <td width="152">Drawing Number</td>
      <td width="22">:</td>
      <td width="834"><select name="drawingno" id="drawingno" class="required" title="Please Select Drawing No">
      <option value="">Drawing Number</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset5['id'] ?>"><?php echo $row_Recordset5['drawingno'] ?></option>
        <?php
} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
  $rows = mysql_num_rows($Recordset5);
  if($rows > 0) {
      mysql_data_seek($Recordset5, 0);
	  $row_Recordset5 = mysql_fetch_assoc($Recordset5);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Created By</td>
      <td>:</td>
      <td><select name="createdby" id="createdby" class="required" title="Please select Created By">
      <option value="">Created By</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id'] ?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Location</td>
      <td>:</td>
      <td><input type="text" name="location" id="location" class="required" title="Location is required" /></td>
    </tr>
    <tr>
      <td>Customer</td>
      <td>:</td>
      <td><select name="customer" id="customer" class="required" title="Please select Customer">
      <option value="">Customer</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset1['id'] ?>"><?php echo $row_Recordset1['customername'] ?></option>
        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Project Code</td>
      <td>:</td>
      <td><select name="projectcode" id="projectcode" class="rquired" title="Project Code">
      <option value="">Proejct Code</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset3['id'] ?>"><?php echo $row_Recordset3['project_code'] ?></option>
        <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Production Code</td>
      <td>:</td>
      <td><select name="productioncode" id="productioncode" class="required" title="Please select production code">
      <option value="">Production Code</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset4['id'] ?>"><?php echo $row_Recordset4['productioncode'] ?></option>
        <?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Revision</td>
      <td>:</td>
      <td><input type="text" name="revision" id="revision" class="required" title="Revision is required" /></td>
    </tr>
    <tr>
      <td>Checked By</td>
      <td>:</td>
      <td><select name="checkedby" id="checkedby" class="required" title="Please select Checked by">
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id'] ?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Approved By</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby" class="required" title="Plese select Approved By">
      <option value="">Approved By</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id'] ?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>File Bom</td>
      <td>:</td>
      <td><select name="bomfile" id="bomfile" class="required" title="Please select BOM File">
      <option value="">BOM File</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset6['id'] ?>"><?php echo $row_Recordset6['localtion'] ?></option>
        <?php
} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));
  $rows = mysql_num_rows($Recordset6);
  if($rows > 0) {
      mysql_data_seek($Recordset6, 0);
	  $row_Recordset6 = mysql_fetch_assoc($Recordset6);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td><input name="type" type="hidden" id="type" value="1" /></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="save" id="save" value="Save" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);
?>
