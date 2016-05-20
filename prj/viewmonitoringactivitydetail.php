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
$query_Recordset2 = sprintf("SELECT a.id FROM f_monitoring_activity_header a JOIN a_crf b ON a.crf=b. id WHERE a.id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT a.id, a.description, b.spec FROM f_monitoring_activity_header_core a LEFT JOIN c_material b ON a.specmat=b.id WHERE monitoringactivityheader = '".$row_Recordset2['id']."' ";
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
        <td><?php echo $dateget; ?></td>
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
    <td><?php echo $row_mradata['customername']; ?></td>
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
<p>
  <?php
 	mysql_select_db($database_core, $core);
	$qry = sprintf("SELECT a.id FROM f_monitoring_activity_header a JOIN a_crf b ON a.crf=b. id JOIN a_production_code c ON c.id=b.productioncode JOIN e_header_bom d ON d.productioncode=c.id WHERE a.id = %s AND d.submit_stat=1", GetSQLValueString($colname_Recordset2, "int"));
	$Rec2 = mysql_query($qry, $core) or die(mysql_error());
	$totalRows2= mysql_num_rows($Rec2);
	if($totalRows2 <= 0){
		echo"<p style='color:red'><strong>Belum ada bom yg di-submit</strong>";
	}else{
		mysql_free_result($Rec2);
		mysql_select_db($database_core, $core);
		$qry = sprintf("SELECT id FROM f_monitoring_activity_header_core WHERE monitoringactivityheader= %s", GetSQLValueString($colname_Recordset2, "int"));
		$Rec2 = mysql_query($qry, $core) or die(mysql_error());
		$totalRows2= mysql_num_rows($Rec2);
		if($totalRows2 >0){
		}else{
			echo"<a href='getdata.php?data=".$row_Recordset2['id']."'>get data</a>"; 
		}
	}
 if ($totalRows_Recordset1 > 0){?>
</p>
<table>
   
  <tr class="tabel_header" >
    <td width="100">Item Parts</td>
    <td width="250">Description</td>
    <td width="185">Speck Material</td>
    <td width="50">Qty</td>
    <td width="50">Cutting</td>
    <td width="50">Forming</td>
    <td width="50">Assembly</td>
    <td width="50">Welding</td>
    <td width="50">NDETest</td>
    <td width="50">Blasitng & Painting</td>
    <td width="50">Others</td>
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
      <tr class="tabel_body">
        <td align="center"><?php echo $i; $i++; ?></td>
        <td><?php echo $row_Recordset1['description']; ?></td>
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
		$query1 = "SELECT a.id, a.description, b.spec, a.qty, a.remark 
		FROM f_monitoring_activity_core a 
		LEFT JOIN c_material b ON a.specmaterial=b.id 
		WHERE monitoringactivityheadercore = '".$row_Recordset1['id']."' ";	
		$R1 = mysql_query($query1, $core) or die(mysql_error());
		$r = mysql_fetch_assoc($R1);
		$tRows1 = mysql_num_rows($R1);
		
		if ( $tRows1 >0){
			do {
				if ((isset($dateget)) && ($dateget != "")){
					$query2 = "SELECT d.cutting, d.forming, d.assembly, d.welding, d.ndetest, d.blastingpainting, d.others, d.remark 
					FROM f_monitoring_activity_core_log d 
					WHERE d.id_core = '".$r['id']."' AND d.date= '".$dateget."' ";	
				}
				else{
					$query2 = "SELECT SUM(d.cutting) cutting, SUM(d.forming) forming, SUM(d.assembly) assembly, SUM(d.welding) welding, SUM(d.ndetest) ndetest, SUM(d.blastingpainting) blastingpainting, SUM(d.others) others, d.remark
					FROM f_monitoring_activity_core_log d 
					WHERE d.id_core = '".$r['id']."'";	
				}
				$R2 = mysql_query($query2, $core) or die(mysql_error());
				$r2 = mysql_fetch_assoc($R2);
				$tRows2 = mysql_num_rows($R2);
			  ?>
			  <tr class="tabel_body">
              	<td></td>
				<td><?php echo $r['description'] ; ?></td>
				<td><?php echo $r['spec'] ; ?></td>
				<td><?php echo $r['qty'] ; $tQty=$tQty+$r['qty']; ?></td>
				<td><?php echo $r2['cutting'] ; $tCutting=$tCutting+$r2['cutting']; ?></td>
				<td><?php echo $r2['forming'] ; $tForming=$tForming+$r2['forming'];?></td>
				<td><?php echo $r2['assembly'] ; $tAssembly=$tAssembly+$r2['assembly'];?></td>
				<td><?php echo $r2['welding'] ; $tWelding=$tWelding+$r2['welding'];?></td>
				<td><?php echo $r2['ndetest'] ; $tNDEtest=$tNDEtest+$r2['ndetest'];?></td>
				<td><?php echo $r2['blastingpainting'] ; $tBlastingPainting=$tBlastingPainting+$r['blastingpainting'];?></td>
				<td><?php echo $r2['others'] ; $tOthers=$tOthers+$r2['others'];?></td>
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
    <tr class="tabel_body">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><?php echo $tQty; ?></td>
        <td><?php echo number_format((($tCutting / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tForming / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tAssembly / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tWelding / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tNDEtest / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tBlastingPainting / $tQty)*100),1,'.',''); ?>%</td>
        <td><?php echo number_format((($tOthers / $tQty)*100),1,'.',''); ?>%</td>
        <td>&nbsp;</td>       
  	</tr>
    <?php
	 }
	?>
  </table>
  
</body>
</html>
<?php }
mysql_free_result($Recordset1);

mysql_free_result($mradata);

mysql_free_result($Recordset2);
?>
