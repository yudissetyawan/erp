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
$query_rscmbunit = "SELECT * FROM m_unit";
$rscmbunit = mysql_query($query_rscmbunit, $core) or die(mysql_error());
$row_rscmbunit = mysql_fetch_assoc($rscmbunit);
$totalRows_rscmbunit = mysql_num_rows($rscmbunit);

$q = $_GET['q'];
mysql_select_db($database_core, $core);
$query_rsitemmr = "SELECT m_master.id_item, m_master.itemprice, p_mr_core.qty, p_mr_core.unit
FROM p_mr_core, m_master
WHERE m_master.id_item = p_mr_core.itemmr AND p_mr_core.id = '$q'";
$rsitemmr = mysql_query($query_rsitemmr, $core) or die(mysql_error());
$row_rsitemmr = mysql_fetch_assoc($rsitemmr);
$totalRows_rsitemmr = mysql_num_rows($rsitemmr);

/*
$query_rsitemmr = "SELECT m_master.id_item, m_master.itemprice, p_mr_core.qty, p_mr_core.unit FROM p_mr_core, m_master WHERE m_master.id_item=p_mr_core.itemmr AND p_mr_core.id = '$q'";
*/

mysql_select_db($database_core, $core);
$query_rsjmlqtypo = "SELECT SUM(c_po_core.qty) AS jmlQtyPO
FROM c_po_core
INNER JOIN c_po_header ON c_po_core.poheader = c_po_header.id
INNER JOIN p_mr_core ON c_po_header.mrno = p_mr_core.mrheader
WHERE p_mr_core.itemmr = c_po_core.itemno AND p_mr_core.id = '$q'";
$rsjmlqtypo = mysql_query($query_rsjmlqtypo, $core) or die(mysql_error());
$row_rsjmlqtypo = mysql_fetch_assoc($rsjmlqtypo);
$totalRows_rsjmlqtypo = mysql_num_rows($rsjmlqtypo);


	//echo '<a href="input_material_name.php?data='.$q.'">Input Name of Item</a>';
	//<input name="idsubcatg" type="text" id="idsubcatg" value="'.$row['mtrl_or_service'].'.'.$row['msubcatg_code'].'" />
?>

<table width="650" border="0" class="General">
    <tr>
      <td width="160">Price per Unit</td>
      <td width="10">:</td>
      <td colspan="2">
      <span id="sprytextfield2">
        <input type="text" name="unitprice" id="unitprice" style="text-align:right" onfocus="Total()" value="<?php echo $row_rsitemmr['itemprice'] ?>" />
      </span>
        <input type="hidden" name="iditem" id="iditem" value="<?php echo $row_rsitemmr['id_item']; ?>" />
        <input type="hidden" name="mrqty" id="mrqty" value="<?php echo $row_rsitemmr['qty']; ?>" />
        <input type="hidden" name="poqty" id="poqty" value="<?php
        												if ($row_rsjmlqtypo['jmlQtyPO'] < 1) {
															echo "0";
														} else {
															echo $row_rsjmlqtypo['jmlQtyPO'];
														} ?>" />
      </td>
    </tr>
    <tr>
      <td>Qty</td>
      <td>:</td>
      <td>
      
      <span id="sprytextfield1">
        <input name="qty" type="text" class="required" id="qty" style="text-align:center" title="Qty is required" onkeyup="Total()" size="5" value="<?php
        	$sisa = $row_rsitemmr['qty'] - $row_rsjmlqtypo['jmlQtyPO']; 
			echo $sisa;
		?>" />
      </span>
      
      <span id="spryselect1">
    <select name="unit" id="unit" title="Please select unit">
          <option value="">-- Unit --</option>
          <?php
		do {  
		?>
          <option value="<?php echo $row_rscmbunit['id_unit']?>" <?php if ($row_rscmbunit['id_unit'] == $row_rsitemmr['unit']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbunit['unit']?></option>
          <?php
		} while ($row_rscmbunit = mysql_fetch_assoc($rscmbunit));
		  $rows = mysql_num_rows($rscmbunit);
		  if($rows > 0) {
			  mysql_data_seek($rscmbunit, 0);
			  $row_rscmbunit = mysql_fetch_assoc($rscmbunit);
		  }
		?>
       </select>
        </span>
        <a href="#" onClick="MM_openBrWindow('../ppic/inputunit.php','','toolbar=yes,width=600,height=400')">Add Unit</a>
        </td>  
    </tr>  
    </table>
    
<?php
	mysql_close($con);
	mysql_free_result($rscmbunit);
	mysql_free_result($rsitemmr);

mysql_free_result($rsjmlqtypo);
?>