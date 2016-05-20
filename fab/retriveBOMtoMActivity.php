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
  $query_header = sprintf("SELECT a.id idhdr, a.description, a.spec, b.id idb FROM e_header_core_bom a JOIN e_header_bom b ON a.id_header=b.id JOIN a_crf c ON c.projectcode=b.projectcode AND c.productioncode=b.productioncode WHERE c.idms= %s AND b.status='Active'",GetSQLValueString($_GET['idms'], "int"));
  $header = mysql_query($query_header, $core) or die(mysql_error());
  $row_headercore = mysql_fetch_assoc($header);
  $totalRows_headercore = mysql_num_rows($header);
  
  do{
	  $insertSQL = sprintf("INSERT INTO f_monitoring_activity_header_core(description, specmat, bid, monitoringactivityheader) VALUES (%s, %s, %s, %s)",
                      		GetSQLValueString($row_headercore['description'], "int"),
                       		GetSQLValueString($row_headercore['spec'], "int"),
                       		GetSQLValueString($row_headercore['idb'], "int"),
                       		GetSQLValueString($_GET['header'], "int"));
      mysql_select_db($database_core, $core);
  	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	  
	  mysql_select_db($database_core, $core);
  	  $query_mahd = sprintf("SELECT * FROM f_monitoring_activity_header_core WHERE description = %s AND specmat= %s AND bid= %s AND monitoringactivityheader=%s",GetSQLValueString($row_headercore['description'], "int"),
                       		GetSQLValueString($row_headercore['spec'], "int"),
                       		GetSQLValueString($row_headercore['idb'], "int"),
                       		GetSQLValueString($_GET['header'], "text"));
  	  $mahd = mysql_query($query_mahd, $core) or die(mysql_error());
  	  $row_mahd = mysql_fetch_assoc($mahd);
  	  $totalRows_mahd = mysql_num_rows($mahd);
	  
	  mysql_select_db($database_core, $core);
  	  $query_core = sprintf("SELECT * FROM e_core_bom WHERE headercorebom = %s",GetSQLValueString($row_headercore['idhdr'], "int"));
  	  $qcore = mysql_query($query_core, $core) or die(mysql_error());
  	  $row_qcore = mysql_fetch_assoc($qcore);
  	  $totalRows_qcore = mysql_num_rows($qcore);
	  
	  do{
		  $insertSQL = sprintf("INSERT INTO f_monitoring_activity_core(monitoringactivityheadercore, description, specmaterial, qty, bid ) VALUES (%s, %s, %s, %s, %s)",
                      		    GetSQLValueString($row_mahd['id'], "int"),
                       			GetSQLValueString($row_qcore['description'], "text"),
                       			GetSQLValueString($row_qcore['spec'], "text"),
								GetSQLValueString($row_qcore['qty'], "int"),
                       			GetSQLValueString($_GET['header'], "text"));

     	 mysql_select_db($database_core, $core);
  	 	 $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
	  }while($row_qcore = mysql_fetch_assoc($qcore));
	  
  }while($row_headercore = mysql_fetch_assoc($header));
  
  $insertGoTo = "viewmonitoringactivity.php?data=".$_GET['idms'];
  header(sprintf("Location: %s", $insertGoTo));
?>