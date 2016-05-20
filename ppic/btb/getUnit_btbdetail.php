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
$query_rscmbunit = "SELECT * FROM m_unit";
$rscmbunit = mysql_query($query_rscmbunit, $core) or die(mysql_error());
$row_rscmbunit = mysql_fetch_assoc($rscmbunit);
$totalRows_rscmbunit = mysql_num_rows($rscmbunit);

$q = $_GET['q'];
mysql_select_db($database_core, $core);
$query_rsitempo = "SELECT itemno, qty, unit FROM c_po_core WHERE id = '$q'";
$rsitempo = mysql_query($query_rsitempo, $core) or die(mysql_error());
$row_rsitempo = mysql_fetch_assoc($rsitempo);
$totalRows_rsitempo = mysql_num_rows($rsitempo);

mysql_select_db($database_core, $core);
$query_rsjmlqtybtb = "SELECT SUM(p_btb_core.qty) AS jmlQtyBTB
FROM p_btb_core
INNER JOIN p_btb_header ON p_btb_core.id_header = p_btb_header.id
INNER JOIN c_po_core ON p_btb_header.id_po = c_po_core.poheader
WHERE c_po_core.itemno = p_btb_core.id_item AND c_po_core.id = '$q'";
$rsjmlqtybtb = mysql_query($query_rsjmlqtybtb, $core) or die(mysql_error());
$row_rsjmlqtybtb = mysql_fetch_assoc($rsjmlqtybtb);
$totalRows_rsjmlqtybtb = mysql_num_rows($rsjmlqtybtb);

/* echo "<script>alert(\"$q\");</script>"; */
?>

<table width="700">
    <tr>
      <td width="180">Qty</td>
      <td width="10">:</td>
      <td>
      	<input name="qty" type="text" class="required" id="qty" style="text-align:center" title="Qty is required" size="5" value="<?php
        	/* if ($row_rsjmlqtypo['jmlQtyPO'] < 1) {
															echo "0";
														} else {
															echo $row_rsjmlqtypo['jmlQtyPO'];
														} */
			$sisa = $row_rsitempo['qty'] - $row_rsjmlqtybtb['jmlQtyBTB'];
			echo $sisa;
		
		?>" />
        
        <select name="unit" id="unit" title="Please select unit">
        <option value="">-- Unit --</option>
        <?php
		do {  
		?>
        <option value="<?php echo $row_rscmbunit['id_unit']?>" <?php if ($row_rscmbunit['id_unit'] == $row_rsitempo['unit']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbunit['unit']?></option>
        <?php
		} while ($row_rscmbunit = mysql_fetch_assoc($rscmbunit));
		  $rows = mysql_num_rows($rscmbunit);
		  if($rows > 0) {
			  mysql_data_seek($rscmbunit, 0);
			  $row_rscmbunit = mysql_fetch_assoc($rscmbunit);
		  }
		?>
      </select>
      <a href="#" onClick="MM_openBrWindow('../inputunit.php','','toolbar=yes,width=600,height=400')">Add Unit</a>
        <input type="hidden" name="iditem" id="iditem" value="<?php echo $row_rsitempo['itemno']; ?>" />
        <input type="hidden" name="poqty" id="poqty" value="<?php echo $row_rsitempo['qty']; ?>" />
        <input type="hidden" name="btbqty" id="btbqty" value="<?php echo $row_rsjmlqtybtb['jmlQtyBTB']; ?>" />
      </td>
    </tr>  
    </table>
    
<?php
	mysql_close($con);
	mysql_free_result($rscmbunit);
	mysql_free_result($rsitempo);
	mysql_free_result($rsjmlqtybtb);
?>