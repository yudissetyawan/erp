<?php require_once('../Connections/core.php'); ?>
<?php
$dateget=$_GET['date'];
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
$query_Recordset2 = sprintf("SELECT a.id FROM f_monitoring_activity_header a JOIN a_crf b ON a.crf=b.id WHERE a.id = %s", GetSQLValueString($colname_Recordset2, "int"));
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
$query_mradata = sprintf("SELECT a.document_no,a.date,a.revisi,b.firstname preparename,c.firstname approvedname,d.jobtitle,d.customer ,f.project_code ,g.productioncode FROM f_monitoring_activity_header a LEFT JOIN h_employee b ON a.preparedby=b.id LEFT JOIN h_employee c ON a.preparedby=c.id LEFT JOIN a_crf d ON a.crf=d.id LEFT JOIN a_proj_code f ON d.projectcode = f.project_code LEFT JOIN a_production_code g ON d.productioncode = g.productioncode WHERE a.id = %s", GetSQLValueString($colname_mradata, "int"));
$mradata = mysql_query($query_mradata, $core) or die(mysql_error());
$row_mradata = mysql_fetch_assoc($mradata);
$totalRows_mradata = mysql_num_rows($mradata);

if($totalRows_Recordset1==0){
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monitoring Activity Report Document no <?php echo $row_mradata['document_no']; ?></title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<table width="100%">
  <tr>
    <td width="116"><strong>Job Description</strong></td>
    <td width="689"><?php echo $row_mradata['jobtitle']; ?></td>
    <td width="443" rowspan="6"><table width="443" border="1">
      <tr>
        <td width="123">No Document</td>
        <td width="304"><?php echo $row_mradata['document_no']; ?></td>
      </tr>
      <?php if ((isset($dateget)) && ($dateget != "")){?>
      <tr>
        <td>Tanggal</td>
        <td><?php echo date("d M Y", strtotime($dateget)); ?></td>
      </tr>
      <?php }else {?> 
      <tr>
        <td colspan="2"><strong>All</strong></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td><strong>Customer</strong></td>
    <td><?php echo $row_mradata['customer']; ?></td>
  </tr>
  <tr>
    <td><strong>Project Code</strong></td>
    <td><?php echo $row_mradata['project_code']; ?></td>
  </tr>
  <tr>
    <td><strong>Product Code</strong></td>
    <td><?php echo $row_mradata['productioncode']; ?></td>
  </tr>
  <tr>
    <td><strong>Start Fabrication</strong></td>
    <td></td>
  </tr>
  <tr>
    <td><strong>Finish Fabrication</strong></td>
    <td></td>
  </tr>
</table>
<table>
   
  <tr class="tabel_header" >
    <td width="73">Item Parts</td>
    <td width="277">Description</td>
    <td width="185">Speck Material</td>
    <td width="50">Qty</td>
    <td width="50">Cutting</td>
    <td width="50">Setting</td>
    <td width="50">Welding</td>
    <td width="50">Forsing</td>
    <td width="50">Blasting</td>
    <td width="50">Painting</td>
    <td width="58">NDT/Load Test</td>
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
		$query1 = "SELECT id, description, specmaterial, qty, remark 
		FROM f_monitoring_activity_core 
		WHERE monitoringactivityheadercore = '".$row_Recordset1['id']."' ";	
		$R1 = mysql_query($query1, $core) or die(mysql_error());
		$r = mysql_fetch_assoc($R1);
		$tRows1 = mysql_num_rows($R1);
		
		if ( $tRows1 >0){
			
			do {
				if(!isset($nums)) $nums=0;
				if ((isset($dateget)) && ($dateget != "")){
					$query2 = "SELECT d.cutting, d.setting, d.welding, d.forsing, d.blasting, d.painting, d.load_test, d.remark 
					FROM f_monitoring_activity_core_log d 
					WHERE d.id_core = '".$r['id']."' AND d.date= '".$dateget."' ";	
				}
				else{
					$query2 = "SELECT SUM(d.cutting) cutting, SUM(d.setting) setting, SUM(d.welding) welding, SUM(d.forsing) forsing, SUM(d.blasting) blasting, SUM(d.painting) painting, SUM(d.load_test) load_test, d.remark
					FROM f_monitoring_activity_core_log d 
					WHERE d.id_core = '".$r['id']."' GROUP BY d.remark";	
				}
				$R2 = mysql_query($query2, $core) or die(mysql_error());
				$r2 = mysql_fetch_assoc($R2);
				$tRows2 = mysql_num_rows($R2);
			  ?>
			  <tr bgcolor="<?php if($nums % 2 != 0) echo "#CDD2EA"; else echo "#D6D3D9"; $nums++;?>" >
              	<td></td>
				<td><?php echo $r['description'] ; ?></td>
				<td><?php echo $r['specmaterial'] ; ?></td>
				<td><?php echo $r['qty'] ; $tQty=$tQty+$r['qty']; ?></td>
				<td><?php echo $r2['cutting'] ; $tCutting=$tCutting+$r2['cutting']; ?></td>
				<td><?php echo $r2['setting'] ; $tSetting=$tSetting+$r2['setting'];?></td>
				<td><?php echo $r2['welding'] ; $tWelding=$tWelding+$r2['welding'];?></td>
				<td><?php echo $r2['forsing'] ; $tForsing=$tForsing+$r2['forsing'];?></td>
				<td><?php echo $r2['blasting'] ; $tBlasting=$tBlasting+$r2['blasting'];?></td>
				<td><?php echo $r2['painting'] ; $tPainting=$tPainting+$r['painting'];?></td>
				<td><?php echo $r2['load_test'] ; $tNDT=$tNDT+$r2['load_test'];?></td>
				<td><?php echo $r2['remark'] ; ?></td>
				</tr>
			  <?php mysql_free_result($R2);
			}while ($r = mysql_fetch_assoc($R1));
		}
		mysql_free_result($R1);
	  ?>
      </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  	<?php if(!isset($dateget)) { ?>
    <tr style="background:#565D7D; color:#FFF; font:bold;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php echo $tQty; ?></td>
        <td><?php echo number_format((($tCutting / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tSetting / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tWelding / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tForsing / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tBlasting / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tPainting / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tNDT / $tQty)*100),1,'.',''); ?>%</td>
        <td>&nbsp;</td>       
  	</tr>
    <?php
	 }
	?>
  </table>
  
</body>
</html>
<?php 
mysql_free_result($Recordset1);

mysql_free_result($mradata);

mysql_free_result($Recordset2);
?>
