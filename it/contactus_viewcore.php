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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT contact_us.*, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM contact_us, h_employee WHERE contact_us.id = %s AND h_employee.id = contact_us.empID", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h3 { font-size:14px; font-weight:bold; }
	p {font-size:12px; font-weight:bold;}
	input { padding: 1px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
</style>

</head>

<body>
<table align="center" width="792" border="0">
  <tr class="tabel_header">
    <td colspan="7"><p>This Comment is about 
      	<?php
                    	if($row_Recordset1['type']=='1'){
							echo "Information";
						}
						elseif ($row_Recordset1['type']=='2'){
							echo "Suggestion";
						}
						elseif ($row_Recordset1['type']=='3'){
							echo "Complaints";
						}	
		?>
     for Bi-SmartS</p></td>
  </tr>
  <tr>
    <td width="88">Name</td>
    <td width="5">:</td>
    <td width="229"><?php echo $row_Recordset1['nik']; ?> -  <?php echo $row_Recordset1['firstname']; ?> <?php echo $row_Recordset1['midlename']; ?> <?php echo $row_Recordset1['lastname']; ?></td>
    <td width="5">&nbsp;</td>
    <td width="105" valign="top">Time of Comment</td>
    <td width="10" valign="top">:</td>
    <td width="320" valign="top"><?php echo $row_Recordset1['timeofcomment']; ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['email']; ?></td>
    <td>&nbsp;</td>
    <td>Comment</td>
    <td>: </td>
    <td width="320" valign="top"><textarea name="textarea" id="textarea" cols="45" rows="5" readonly="readonly" style="border:none"><?php echo $row_Recordset1['comment']; ?></textarea></td>
  </tr>
  <tr>
    <td>Phone Number</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['ph']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="320" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Time of Respond</td>
    <td>:</td>
    <td valign="top"><?php echo $row_Recordset1['timeofrespond']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Respond</td>
    <td>:</td>
    <td width="320" valign="top"><textarea name="textarea2" id="textarea2" cols="45" rows="5" readonly="readonly" style="border:none"><?php echo $row_Recordset1['respond']; ?></textarea></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
