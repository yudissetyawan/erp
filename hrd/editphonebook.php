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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "input")) {
  $updateSQL = sprintf("UPDATE phone_book SET name=%s, phone=%s, hp=%s, fax=%s, `description`=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['hp'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "viewphonebook.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM phone_book WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="input"><div class="con">
  	<table>
    <tr>
		<td class="tdhead"><span class="inputhead">Nama</span></td><td class="inputcontent"><input name="name" type="text" class="inputform" value="<?php echo $row_Recordset1['name']; ?>" /></td>
    </tr>
    </table>
  </div>
  <div class="con">
    <table>
    <tr>
    	<td class="tdhead" ><span class="inputhead">No. Tlp</span></td><td class="inputcontent"><input name="phone" type="text" class="inputform" value="<?php echo $row_Recordset1['phone']; ?>" /></td>
        <td ><span class="inputhead">Fax</span></td><td class="inputcontent"><input name="fax" type="text" class="inputform" value="<?php echo $row_Recordset1['fax']; ?>" /></td>
    </tr>
    <tr>
    	<td class="tdhead" ><span class="inputhead">Handphone</span></td><td class="inputcontent"><input name="hp" type="text" class="inputform" value="<?php echo $row_Recordset1['hp']; ?>" /></td>
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
    	<td><textarea name="keterangan" cols="75" rows="7" class="textareaform"><?php echo $row_Recordset1['description']; ?></textarea></td>
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
  <input type="hidden" name="MM_update" value="input" />
  </form>
</div>
</body>
</html><?php
mysql_free_result($Recordset1);
?>
