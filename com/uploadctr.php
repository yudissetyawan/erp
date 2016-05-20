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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO c_ctr (fileupload) VALUES (%s)",
                       GetSQLValueString($_POST['filectr'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}
 {include "prosesupload.php";}?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form" class="General">
      <table  border="0" cellspacing="0" cellpadding="2" class="General">
      <tr>
        <td width="128" >
Attachment File</td>
        <td width="6">:</td>
        <td width="382"><input name="filectr" id="filectr" type="file" style="cursor:pointer;" />
        <input type="submit" name="submit1" id="submit1" value="Upload" /></td>
      </tr>
    </table>
      <input type="hidden" name="MM_insert" value="form" />
    </form>