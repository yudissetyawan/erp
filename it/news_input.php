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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO i_news (news_title, day_of_news, news_content, issued_by) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['day_of_news'], "text"),
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($_POST['issued_by'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "news_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input News</title>
<link rel="stylesheet" type="text/css" href="../css/induk.css" />
</head>

<body class="General">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="middle">
      <td colspan="3" align="center" bgcolor="#8DB4E3"><h3>FORM ADD NEWS</h3></td>
    </tr>
    <tr valign="middle">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td width="100">Title of News</td>
      <td width="20">:</td>
      <td><input type="text" name="news_title" value="" size="80" /></td>
    </tr>
    <tr valign="middle">
      <td>Date</td>
      <td>:</td>
      <td><input type="text" name="day_of_news" size="10" value="<?php echo date("D"); ?>" readonly="readonly" style="border:thin"/>,
          <input type="text" name="news_datetime" size="32" value="<?php echo date("d M Y H:m:s"); ?>" readonly="readonly" style="border:thin"/></td>
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
      <textarea name="news_content" id="news_content" cols="75" rows="10"></textarea></td>
    </tr>
    <tr>
      <td colspan="3"><input type="hidden" name="issued_by" id="issued_by" value="<?php echo $_SESSION['empID']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="right">&nbsp;</td>
      <td align="right"><input type="submit" value="Submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
	mysql_free_result($rsdept);
?>