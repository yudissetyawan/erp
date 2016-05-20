<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="1000" border="0">
  <tr>
    <td colspan="3" rowspan="2"><img src="file:///C|/inetpub/wwwroot/erp-training/images/bukaka.jpg" width="102" height="24" /></td>
    <td colspan="2">PT. BUKAKA TEKNIK UTAMA </td>
    <td width="88">CRF ID :</td>
    <td width="177">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">BalikpapanWorkshop &amp; Office</td>
    <td>Date:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" rowspan="3">&nbsp;</td>
    <td>:Customer</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Project Code:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Prod. Code:</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="7">CUSTOMER REQUEST FORM (CRF)</td>
  </tr>
  <tr>
    <td width="174" rowspan="3" align="center">END USER <br />
      (KLIEN/PEMESAN)</td>
    <td width="142">NAME</td>
    <td width="8">:</td>
    <td width="238">&nbsp;</td>
    <td width="143">REF.</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>DEPARTMENT</td>
    <td>:</td>
    <td>&nbsp;</td>
    <td>DATE</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>POSITION</td>
    <td>:</td>
    <td>&nbsp;</td>
    <td>OTHERS</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">JOB TITLE / DESCRIPTION (URAIAN/JUDUL PEKERJAAN)</td>
    <td colspan="6"><table width="200" border="0" align="right">
      <tr>
        <td width="33">Qty</td>
        <td width="10">:</td>
        <td width="143">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="6"><table width="637" border="0" cellpadding="0" cellspacing="2">
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
        <td>Design</td>
        <td><?php echo $row_sch['designstart']; ?></td>
        <td><?php echo $row_sch['designend']; ?></td>
        <td><? if ($row_sch['designprogress']=='') {echo "On Progress";} else {echo "Complete";} ?></td>
        <td><?php echo $row_sch['designprogress']; ?></td>
      </tr>
      <tr class="tabel_body">
        <td><? if ($row_sch['drawingprogress']=='') {echo "Drawing";} else {echo  "<a href='../eng/upload_work/upload/$row_sch[file_drawing]'>Drawing</a>";} ?></td>
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
        <td>Material</td>
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
</table>
</body>
</html>