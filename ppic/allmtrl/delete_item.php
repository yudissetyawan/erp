<?php require_once('../../Connections/core.php');

	$vid = $_REQUEST['data'];
	
	/* echo "<script>alert(\"$vid dan $updateGoTo\");</script>"; */	
	$q = "UPDATE m_master SET s_active = '0' WHERE id_item='$vid'";
	$cmd = mysql_query($q) or die(mysql_error());
	
	if ($cmd) {
		echo "<script>document.location=\"viewallmtrl_det.php\";
		</script>";
	} else {
		echo "<script>alert(\"Data can't be deleted , Pesan Error: ".mysql_error()."\");
			 document.location=\"viewallmtrl_det.php\";
		</script>";
	}
?>