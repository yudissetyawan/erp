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

$colname_rsnews = "-1";
if (isset($_GET['data'])) {
  $colname_rsnews = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_rsnews = sprintf("SELECT i_news.*, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.department FROM i_news, h_employee WHERE h_employee.id = i_news.issued_by AND i_news.id = %s", GetSQLValueString($colname_rsnews, "int"));
$rsnews = mysql_query($query_rsnews, $core) or die(mysql_error());
$row_rsnews = mysql_fetch_assoc($rsnews);
$totalRows_rsnews = mysql_num_rows($rsnews);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bukaka News</title>
<link rel="stylesheet" type="text/css" href="/css/induk.css" />
<link href="/css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/table.css" rel="stylesheet" type="text/css">
</head>

<body class="General">

<table width="800" class="table" id="celebs" align="center">
<thead>
  <tr class="tabel_header" height="40">
    <td width="800" colspan="2">BUKAKA NEWS</td>
    </tr>
 </thead>
 <tbody> 
  <?php
  { require_once "../dateformat_funct.php"; } ?>
    <tr class="tabel_body">
		<td valign="middle">
			<b><?php echo $row_rsnews['news_title']; ?></b>
		</td>
      
		<td align="right" width="50">
			<a href="news_edit.php?data=<?php echo $row_rsnews['id']; ?>"><img src="../images/icedit.png" width="17" height="17"></a> &nbsp;&nbsp;
            <a href="news_deactivate.php?data=<?php echo $row_rsnews['id']; ?>" onclick="return confirm('Delete News about <?php echo $row_rsnews['news_title']; ?> on <?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?> ?')"><img src="../images/icdel.png" width="17" height="17"></a>
		</td>
    </tr>
    
    <tr class="tabel_body">
		<td colspan="2" align="justify">
        	by <i><?php echo $row_rsnews['firstname']; ?> <?php echo $row_rsnews['midlename']; ?> <?php echo $row_rsnews['lastname']; ?></i> at Department <?php echo $row_rsnews['department']; ?>
            <br />
            
            on <?php echo $row_rsnews['day_of_news']; ?>, <?php echo functddmmmyyyy(substr($row_rsnews['news_datetime'], 0, 10)); ?> <?php echo substr($row_rsnews['news_datetime'], -8); ?>
            <br /><br />
            
            <?php echo $row_rsnews['news_content']; ?>
		</td>
	</tr> 
 </tbody>
</table>

<br />
<p><a href="news_view.php" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-arrowthick-1-w"></span>Back</a></p>

</body>
</html>
<?php
	mysql_free_result($rsnews);
?>