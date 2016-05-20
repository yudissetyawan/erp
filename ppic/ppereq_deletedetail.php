<?php require_once('../Connections/core.php');

$idcore = $_GET['data'];
$idppereqheader = $_GET['data2'];

  mysql_select_db($database_core, $core);
  $deleteSQL = "DELETE FROM p_ppereq_core WHERE id='$idcore'";


  $Result1 = mysql_query($deleteSQL, $core) or die(mysql_error());

echo "<script>document.location=\"ppereq_viewdetail_isi.php?data=$idppereqheader\";</script>";
?>