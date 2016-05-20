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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO a_production_item (productioncode, itemdescription, qty, satuan, amount, budgetcode) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['productioncode'], "text"),
                       GetSQLValueString($_POST['itemdescription'], "text"),
                       GetSQLValueString($_POST['qty'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['ammount'], "text"),
                       GetSQLValueString($_POST['budgetcode'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "../ppic/viewproductionitem.php?data=" . $row_Recordset1['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_production_code WHERE id = %s ORDER BY id ASC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form1").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
<style type="text/css">
* { font:"Times New Roman", Times, serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="422" border="0">
    <tr>
      <td width="149" class="General">Production Code</td>
      <td width="10">&nbsp;</td>
      <td width="250" class="General"><label>
        <select name="productioncode" id="productioncode" class="required" title="Silahkan Pilih Production Code">
          <option value="">-- Piih Production Code --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['productioncode']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="General">Item Desription</td>
      <td>&nbsp;</td>
      <td class="General"><label>
        <textarea name="itemdescription" id="itemdescription" cols="45" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="General">Qty</td>
      <td>&nbsp;</td>
      <td class="General"><label>
        <input type="text" name="qty" id="qty" />
      </label></td>
    </tr>
    <tr>
      <td class="General">Satuan</td>
      <td>&nbsp;</td>
      <td class="General"><label>
        <input type="text" name="satuan" id="satuan" />
      </label></td>
    </tr>
    <tr>
      <td class="General">Ammount</td>
      <td>&nbsp;</td>
      <td class="General"><label>
        <input type="text" name="ammount" id="ammount" />
      </label></td>
    </tr>
    <tr>
      <td class="General">Budget Code</td>
      <td>&nbsp;</td>
      <td class="General"><label>
        <input type="text" name="budgetcode" id="budgetcode" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="General"><label>
        <input type="submit" name="save" id="save" value="save" />
      </label></td>
    </tr>
  </table>
  <span class="General">
  <input type="hidden" name="MM_insert" value="form1" />
  </span>
</form>
<span class="General">
<?php
mysql_free_result($Recordset1);
?>
</span>