<?php require_once('../Connections/core.php'); ?>
<?php
$today=date("Y-m-d");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT a.id FROM f_monitoring_activity_header a JOIN a_crf b ON a.crf=b. id WHERE a.id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT a.id, a.description, b.materialname, b.spec FROM f_monitoring_activity_header_core a LEFT JOIN c_material b ON a.description=b.id WHERE a.monitoringactivityheader = '".$row_Recordset2['id']."' ";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_mradata = "-1";
if (isset($_GET['data'])) {
  $colname_mradata = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_mradata = sprintf("SELECT a.document_no,a.date,a.revisi,b.firstname preparename,c.firstname approvedname,d.jobtitle,e.customername ,f.project_code ,g.productioncode FROM f_monitoring_activity_header a LEFT JOIN h_employee b ON a.preparedby=b.id LEFT JOIN h_employee c ON a.preparedby=c.id LEFT JOIN a_crf d ON a.crf=d. id LEFT JOIN a_customer e ON d.customer= e.id LEFT JOIN a_proj_code f ON d.projectcode = f.id LEFT JOIN a_production_code g ON d.productioncode = g.id WHERE a.id = %s", GetSQLValueString($colname_mradata, "int"));
$mradata = mysql_query($query_mradata, $core) or die(mysql_error());
$row_mradata = mysql_fetch_assoc($mradata);
$totalRows_mradata = mysql_num_rows($mradata);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monitoring Activity</title>
<link href="../menu_assets/induk.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.edit').editable('save.php?tb=f_monitoring_activity_core_log&date=<?php echo $today; ?>&log=1', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...',
			placeholder: '-'
		});
	});
</script>
</head>

<body class="General">
<table width="351">
  <tr>
    <td width="68"><strong>No Document</strong></td>
    <td width="132"><?php echo $row_mradata['document_no']; ?></td>
  </tr>
  <tr>
    <td><strong>Tanggal</strong></td>
    <td><?php echo $today; ?></td>
  </tr>
</table>
<p>
  <?php
 	
 if ($totalRows_Recordset1 > 0){ ?>
</p>
<table>
   
  <tr class="tabel_header">
    <td width="100">Item Parts</td>
    <td width="250">Description</td>
    <td width="185">Speck Material</td>
    <td width="50">Qty</td>
    <td width="50">Cutting</td>
    <td width="50">Setting</td>
    <td width="50">Welding</td>
    <td width="50">Forsing</td>
    <td width="50">Blasting</td>
    <td width="50">Painting</td>
    <td width="50">NDT/Load Test</td>
    <td width="250">Remark</td>
  </tr>
      <?php $i=1; 
	  $tQty=0;
	  $tCutting=0;
	  $tForming=0;
	  $tAssembly=0;
	  $tWelding=0;
	  $tNDEtest=0;
	  $tBlastingPainting=0;
	  $tOthers=0;
	  do { ?>
  <form id="form1" name="form1" method="post" action="">
      <tr style="background:#5D75B9; color:#FFF;">
        <td align="center"><?php echo $i; $i++; ?></td>
        <td><?php echo $row_Recordset1['materialname']; ?></td>
        <td><?php echo $row_Recordset1['spec']; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php
		$query1 = "SELECT a.id, a.description, b.spec, a.qty
		FROM f_monitoring_activity_core a 
		LEFT JOIN c_material b ON a.specmaterial=b.id 
		WHERE monitoringactivityheadercore = '".$row_Recordset1['id']."'";
		$R1 = mysql_query($query1, $core) or die(mysql_error());
		$r = mysql_fetch_assoc($R1);
		$tRows1 = mysql_num_rows($R1);
		
		
		if ( $tRows1 >0){
			do {
				$query01 = "SELECT * FROM f_monitoring_activity_core_log WHERE id_core = '".$r['id']."' AND date LIKE '".$today."%'";
				$Recordset01 = mysql_query($query01, $core) or die(mysql_error());
				$r01 = mysql_fetch_assoc($Recordset01);
				$totalRows_Recordset01 = mysql_num_rows($Recordset01);
			  ?>
			  <tr bgcolor="<?php if($nums % 2 != 0) echo "#CDD2EA"; else echo "#D6D3D9"; $nums++;?>" >
              	<td></td>
				<td><?php echo $r['description'] ; ?></td>
				<td><?php echo $r['spec'] ; ?></td>
				<td><?php echo $r['qty'] ; $tQty=$tQty+$r['qty']; ?></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-cutting"><?php if(isset($r01['cutting'])){ echo $r01['cutting'];}else{echo 0;} ; $tCutting=$tCutting+$r01['cutting']; ?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-setting"><?php if(isset($r01['forming'])){ echo $r01['forming'];}else{echo 0;} ; $tForming=$tForming+$r01['forming'];?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-welding"><?php if(isset($r01['assembly'])){ echo $r01['assembly'];}else{echo 0;} ; $tAssembly=$tAssembly+$r01['assembly'];?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-forsing"><?php if(isset($r01['welding'])){ echo $r01['welding'];}else{echo 0;} ; $tWelding=$tWelding+$r01['welding'];?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-blasting"><?php if(isset($r01['ndetest'])){ echo $r01['ndetest'];}else{echo 0;} ; $tNDEtest=$tNDEtest+$r01['ndetest'];?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-painting"><?php if(isset($r01['painting'])){ echo $r01['painting'];}else{echo 0;} ; $tBlastingPainting=$tBlastingPainting+$r01['painting'];?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-load_test"><?php if(isset($r01['load_test'])){ echo $r01['others'];}else{echo 0;} ; $tOthers=$tOthers+$r['others'];?></div></td>
				<td><div class="edit" id="<?php echo $r['id']; ?>-remark"><?php echo $r01['remark'] ; ?></div></td>
			  </tr>
			  <?php
			}while ($r = mysql_fetch_assoc($R1));
		}
		mysql_free_result($R1);
	  ?>
      </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
  
</body>
</html>
<?php }
mysql_free_result($Recordset1);

mysql_free_result($mradata);

mysql_free_result($Recordset2);
?>
