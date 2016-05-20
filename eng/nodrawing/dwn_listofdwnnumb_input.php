<?php require_once('../../Connections/core.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO e_dwnlistofnodwn (id_groupwork, drawing_no, `description`, handle_by, rev_0, rev_1, rev_2, rev_3, rev_4, owner, location, proj_code, binder_code) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_groupwork'], "int"),
                       GetSQLValueString($_POST['drawing_no'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['handle_by'], "text"),
                       GetSQLValueString($_POST['rev_0'], "date"),
                       GetSQLValueString($_POST['rev_1'], "date"),
                       GetSQLValueString($_POST['rev_2'], "date"),
                       GetSQLValueString($_POST['rev_3'], "date"),
                       GetSQLValueString($_POST['rev_4'], "date"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['proj_code'], "text"),
                       GetSQLValueString($_POST['binder_code'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "dwn_listofdwnnumb.php?data=" . $_GET['data'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_eng_personel = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'engineering' AND h_employee.code = 'K'";
$eng_personel = mysql_query($query_eng_personel, $core) or die(mysql_error());
$row_eng_personel = mysql_fetch_assoc($eng_personel);
$totalRows_eng_personel = mysql_num_rows($eng_personel);mysql_select_db($database_core, $core);
$query_eng_personel = "SELECT id, firstname, midlename, lastname FROM h_employee WHERE department = 'engineering'";
$eng_personel = mysql_query($query_eng_personel, $core) or die(mysql_error());
$row_eng_personel = mysql_fetch_assoc($eng_personel);
$totalRows_eng_personel = mysql_num_rows($eng_personel);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>

</head>

<body>
<?php { include "date.php";} ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td>Drawing No</td>
      <td>:</td>
      <td><input type="text" name="drawing_no" value="" size="32" /></td>
      <td>Rev 3</td>
      <td>:</td>
      <td><input type="text" name="rev_3" value="" size="32" id="tanggal4" /></td>
    </tr>
    <tr valign="baseline">
      <td>Description</td>
      <td>:</td>
      <td><input type="text" name="description" value="" size="32" /></td>
      <td>Rev 4</td>
      <td>:</td>
      <td><input type="text" name="rev_4" value="" size="32" id="tanggal5" /></td>
    </tr>
    <tr valign="baseline">
      <td>Handle By</td>
      <td>:</td>
      <td><label for="handle_by"></label>
        <select name="handle_by" id="handle_by">
        <option value="">--Handle By--</option>
          <?php
do {  
?>
          <option value="<?php echo $row_eng_personel['id']?>"><?php echo $row_eng_personel['firstname']?> <?php echo $row_eng_personel['midlename']; ?> <?php echo $row_eng_personel['lastname']; ?></option>
          <?php
} while ($row_eng_personel = mysql_fetch_assoc($eng_personel));
  $rows = mysql_num_rows($eng_personel);
  if($rows > 0) {
      mysql_data_seek($eng_personel, 0);
	  $row_eng_personel = mysql_fetch_assoc($eng_personel);
  }
?>
      </select></td>
      <td>Owner</td>
      <td>:</td>
      <td><input type="text" name="owner" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td>Rev 0</td>
      <td>:</td>
      <td><input type="text" name="rev_0" id="tanggal1" value="" size="32" /></td>
      <td>Location</td>
      <td>:</td>
      <td><input type="text" name="location" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td>Rev 1</td>
      <td>:</td>
      <td><input type="text" name="rev_1" value="" id="tanggal2" size="32" /></td>
      <td>Project Code</td>
      <td>:</td>
      <td><input type="text" name="proj_code" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td>Rev 2</td>
      <td>:</td>
      <td><input type="text" name="rev_2" value="" id="tanggal3" size="32" /></td>
      <td>Binder Code</td>
      <td>:</td>
      <td><input type="text" name="binder_code" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center"><label for="id_groupwork"></label>
      <input type="hidden" name="id_groupwork" id="id_groupwork" value="<?php echo $_GET['data']; ?>" />        <input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>
  <a href="dwn_listofdwnnumb.php?data=<?php echo $_GET['data']; ?>"><input type="submit" name="cancel" id="cancel" value="CANCEL" /> </a>
</p>
</body>
</html>
<?php
mysql_free_result($eng_personel);
?>
