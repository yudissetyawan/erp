<?php require_once('../../Connections/core.php');

	$vid = $_REQUEST['data'];
	
	/* echo "<script>alert(\"$vid dan $updateGoTo\");</script>"; */	
	$q = "UPDATE m_master_catg SET catg_stat = '0' WHERE id_mcatg='$vid'";
	$cmd = mysql_query($q) or die(mysql_error());
	
	if ($cmd) {
		echo "<script>document.location=\"view_master_catg.php\";
		</script>";
	} else {
		echo "<script>alert(\"Data can't be deleted , Pesan Error: ".mysql_error()."\");
			 document.location=\"view_master_catg.php\";
		</script>";
	}
?>