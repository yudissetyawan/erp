<?php
	$q = $_GET['q'];
	require_once('../Connections/core.php'); 
	$sql="SELECT item_code, descr_spec
			FROM m_master
			WHERE id_item = '$q'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	//echo '<a href="input_material_name.php?data='.$q.'">Input Name of Item</a>';
	//<input name="idsubcatg" type="text" id="idsubcatg" value="'.$row['mtrl_or_service'].'.'.$row['msubcatg_code'].'" />

echo 'Item Code &nbsp; : <input type="text" name="itemcd" id="itemcd" readonly="readonly" value="'.$row['item_code'].'" />
      <br /><br />
      Specification : <br />
	  <textarea name="spec" id="spec" cols="40" rows="2" readonly="readonly" value="'.$row['descr_spec'].'" ></textarea>';
	
	mysql_close($con);
?>