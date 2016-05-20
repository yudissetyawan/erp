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

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT id, nik, firstname, lastname, id_attendance FROM h_employee ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
<p> Sellect Employee to show Time Card</p>
  <select name="employee" id="employee" onchange="getidattendance()">
    <option value="Sellect">Sellect Employee</option>
    <?php
do {  
?>
    <option value="<?php echo $row_Recordset1['id_attendance']?>"><?php echo $row_Recordset1['nik']?> | <?php echo $row_Recordset1['firstname'] ?>  <?php echo $row_Recordset1['lastname'] ?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
  </select>
  <p id="demo"></p>
  
  <?php /* script for auto load timeattendance.php when change in selectbox dettected */ ?>
  <script>
function getidattendance() {
    var x = document.getElementById("employee").value;
    document.getElementById("demo").innerHTML = x;
	var send = x ;
	window.open("http://erp.btubpn.com/hrd/absnkary/timecarddetail.php?data=" + x ,"_self");
}
</script>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
