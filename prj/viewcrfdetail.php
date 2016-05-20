<?php require_once('../Connections/core.php'); ?>
<?php
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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_sch = "-1";
if (isset($_GET['data'])) {
  $colname_sch = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_sch = sprintf("SELECT * FROM a_crf_schedulle WHERE crf = %s", GetSQLValueString($colname_sch, "text"));
$sch = mysql_query($query_sch, $core) or die(mysql_error());
$row_sch = mysql_fetch_assoc($sch);
$totalRows_sch = mysql_num_rows($sch);
?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F00;
}
a:active {
	color: #00F;
}
-->
</style><form name="form1" method="POST">
  <table width="1208" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td colspan="13" align="left" class="General"><table width="877" border="1" cellspacing="1" cellpadding="0">
        <tr class="tabel_header">
          <td width="129" class="">CRF ID</td>
          <td width="136" class="">Project Code</td>
          <td width="143" class="">Production Code</td>
          <td width="454" class="">Customer</td>
          </tr>
        <tr class="tabel_body">
          <td class=""><?php echo $row_Recordset1['nocrf']; ?></td>
          <td align="center"><?php echo $row_Recordset1['projectcode']; ?></td>
          <td align="center"><?php echo $row_Recordset1['productioncode']; ?></td>
          <td class=""><?php echo $row_Recordset1['customer']; ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="13" align="center" class="General"><span class="General"><strong>Customer Request Form (CRF) </strong></span></td>
    </tr>
    <tr>
      <td class="General">Job Title</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><?php echo $row_Recordset1['jobtitle']; ?></td>
      <td width="121" class="General">Date</td>
      <td width="4" class="General">:</td>
      <td width="508" colspan="4" class="General"><?php echo $row_Recordset1['date']; ?></td>
    </tr>
    <tr>
      <td class="General">QTY</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><?php echo $row_Recordset1['qty']; ?></td>
      <td class="General">Reference</td>
      <td class="General">:</td>
      <td colspan="4" class="General"><?php echo $row_Recordset1['ref']; ?></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="4" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="3" class="General">Distribution List</td>
      <td rowspan="3" class="General">:</td>
      <td width="123" height="20" class="General"><? if ($row_Recordset1['marketing']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
      Marketing</td>
      <td width="105" class="General"><? if ($row_Recordset1['quality']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  }?>
      Quality </td>
      <td width="120" class="General"><? if ($row_Recordset1['procurement']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
      Procurement</td>
      <td width="91" class="General"><? if ($row_Recordset1['hrd']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
      HRD </td>
      <td colspan="3" class="General"><? if ($row_Recordset1['it']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
      IT</td>
      <td colspan="4" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td> <span class="General">
        <? if ($row_Recordset1['commercial']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>       
      Commercial</span></td>
      <td><span class="General">
        <? if ($row_Recordset1['hse']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        HSE</span></td>
      <td><span class="General">
        <? if ($row_Recordset1['production']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        PPIC</span></td>
      <td><span class="General">
        <? if ($row_Recordset1['acc']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        Accounting</span></td>
      <td colspan="3"><span class="General">
        <? if ($row_Recordset1['siteproject']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        Site Project</span></td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span class="General">
        <? if ($row_Recordset1['engineering']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        Engineering</span></td>
      <td><span class="General">
        <? if ($row_Recordset1['fabrication']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        Fabrication</span></td>
      <td><span class="General">
        <? if ($row_Recordset1['maintenance']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        Maintenance</span></td>
      <td colspan="3"><span class="General">
        <? if ($row_Recordset1['file']==1) {echo "<img src='../images/select(1).png' width='15' height='15' />";}
		  else {echo "<img src='../images/not.png' width='15' height='15' />";  } ?>
        DCC</span></td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
      <td colspan="6" class="judul">&nbsp;</td>
    </tr>
    <tr>
      <td width="121" class="General">--- End User ---</td>
      <td width="6" class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
      <td colspan="6" rowspan="16" class="judul"><table width="637" border="0" cellpadding="0" cellspacing="2">
        <tr class="tabel_header">
          <td width="120">&nbsp;</td>
          <td colspan="2">Schedule</td>
          <td colspan="2">Progress</td>
        </tr>
        <tr  class="tabel_header">
          <td  class="tabel_header">Tipe Pekerjaan</td>
          <td width="138"  class="tabel_header" >Start</td>
          <td width="132"  class="tabel_header" >Finish</td>
          <td width="71"  class="tabel_header" >Status</td>
          <td width="147"  class="tabel_header" >Completion Date</td>
        </tr>
        <tr class="tabel_body">
          <td><a href="../eng/crfdesign.php?data=<?php echo $row_Recordset1['nocrf']; ?>">Design</a></td>
          <td><?php echo $row_sch['designstart']; ?></td>
          <td><?php echo $row_sch['designend']; ?></td>
          <td><? if ($row_sch['designprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['designprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td><a href="../eng/crfdrawing.php?data=<?php echo $row_Recordset1['nocrf']; ?>">Drawing</a></td>
          <td><?php echo $row_sch['drawingstart']; ?></td>
          <td><?php echo $row_sch['drawingend']; ?></td>
          <td><? if ($row_sch['drawingprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['drawingprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td><? if ($row_sch['itpprogress']=='') {echo "ITP";} else {echo  "<a href='../qly/upload_itp/$row_sch[file_itp]'>ITP</a>";} ?></td>
          <td><?php echo $row_sch['itpstart']; ?></td>
          <td><?php echo $row_sch['itpend']; ?></td>
          <td><? if ($row_sch['itpprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['itpprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td><? if ($row_sch['materialprogress']=='') {echo "Material";} else {echo  "<a href='../ppic/upload/$row_sch[file_material]'>Material</a>";} ?></td>
          <td><?php echo $row_sch['materialstart']; ?></td>
          <td><?php echo $row_sch['materialend']; ?></td>
          <td><? if ($row_sch['materialprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['materialprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td><? if ($row_sch['fabricationprogress']=='') {echo "Fabrication";} else {echo  "<a href='../fab/upload/ik/$row_sch[file_fab]'>Fabrication</a>";} ?></td>
          <td><?php echo $row_sch['fabricationstart']; ?></td>
          <td><?php echo $row_sch['fabricationend']; ?></td>
          <td><? if ($row_sch['fabricationprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['fabricationprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td>Test/NDE</td>
          <td><?php echo $row_sch['testingstart']; ?></td>
          <td><?php echo $row_sch['testingend']; ?></td>
          <td><? if ($row_sch['testingprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['testingprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td>Blasting Painting</td>
          <td><?php echo $row_sch['blastingpaintingstart']; ?></td>
          <td><?php echo $row_sch['blastingpaintingend']; ?></td>
          <td><? if ($row_sch['blastingpaintingprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['blastingpaintingprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td>Delivery</td>
          <td><?php echo $row_sch['deliverystart']; ?></td>
          <td><?php echo $row_sch['deliveryend']; ?></td>
          <td><? if ($row_sch['deliveryprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['deliveryprogress']; ?></td>
        </tr>
        <tr class="tabel_body">
          <td>Instalation</td>
          <td><?php echo $row_sch['instalationstart']; ?></td>
          <td><?php echo $row_sch['instalationend']; ?></td>
          <td><? if ($row_sch['instalationprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
          <td><?php echo $row_sch['installationprogress']; ?></td>
        </tr>
        <tr>
          <td colspan="5" class="tabel_header">Others :</td>
          </tr>
        <tr class="tabel_body">
          <td><?php echo $row_sch['other1']; ?></td>
          <td><?php echo $row_sch['other1start']; ?></td>
          <td><?php echo $row_sch['other1end']; ?></td>
          <td><? if ($row_sch['other1start']==''){echo "";} else { if($row_sch['other1progress']=='') {echo "On Progress";} else {echo "Complete";}} ?></td>
          <td><?php echo $row_sch['other1progress']; ?></td>
          </tr>
        <tr class="tabel_body">
          <td><?php echo $row_sch['other2']; ?></td>
          <td><?php echo $row_sch['other2start']; ?></td>
          <td><?php echo $row_sch['other2end']; ?></td>
          <td><? if ($row_sch['other2start']==''){echo "";} else { if($row_sch['other2progress']=='') {echo "On Progress";} else {echo "Complete";}} ?></td>
          <td><?php echo $row_sch['other2progress']; ?></td>
          </tr>
        <tr class="tabel_body">
          <td><?php echo $row_sch['other3']; ?></td>
          <td><?php echo $row_sch['other3start']; ?></td>
          <td><?php echo $row_sch['other3end']; ?></td>
          <td><? if ($row_sch['other3start']==''){echo "";} else { if($row_sch['other3progress']=='') {echo "On Progress";} else {echo "Complete";}} ?></td>
          <td><?php echo $row_sch['other3progress']; ?></td>
          </tr>
        <tr class="tabel_body">
          <td><?php echo $row_sch['other4']; ?></td>
          <td><?php echo $row_sch['other4start']; ?></td>
          <td><?php echo $row_sch['other4end']; ?></td>
          <td><? if ($row_sch['other4start']==''){echo "";} else { if($row_sch['other4progress']=='') {echo "On Progress";} else {echo "Complete";}} ?></td>
          <td><?php echo $row_sch['other4progress']; ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td class="General">Name</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="name"><?php echo $row_Recordset1['name']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Date</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="datw"><?php echo $row_Recordset1['datw']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Other</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="others"><?php echo $row_Recordset1['others']; ?></label></td>
    </tr>
    <tr>
      <td class="General">--- End User ---</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Drawing Sketch</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="drawingsketch"><?php echo $row_Recordset1['drawingsketch']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Supplied Material</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="suppliedmaterial"><?php echo $row_Recordset1['suppliedmaterial']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Other Terms Condition</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="otherstermsandcondition"><?php echo $row_Recordset1['otherstermsandcondition']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Prepared By</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="preparedby"><?php echo $row_Recordset1['preparedby']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Approved By</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><label for="approvedby"><?php echo $row_Recordset1['approvedby']; ?></label></td>
    </tr>
    <tr>
      <td class="General">Client Verification</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><?php echo $row_Recordset1['clientverivication']; ?></td>
    </tr>
    <tr>
      <td class="General">Issued Date</td>
      <td class="General">:</td>
      <td colspan="5" class="General"><?php echo $row_Recordset1['issueddate']; ?></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td colspan="5" class="General">&nbsp;</td>
    </tr>
  </table>
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($sch);
?>
