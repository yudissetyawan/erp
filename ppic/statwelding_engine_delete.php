<?php
require_once('../Connections/core.php');
$vid = $_REQUEST['data'];

/* echo "<script>alert(\"$vid dan $updateGoTo\");</script>"; */	
$q = "UPDATE p_statusengine SET engineactiveYN='0' WHERE id='$vid'";
$cmd = mysql_query($q) or die(mysql_error());

if ($cmd) {
	echo "<script>document.location=\"status_welding_engine.php\";</script>";
} else {
	echo "<script>alert(\"Data can't be deleted , Pesan Error: ".mysql_error()."\");
		 document.location=\"status_welding_engine.php\";
	</script>";
}
?>