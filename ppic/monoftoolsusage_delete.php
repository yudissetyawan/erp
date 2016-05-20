<?php
require_once('../Connections/core.php');
$vid = $_REQUEST['data'];

/* echo "<script>alert(\"$vid dan $updateGoTo\");</script>"; */	
$q = "UPDATE p_monoftoolsusage SET activeYN='0' WHERE id_usage='$vid'";
$cmd = mysql_query($q) or die(mysql_error());

if ($cmd) {
	echo "<script>document.location=\"viewmonoftoolsusage.php\";</script>";
} else {
	echo "<script>alert(\"Data can't be deleted , Pesan Error: ".mysql_error()."\");
		 document.location=\"viewmonoftoolsusage.php\";
	</script>";
}
?>