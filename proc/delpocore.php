<?php require_once('../Connections/core.php');

$idpocore = $_GET['data'];
$idpoheader = $_GET['data2'];

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT p_mr_core.id AS id_mrcore FROM p_mr_core
INNER JOIN c_po_header ON c_po_header.mrno = p_mr_core.mrheader
INNER JOIN c_po_core ON c_po_core.poheader = c_po_header.id 
WHERE c_po_core.itemno = p_mr_core.itemmr AND c_po_core.id = '$idpocore'";
$Recordset1 = mysql_query($query_Recordset1,$core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$idmrcore = $row_Recordset1['id_mrcore'];

//if ((isset($_GET['data'])) && ($_GET['data'] != "")) {
  $deleteSQL = "DELETE FROM c_po_core WHERE id='$idpocore'";
  $Result1 = mysql_query($deleteSQL) or die(mysql_error());

	$updateSQL = "UPDATE p_mr_core SET po_status='1' WHERE id='$idmrcore'";
	$Result2 = mysql_query($updateSQL) or die(mysql_error());

  //$deleteGoTo = "viewpodetail.php?data=$idpocore";
echo "<script>document.location=\"viewpodetail.php?data=$idpoheader\";</script>";
//}
?>
