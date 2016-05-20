<?php require_once('../Connections/core.php'); ?>
<?php
	$iddocore = $_GET['data'];
	$iddoheader = $_GET['data2'];

  mysql_select_db($database_core, $core);	
  $deleteSQL = "DELETE FROM p_do_core WHERE id='$iddocore'";


  $Result1 = mysql_query($deleteSQL, $core) or die(mysql_error());

  
echo "<script>document.location=\"do_viewdetail_isi.php?data=$iddoheader\";</script>";

?>