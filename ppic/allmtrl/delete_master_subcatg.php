<?php require_once('../../Connections/core.php');

	$vid = $_REQUEST['data'];
	$idmcatg = $_REQUEST['data2'];
	
	/* echo "<script>alert(\"$vid dan $updateGoTo\");</script>"; */	
	$q = "UPDATE m_master_subcatg SET subcatg_stat = '0' WHERE id_msubcatg='$vid'";
	$cmd = mysql_query($q) or die(mysql_error());
	
	if ($cmd) {
		echo "<script>document.location=\"view_master_subcatg.php?data=$idmcatg\";
		</script>";
	} else {
		echo "<script>alert(\"Data can't be deleted , Pesan Error: ".mysql_error()."\");
			 document.location=\"view_master_subcatg.php?data=$idmcatg\";
		</script>";
	}
?>