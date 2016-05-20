<?php
	$q = $_GET['q'];
	require_once('../../Connections/core.php'); 
	$sql="SELECT a.mtrl_or_service, b.msubcatg_code
			FROM m_master_catg a
			INNER JOIN m_master_subcatg b ON a.id_mcatg = b.id_mcatg
			WHERE id_msubcatg = '$q'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	//echo '<a href="input_material_name.php?data='.$q.'">Input Name of Item</a>';
	//<input name="idsubcatg" type="text" id="idsubcatg" value="'.$row['mtrl_or_service'].'.'.$row['msubcatg_code'].'" />
	?> 
	<a href="#" onclick="MM_openBrWindow('input_material_name.php?data=<?php echo $q; ?>','','scrollbars=no,width=360,height=170,resizable=no,screenX=300,screenY=300')">Input Name of Item</a>
    <?php
    echo '<br><br>
	<b>Item Code</b> &nbsp; : &nbsp;
	';
	$frontitemcode = $row['mtrl_or_service'].'.'.$row['msubcatg_code'].'.';
	$mcatgcode = $row['msubcatg_code'];
	$query = "SELECT MAX(a.item_code) AS maxKode
				FROM m_master a
				INNER JOIN m_e_model b ON a.id_mmodel = b.id_mmodel
				INNER JOIN m_master_subcatg c ON b.id_subcatg = c.id_msubcatg
				WHERE a.item_code LIKE '%$mcatgcode%'";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	$kodeKata = $data['maxKode'];
		$noUrut = (int) substr($kodeKata, 8, 3);			
			$noUrut++;			
				$char = $frontitemcode;
				$newID = $char . sprintf("%03s", $noUrut);
	
	echo '<input name="kode" type="text" id="kode" value="'.$newID.'" readonly>';
	
	/*
	<script>
		var screenX=parseInt((screen.availWidth/2) - (width/2));
		var screenY=parseInt((screen.availHeight/2) - (height/2))
	</script>
	
	$query = "SELECT MAX(msubcatg_code) AS maxKode FROM m_master_subcatg WHERE msubcatg_code LIKE '%$mcatgcode%'";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	$kodeKata = $data['maxKode'];			
		$noUrut = (int) substr($kodeKata, 2, 3);			
			$noUrut++;			
				$char = $_GET['data2'];
				$newID = $char . sprintf("%03s", $noUrut);
	*/
	
	mysql_close($con);
?>