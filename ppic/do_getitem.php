<?php
	$q = $_GET['q'];
	require_once('../Connections/core.php');
	
	mysql_select_db($database_core, $core);
	$query_rscmbunit = "SELECT * FROM m_unit";
	$rscmbunit = mysql_query($query_rscmbunit, $core) or die(mysql_error());
	$row_rscmbunit = mysql_fetch_assoc($rscmbunit);
	$totalRows_rscmbunit = mysql_num_rows($rscmbunit);
	
	$sql="SELECT item_code, descr_spec, id_unit
			FROM m_master
			WHERE id_item = '$q'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	//echo '<a href="input_material_name.php?data='.$q.'">Input Name of Item</a>';
	//<input name="idsubcatg" type="text" id="idsubcatg" value="'.$row['mtrl_or_service'].'.'.$row['msubcatg_code'].'" />

echo 'Item Code &nbsp; : <input type="text" name="itemcd" id="itemcd" readonly="readonly" value="'.$row['item_code'].'" size="12" disabled />
      <br /><br />
      Dimension or Specification : <br />
	  <textarea name="spec" id="spec" cols="40" rows="2" value="'.$row['descr_spec'].'" /></textarea>';
	?>
    
    <br /><br />
      Qty &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
    <input type="text" name="qty" id="qty" class="required" size="5" title="Quantity is required" />
    <select name="unit" id="unit" class="required" title="Select Unit">
		<option value="">- Unit -</option>
		<?php do { ?>
			<option value="<?php echo $row_rscmbunit['id_unit']?>" <?php if ($row_rscmbunit['id_unit'] == $row['id_unit']) { ?> selected="selected" <?php } ?>><?php echo $row_rscmbunit['unit']?></option>
		<?php
		} while ($row_rscmbunit = mysql_fetch_assoc($rscmbunit));
		$rows = mysql_num_rows($rscmbunit);
		if($rows > 0) {
 			mysql_data_seek($rscmbunit, 0);
			$row_rscmbunit = mysql_fetch_assoc($rscmbunit);
		}
		?>
	</select>

    <a href="do_inputunit.php?data=<?php echo $_GET['p']; ?>">Input Unit</a>
    <br /><br />
    
	<?php
	mysql_close($con);
?>