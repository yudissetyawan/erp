<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE i_news SET news_title=%s, day_of_news=%s, news_content=%s, issued_by=%s WHERE id=%s",
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['day_of_news'], "text"),
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($_POST['issued_by'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "news_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsnews = "-1";
if (isset($_GET['data'])) {
  $colname_rsnews = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsnews = sprintf("SELECT i_news.*, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM i_news, h_employee WHERE i_news.id = %s AND h_employee.id = i_news.issued_by", GetSQLValueString($colname_rsnews, "int"));
$rsnews = mysql_query($query_rsnews, $core) or die(mysql_error());
$row_rsnews = mysql_fetch_assoc($rsnews);
$totalRows_rsnews = mysql_num_rows($rsnews);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of User Manual</title>
<link rel="stylesheet" type="text/css" href="../css/induk.css" />
</head>

<body class="General">
<?php { require_once "../dateformat_funct.php"; } ?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">
    <tr valign="middle">
      <td colspan="3" align="center" bgcolor="#8DB4E3"><h3>FORM UPDATE NEWS</h3></td>
    </tr>
    <tr valign="middle">
      <td><input type="hidden" name="id" id="id" value="<?php echo $_GET['data']; ?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td width="100">Title of News</td>
      <td width="20">:</td>
      <td><input type="text" name="news_title" value="<?php echo $row_rsnews['news_title']; ?>" size="80" /></td>
    </tr>
    <tr valign="middle">
      <td>Date</td>
      <td>:</td>
      <td><input type="text" name="day_of_news" size="3" value="<?php echo $row_rsnews['day_of_news']; ?>" readonly="readonly" style="border:thin"/>,
      <input type="text" name="news_datetime" size="32" value="<?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?>" readonly="readonly" style="border:thin"/>
      <input type="hidden" name="day_of_news" size="3" value="<?php echo date("D"); ?>" readonly="readonly" style="border:thin"/></td>
    </tr>
    <tr valign="middle">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle" height="30">
      <td colspan="3" align="center" bgcolor="#8DB4E3"><b>C O N T E N T S</b></td>
    </tr>
    <tr valign="middle">
      <td colspan="3" align="center">
      <textarea name="news_content" id="news_content" cols="75" rows="10"><?php echo $row_rsnews['news_content']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td>Issued by</td>
      <td>:</td>
      <td><input type="text" name="issued_by2" size="32" value="<?php echo $row_rsnews['firstname']; ?> <?php echo $row_rsnews['midlename']; ?> <?php echo $row_rsnews['lastname']; ?>" readonly="readonly" style="border:thin"/>
      <input type="hidden" name="issued_by" id="issued_by" value="<?php echo $_SESSION['empID']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="right">&nbsp;</td>
      <td align="right"><input type="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rsnews);
?>