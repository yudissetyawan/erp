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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "input")) {
  $insertSQL = sprintf("INSERT INTO phone_book (name, phone, hp, fax, `description`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['hp'], "text"),
                       GetSQLValueString($_POST['Fax'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewphonebook.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<form action="<?php echo $editFormAction; ?>" method="POST" name="input"><div class="con">
  	<table>
    <tr>
		<td class="tdhead"><span class="inputhead">Nama</span></td><td class="inputcontent"><input type="text" name="nama" class="inputform" /></td>
    </tr>
    </table>
  </div>
  <div class="con">
    <table>
    <tr>
    	<td class="tdhead" ><span class="inputhead">Phone</span></td><td class="inputcontent"><input type="text" name="phone" class="inputform" /></td>
        <td ><span class="inputhead">Fax</span></td><td class="inputcontent"><input type="text" name="Fax" class="inputform" /></td>
    </tr>
    <tr>
    	<td class="tdhead" ><span class="inputhead">Handphone</span></td><td class="inputcontent"><input type="text" name="hp" class="inputform" /></td>
    	<td></td><td class="inputcontent"></td>
   	</tr>
    </table>
  </div>
  <div class="con">
  	<table>
    <tr>
    	<td><span class="inputhead">Keterangan</span></td>
    </tr>
    <tr>
    	<td><textarea name="keterangan" cols="75" rows="7" class="textareaform"></textarea></td>
    </tr>
    </table>
  </div>
  <div class="con">
  	<table>
  	<tr>
    	<td><input class="submitbutton" name="" type="submit" value="Submit"></td>
    </tr>
    </table>
  </div>
  <input type="hidden" name="MM_insert" value="input" />
</form>
</div>
</body>
</html>