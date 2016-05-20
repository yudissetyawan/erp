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
// record h_employee
mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM h_employee";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// record h_employee yang memiliki id = $_GET['data']
mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_employee WHERE id='".$_GET['data']."'";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// record dijadikan array
do{
	$array[''.$row_Recordset1['id'].'']= ''.$row_Recordset1['firstname'].' '.$row_Recordset1['midlename'].' '.$row_Recordset1['lastname'].'';
}while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	$array['selected'] = ''.$row_Recordset2['id'].'';
	// array di encode ke jason
	print json_encode($array);
	
mysql_free_result($Recordset1);
?>
