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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	 $insertSQL = sprintf("INSERT INTO e_header_bom ('drawingno','createdby','location','customer','projectcode','productioncode','revision','checkedby','approvedby') VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['drawingno'], "text"),
					   GetSQLValueString($_POST['createdby'], "text"),
					   GetSQLValueString($_POST['location'], "text"),
					   GetSQLValueString($_POST['customer'], "text"),
					   GetSQLValueString($_POST['projectcode'], "text"),
					   GetSQLValueString($_POST['no'], "text"),
					   GetSQLValueString($_POST['no'], "text"),
					   GetSQLValueString($_POST['no'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"));
}
?>