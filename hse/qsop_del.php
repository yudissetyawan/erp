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

if ((isset($_GET['data'])) && ($_GET['data'] != "")) {
  	$updateSQL = sprintf("UPDATE d_org_chart SET active=%s WHERE id=%s",
                       GetSQLValueString('0', "text"),
                       GetSQLValueString($_GET['data'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

	$query_rsxdoc = "SELECT d_org_chart.id, dms.fileupload FROM d_org_chart, dms WHERE dms.idms = d_org_chart.id AND dms.inisial_pekerjaan = 'DDOC' AND d_org_chart.id = '$_GET[data]'";
	$rsxdoc = mysql_query($query_rsxdoc, $core) or die(mysql_error());
	$row_rsxdoc = mysql_fetch_assoc($rsxdoc);
	$nmfile = $row_rsxdoc['fileupload'];
	unlink("upload_deptdoc/$nmfile");
	/*
	echo "<script type='text/javascript'>alert('upload_deptdoc/$nmfile');</script>"; 
	
	onclick="return confirm('Delete Document No. <?php echo $row_rsxdoc['title']; ?> ?')"
	
	*/

  $updateGoTo = "doc_perdept_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete Organization Document</title>
</head>

<body>
</body>
</html>