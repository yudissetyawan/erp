<?php require_once('../../Connections/core.php');

$idbtbcore = $_GET['data'];
$idbtbheader = $_GET['data2'];

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT c_po_core.id AS id_pocore FROM c_po_core
INNER JOIN p_btb_header ON p_btb_header.id_po = c_po_core.poheader
INNER JOIN p_btb_core ON p_btb_core.id_header = p_btb_header.id 
WHERE p_btb_core.id_item = c_po_core.itemno AND p_btb_core.id = '$idbtbcore'";
$Recordset1 = mysql_query($query_Recordset1,$core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

$idpocore = $row_Recordset1['id_pocore'];

//if ((isset($_GET['data'])) && ($_GET['data'] != "")) {
  $deleteSQL = "DELETE FROM p_btb_core WHERE id='$idbtbcore'";
  $Result1 = mysql_query($deleteSQL) or die(mysql_error());

	$updateSQL = "UPDATE c_po_core SET btb_status='1' WHERE id='$idpocore'";
	$Result2 = mysql_query($updateSQL) or die(mysql_error());

  //$deleteGoTo = "viewpodetail.php?data=$idpocore";
echo "<script>document.location=\"view_btb_core_isi.php?data=$idbtbheader\";</script>";
//}
?>
