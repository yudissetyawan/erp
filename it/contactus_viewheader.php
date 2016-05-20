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

mysql_select_db($database_core, $core);
$query_contact_us = "SELECT contact_us.*, h_employee.firstname, h_employee.midlename, h_employee.lastname, h_employee.nik FROM contact_us, h_employee WHERE contact_us.name = h_employee.id ORDER BY contact_us.timeofcomment DESC";
$contact_us = mysql_query($query_contact_us, $core) or die(mysql_error());
$row_contact_us = mysql_fetch_assoc($contact_us);
$totalRows_contact_us = mysql_num_rows($contact_us);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body>
<table width="837" height="61" border="0">
  <tr class="tabel_header">
    <td width="17">No</td>
    <td width="211">Name</td>
    <td width="111">Email</td>
    <td width="86">Phone Number</td>
    <td width="170">Type of Comment</td>
    <td width="170">Time of Comment</td>
    <td width="42">Respond</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body"><?php $a=$a+1; ?>
      <td align="center"><?php echo $a; ?></td>
      <td><a href="#" onclick="MM_openBrWindow('contactus_viewcore.php?data=<?php echo $row_contact_us['id']; ?>','','scrollbars=yes,width=800,height=400')"><?php echo $row_contact_us['nik']; ?> - <?php echo $row_contact_us['firstname']; ?> <?php echo $row_contact_us['midlename']; ?> <?php echo $row_contact_us['lastname']; ?></a></td>
      <td><?php echo $row_contact_us['email']; ?></td>
      <td><?php echo $row_contact_us['ph']; ?></td>
      <td align="center"><?php
if($row_contact_us['type']=='1'){
echo "Information";
}
elseif ($row_contact_us['type']=='2'){
echo "Suggestion";
}
elseif ($row_contact_us['type']=='3'){
echo "Complaints";
} 
?></td>
      <td><?php echo $row_contact_us['timeofcomment']; ?></td>
      <td align="center"><?php if ($row_contact_us['status_respond']==1) { echo "<img src='../images/select(1).png' width='15' height='15' />"; } 
		  else { 
		  echo "<a href='contactus_respond.php?data= $row_contact_us[id]'>Respond</a>";
		  }?></td>
    </tr>
    <?php } while ($row_contact_us = mysql_fetch_assoc($contact_us)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($contact_us);
?>
