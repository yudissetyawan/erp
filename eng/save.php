<?php
require_once('../Connections/core.php'); 
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
// data yang diterima $_GET["tb"] , $_POST["id"] ,$_POST["value"] , $_GET['log']
// $_GET['tb'] = nama table yg akan di update atau di add
// $_POST['id'] = berisikan id row dan nama field 
// $_POST['value'] = nilai yg akan di si atau di update
// $_get['log'] = data yg diterima berjeins log atau bukan (log berarti catatan pertanggal) 
if((isset($_GET["tb"])) && ($_GET["tb"]!="")){
	if ((isset($_POST["id"])) && (isset($_POST["value"]))) {
		// $_POST['id'] di pecah untuk mendapatkan nama field dan id row
		// $desc[0] = id row
		// $desc[1] = nama field
		$desc = explode("-",$_POST['id']);
		
		if((isset($desc[0]))&&($desc[0]!="")){
			if((isset($desc[1]))&&($desc[1]!="")){
				if((isset($_GET['log']))&&($_GET['log']=="1")){
					// jika data merupakan jenis log
					  mysql_select_db($database_core, $core);
					  // pengecekan jika recordset yg akan d input ada atau tudak
					  $q = sprintf("SELECT * FROM ".$_GET['tb']." WHERE id_core=%s AND date = '".$_GET['date']."' ",GetSQLValueString($desc[0], "text"));
					  $R= mysql_query($q, $core) or die(mysql_error());
					  $r1 = mysql_fetch_assoc($R);
					  $totalRows1 = mysql_num_rows($R);
					  if($totalRows1 > 0){
						  // jika total record =0 maka akan di proses dengan update
						  $insertSQL = sprintf("UPDATE ".$_GET['tb']." SET ".$desc[1]."=%s WHERE id_core=%s AND date = '".$_GET['date']."' ",
								    		   GetSQLValueString($_POST['value'], "text"),
							    			   GetSQLValueString($desc[0], "text"));
					
					  	  mysql_select_db($database_core, $core);
					  	  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
					  }
					  else{
						  //jika record >0 akan di proses dengan insert
						 $insertSQL = "INSERT INTO ".$_GET['tb']."(id_core,date,".$desc[1].") VALUES(".GetSQLValueString($desc[0], "text").",
						 																			 ".GetSQLValueString($_GET['date'], "text").",
																									 ".GetSQLValueString($_POST['value'], "text").")"; 
						 
						 mysql_select_db($database_core, $core);
					  	 $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
					  }
					  mysql_free_result($R);
					  echo $_POST['value'] ;
				}
				else{
					//jika data bukan jenis log
					  $updateSQL = sprintf("UPDATE ".$_GET['tb']." SET ".$desc[1]."=%s WHERE id=%s",
										   GetSQLValueString($_POST['value'], "text"),
										   GetSQLValueString($desc[0], "text"));
					
					  mysql_select_db($database_core, $core);
					  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
						
					  if((isset($_GET['select']))&&($_GET['select']!="")){
						  // untuk tipe select 
						  mysql_select_db($database_core, $core);
						  $query_Recordset1 = sprintf("SELECT * FROM ".$_GET['tb2']." WHERE id=%s",GetSQLValueString($_POST['value'], "text"));
						  $Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
						  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
						  $totalRows_Recordset1 = mysql_num_rows($Recordset1);
						  
						  echo $row_Recordset1[''.$_GET['fld'].''];
						  mysql_free_result($Recordset1);
					  }else{
						  echo $_POST["value"];
					  }
				}
			}else {
				echo "Edit Gagal 4";
			}
		}else{echo "Edit Gagal 3";}
	}else{echo "Edit Gagal 2";}
}else{echo "Edit Gagal 1";}
?>