<?php 
	require_once('../Connections/core.php'); 
	include('../library/floatformat.php');
	include('qtyweightcal.php');
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addmaterial")) {
	$j=0;
  do{
	  if(!empty($_POST['data'.$j.''])){
		  $insertMaterial = sprintf("INSERT INTO e_header_core_bom(description,id_header) VALUES(%s,%s)",GetSQLValueString($_POST['data'.$j.''], "text"),
																										GetSQLValueString($_GET['data'], "int"));
		  mysql_select_db($database_core, $core);
		  $Result1 = mysql_query( $insertMaterial, $core) or die(mysql_error()); 
	  }
	  $j++;
  }while($j<=$_POST['jumM']);

  $insertGoTo = "editbom.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

function getSQLbyId($idData){
	
	$query_recFunction = sprintf("SELECT * FROM e_core_bom WHERE headercorebom = %s", GetSQLValueString($idData, "text"));
	print $record = mysql_query($query_recFunction, $core) or die(mysql_error());
	print $Rows = mysql_fetch_assoc($record);
	print $numRows = mysql_num_rows($record);
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT c_material.materialname, e_header_core_bom.id, e_header_core_bom.spec, e_header_core_bom.spec2, e_header_core_bom.spec3 FROM e_header_core_bom LEFT JOIN c_material ON e_header_core_bom.description=c_material.id WHERE e_header_core_bom.id_header = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT e_drawing_file.drawingno, maker.firstname AS makername, a_customer.customername, e_header_bom.id, e_header_bom.location, e_header_bom.tw, e_header_bom.tlgh, a_production_code.productioncode, a_proj_code.project_code, e_header_bom.revision, e_header_bom.`date`, checked.firstname AS checkedby, approve.firstname AS approvedby FROM e_header_bom LEFT JOIN e_drawing_file ON e_header_bom.drawingno=e_drawing_file.id LEFT JOIN  h_employee AS maker ON e_header_bom.createdby=maker.id LEFT JOIN a_customer ON e_header_bom.customer=a_customer.id LEFT JOIN a_production_code ON e_header_bom.productioncode=a_production_code.productioncode LEFT JOIN a_proj_code ON e_header_bom.projectcode=a_proj_code.project_code LEFT JOIN  h_employee AS checked ON e_header_bom.checkedby=checked.id LEFT JOIN h_employee AS approve ON e_header_bom.approvedby = approve.id WHERE e_header_bom.id = %s
", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/style.css" rel="stylesheet" />
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet"  />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/token-input.css" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.tokeninput.js"></script>
<script src="../js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	var wtTotal=0;
	$(document).ready(function() {
		$('.edit').editable('save.php?tb=e_core_bom', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...',
			placeholder: '-'
		});
		$('.editheader').editable('save.php?tb=e_header_core_bom', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...',
			placeholder: '-'
		});
		function editFormula(id,value){
			document.getElementById( id+'-qtyweightcal').getElementsByTagName('input').setAttribute("value",value);
		}
		$('.editformula').editable('save.php?tb=e_core_bom', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...',
			placeholder: '-'
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		var jum=0;
		$("#inputMaterial").tokenInput("../fileajax/materialsearch.php",{
			tokenFormatter: function(item) { return "<li><p>" + item.name +"<input type='hidden' value='"+ item.id +"' name='data"+jumM(jum)+"'></p></li>" },
			onAdd : function(){document.getElementById("jumM").setAttribute("value",jum); jum=jum+1;},	
		});
		$(function(){
			$('#dialog').dialog({
				autoOpen: false,
				title: 'ADD',
				width: 700,
			});
			$('#dialog2').dialog({
				autoOpen: false,
				modal: true,
				width: 500,
			});
			$('.actbutton').click(function() {
				$('#dialog').dialog('open');
				return false;						   
			});
		});
	});
	function jumM(jum){
		return jum;
	};
	function addUnit(){
		$('#dialog2').dialog('open');
		$('#dialog2').dialog({
				title: 'Create new unit',
		});
		$.ajax({url:"../../fileajax/addunit.php?data=<?php echo $_GET['data']; ?>&act=edit",success:function(result){
    		$("#dialog2").html(result);
		}});
	};
	function addMaterialUnit(){
		$('#dialog2').dialog('open');
		$('#dialog2').dialog({
				title: 'Create new material',
		});
		$.ajax({url:"../../fileajax/addmaterialunit.php?data=<?php echo $_GET['data']; ?>&act=edit",success:function(result){
    		$("#dialog2").html(result);
		}});
	};
	function editHeaderBom(){
		$('#dialog').dialog({
				title: 'Edit Header Bom',
				width: 700,
		});
		$.ajax({url:"../../fileajax/editheaderbom.php?data=<?php echo $_GET['data']; ?>",success:function(result){
    		$("#dialog").html(result);
		}});
	};
	function addDataMaterial(idForm){
		$('#dialog').dialog({
				title: 'Add Data Material',
				width: 700,
				height: 500,
				
		});
		$.ajax({url:"../../fileajax/inputcorebomwindow.php?data=<?php echo $_GET['data'] ?>&data2="+idForm+"&act=edit",success:function(result){
    		$("#dialog").html(result);
		}});
	};
	function editDataMaterial(idForm){
		$('#dialog').dialog({
				title: 'Edit Data Material',
				width: 700,
		});
		$.ajax({url:"../../fileajax/editcorebomwindow.php?data=<?php echo $_GET['data']; ?>&data2="+idForm+"act=edit",success:function(result){
    		$("#dialog").html(result);
		}});
	};
	function viewProduction(){
		var projid = document.getElementById("projectcode").value ;
		
		$.ajax({url:"../../fileajax/getproduction.php?data="+projid,success:function(result){
    		$("#prodcon").html(result);
		}});
	};
	function getSectionFrame(data2){
		var idframe = document.getElementById("frametype").value ;
		
		$.ajax({url:"../../fileajax/framesection.php?header="+idframe+"&data=<?php echo $_GET['data'] ;?>&data2="+data2,success:function(result){
    		$("#SectionFrame").html(result);
		}});
		
	};
	function sectionDimension(idframe,data2){
		$.ajax({url:"../../fileajax/framesectioncore.php?idframe="+idframe+"&data2="+data2,success:function(result){
    		$("#SectionFrame").html(result);
		}});
		calculateCall(idframe);
	};
	function getTotal(){
			width = parseFloat(document.getElementById("width").value);
			lgh = parseFloat(document.getElementById("lgh").value); 
			unitweight = parseFloat(document.getElementById("unitweight").value);
			qty = parseInt(document.getElementById("qty").value); 
			paintarea = parseFloat(document.getElementById("paintarea").value);
			if (width==null){width=1};
			if (lgh==null){lgh=1};
			document.getElementById("qtyweight").setAttribute("value",parseFloat(width*lgh*unitweight).toFixed(3));
			document.getElementById("totalweight").setAttribute("value",parseFloat(document.getElementById("qtyweight").value*qty).toFixed(3));
			document.getElementById("tlgh").setAttribute("value",parseFloat(lgh*qty).toFixed(3));
			document.getElementById("totalpa").setAttribute("value",parseFloat(document.getElementById("tlgh").value*paintarea).toFixed(3));
	}
	function calculateCall(idframe){
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("SectionFrameCalculate").innerHTML=xmlhttp.responseText;
			}
		  }
		xmlhttp.open("GET","../../fileajax/calculateform.php?idframe="+idframe,true);
		xmlhttp.send();
	};
</script>
<title>Edit Bom</title>
</head>

<body>
<div id="dialog"></div>
<div id="dialog2"></div>
<content>
  <div class="float">
    <table width="" class="tableclass1">
      <tr>
        <td width="123" class="tableheader">No. Drawing</td>
        <td width="250" class="contenthdr">&nbsp;<?php echo $row_Recordset2['drawingno']; ?></td>
        <td width="123" class="tableheader">No.</td>
        <td width="250" class="contenthdr">&nbsp;<?php echo $row_Recordset2['productioncode']; ?></td>
      </tr>
      <tr>
        <td class="tableheader">Location</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['location']; ?></td>
        <td class="tableheader">Project Code</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['project_code']; ?></td>
      </tr>
      <tr>
        <td class="tableheader">Costumer</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['customername']; ?></td>
        <td class="tableheader">Revision</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['revision']; ?></td>
      </tr>
      <tr>
        <td class="tableheader">Created By</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['makername']; ?></td>
        <td class="tableheader">Date</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['date']; ?></td>
      </tr> 	
    </table>
  </div>
  <p>
    <input type="button" name="refresh2" id="refresh2" value="Refresh" onclick="javascript:document.location.reload();" />
    <script>
		function submitBOM(){
			var cnfrm=confirm('Apa Anda Yakin !')
			if (cnfrm==true) {
				window.location='submitBOM.php?data=<?php echo $row_Recordset2['id']; ?>' ;
			}
		}
    </script>
    <input type="submit" name="submit" id="submit" value="Submit BOM" onclick="submitBOM();" />
  </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp; </p>
  <div id="content">
    <table class="tableclass1">
        <tr>
          <td width="123" class="tableheader">Checked By</td>
          <td width="250" class="contenthdr">&nbsp;<?php echo $row_Recordset2['checkedby']; ?></td>
        </tr>
        <tr>
          <td class="tableheader">Approved By</td>
          <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['approvedby']; ?></td>
        </tr>
    </table>
     <p>&nbsp;</p>
     <form action="<?php echo $editFormAction; ?>" method="POST" name="addmaterial" id="addmaterial">
       <table width="526" border="0" class="General">
         <tr>
           <td width="79" class="General">Add Material</td>
           <td width="10">:</td>
           <td width="429"><input type="text" name="inputMaterial" id="inputMaterial" /><input type="hidden" name="jumM" id="jumM" value="" /></td>
         </tr>
         <tr>
           <td></td>
           <td></td>
           <td><input type="submit" value="submit" />             <a href="#" onclick="addMaterialUnit()" class="addunitmat" >Create new material</a></td>
         </tr>
       </table>
       <input type="hidden" name="MM_insert" value="addmaterial" />
     </form>
     <?php if($totalRows_Recordset1 == 0){echo "Material Kosong <!--";} else { ?>
    <p>Material :</p>
    <table width="1373" class="tableclass1">
       <tr class="tableheader1" align="center">
         <td width="29" height="30">NO</td>
         <td colspan="2">DESCRIPTION</td>
         <td width="62">Spec</td>
         <td width="67">Thick</td>
         <td width="64">Width</td>
         <td width="55">Length</td>
         <td width="55">UNIT</td>
         <td width="73">Unit Weight</td>
         <td width="91">Qty Weight</td>
         <td width="23">Qty</td>
         <td width="100">Total Weight(Kg)</td>
         <td width="100">Total Length(M)</td>
         <td width="112">Paint Area</td>
         <td width="112">Total Paintarea</td>
         <td width="116">Drawing No.</td>
         <td width="23">&nbsp;</td>
       </tr>
       <?php $n=0; do { ?>
       <tr class="content1">
         <td><a class="link_button" style="text-decoration:none; color:#09F" href="addrow.php?data=<?php echo $row_Recordset1['id']; ?>&fld=headercorebom&tb=e_core_bom&d2=<?php echo $row_Recordset1['materialname']; ?>&f2=description&bckid=<?php echo $_GET['data'] ;?>"><strong>+</strong></a></td>
         <td colspan="10"><?php echo $row_Recordset1['materialname']; ?><script> var totalweight<?php echo $row_Recordset1['id']; ?>=0; </script></td>
         <?php
		 $querySUM = sprintf("SELECT headercorebom, sum(length*qty) sumLgh, sum(paintarea) sumPA, sum(paintarea*qty) sumTPA
FROM e_core_bom WHERE headercorebom = %s GROUP BY headercorebom", GetSQLValueString($row_Recordset1['id'], "text"));
		$record = mysql_query($querySUM, $core) or die(mysql_error());
		$SUMrow = mysql_fetch_assoc($record);
		 ?>
         <td align="right"><div id='sumTW<?php echo $row_Recordset1['id']; ?>'></div></td>
         <td align="right"><?php echo  formatFloat($SUMrow['sumLgh']) ?> &nbsp;</td>
         <td align="right"><?php if($SUMrow['sumPA']==0)echo " "; else echo  formatFloat($SUMrow['sumPA']) ?> &nbsp;</td>
         <td align="right"><?php if($SUMrow['sumTPA']==0)echo " "; else echo  formatFloat($SUMrow['sumTPA']) ?> &nbsp;</td>
         <td><div align="center"></div></td>
          <td align="center"><a href="delcoreheaderbom.php?data=<?php echo $row_Recordset1['id']; ?>&amp;data2=<?php echo $_GET['data'] ?>" class="link_button" onclick="return confirm('Apa anda yakin akan menghapus material : <?php echo $row_Recordset1['materialname']; ?>')" >X</a></td>
      </tr>
       <?php 
		$query_recFunction = sprintf("SELECT a.id, a.spec, a.thickness, a.width, a.length, a.unit, a.unitweight, a.qty, a.paintarea, a.remark, a.headercorebom
FROM e_core_bom a WHERE a.headercorebom = %s", GetSQLValueString($row_Recordset1['id'], "text"));
		$record = mysql_query($query_recFunction, $core) or die(mysql_error());
		$Rows = mysql_fetch_assoc($record);
		$numRows = mysql_num_rows($record);
		if($numRows == 0)echo "<!--"; $i=0; 
		$k=0;
		do{ 
	?>
        <form name="form<?php echo $n."-".$i ; ?>" id="form<?php echo $n."-".$i ; ?>" >
          <tr class="content2" onkeyup="calt<?php echo $Rows['id'];?>()" bgcolor="<?php if($k=='win') echo "#D9EDE0"; else echo "DFEDCB"; $k++ ?>">
            <td><?php if(!isset($sp)) $sp=1; echo $sp; $sp++;?></td>
            <td width="28"><a class="link_button" href="delcorebom.php?data=<?php echo $Rows['id'] ?>&amp;data2=<?php echo $_GET['data'] ?>&amp;act=edit" onclick="return confirm('Apa anda yakin akan menghapus data material ini')" >X</a></td>
            <td width="191" ><?php echo $row_Recordset1['materialname']; ?>
             <input name="headercore<?php echo $n."-".$i; ?>" type="hidden" /></td>
            <td align="center"><div class="edit" id="<?php echo $Rows['id']; ?>-spec"><?php if(!isset($Rows['spec']) || ($Rows['spec'] == 0))echo "    "; else { echo formatFloat($Rows['spec']);};?></div></td>
            <td align="right"><div class="edit" id="<?php echo $Rows['id']; ?>-thickness"><?php if(!isset($Rows['thickness']) || ($Rows['thickness'] == 0))echo "    "; else { echo formatFloat($Rows['thickness']);};?></div></td>
            <td align="right"><div class="edit" id="<?php echo $Rows['id']; ?>-width"><?php if(!isset($Rows['width']) || ($Rows['width'] == 0))echo "    "; else { echo formatFloat($Rows['width']);};?></div></td>
            <td align="right"><div class="edit" id="<?php echo $Rows['id']; ?>-length"><?php if(!isset($Rows['length']) || ($Rows['length'] == 0))echo "    "; else { echo formatFloat($Rows['length']);};?></div></td>
            <td align="center"><div class="edit" id="<?php echo $Rows['id']; ?>-unit"><?php echo $Rows['unit'];?></div></td>
            <td align="right"><div class="edit" id="<?php echo $Rows['id']; ?>-unitweight"><?php if(!isset($Rows['unitweight']) || ($Rows['unitweight'] == 0))echo "    "; else { echo formatFloat($Rows['unitweight']);};?></div></td>
            <td align="right"><?php QWcalculate($Rows['spec'],$Rows['thickness'],$Rows['width'],$Rows['length'],$Rows['unitweight'],$Rows['id']); ?><script>document.write(hasil<?php echo $Rows['id']; ?>);</script></td>
            <td align="center"><div class="edit" id="<?php echo $Rows['id']; ?>-qty"><?php if(!isset($Rows['qty']) || ($Rows['qty'] == 0))echo "    "; else { echo $Rows['qty'];};?></div></td>
            <td align="right"><script> var tw = hasil<?php echo $Rows['id']; ?> * <?php echo $Rows['qty']; ?>; totalweight<?php echo $row_Recordset1['id']; ?>=totalweight<?php echo $row_Recordset1['id']; ?> + tw ; document.write(tw.toFixed(3));</script></td>
            <td align="right"><?php $tl=$Rows['length'] * $Rows['qty']; if($tl==0)echo "-" ;else echo formatFloat($tl); if(!isset($tlTotal))$tlTotal=0; $tlTotal=$tlTotal +  $tl; ?></td>
            <td align="right"><div class="edit" id="<?php echo $Rows['id']; ?>-paintarea"><?php if(!isset($Rows['paintarea']) || ($Rows['paintarea'] == 0))echo "    "; else { echo formatFloat($Rows['paintarea']);}; if(!isset($paTotal))$paTotal=0; $paTotal=$paTotal + $Rows['paintarea']; ?></div></td>
            <td align="right"><?php if($Rows['paintarea'] * $Rows['qty'] == 0) echo "-"; else echo formatFloat($Rows['paintarea'] * $Rows['qty']); if(!isset($patTotal))$patTotal=0; $patTotal=$patTotal + ($Rows['paintarea'] * $Rows['qty']);  ?></td>
            <td align="center"><div class="edit" id="<?php echo $Rows['id']; ?>-remark"><?php if(!isset($Rows['remark']) || ($Rows['remark'] == ""))echo "    "; else { echo $Rows['remark'];};?></div></td>
            <td align="right">&nbsp;</td>
          </tr>
        </form>
        <?php $i++; } while($Rows = mysql_fetch_assoc($record)); if($numRows == 0)echo "-->";?>
        <tr bgcolor="#FFFFFF">
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td colspan="2" align="center"><div class="editheader" id="<?php echo $row_Recordset1['id']; ?>-spec"><?php if(!isset($row_Recordset1['spec']))echo "    "; else { echo $row_Recordset1['spec'];};?></div></td>
          	<td align="center"><div class="editheader" id="<?php echo $row_Recordset1['id']; ?>-spec2"><?php if(!isset($row_Recordset1['spec2']))echo "    "; else { echo $row_Recordset1['spec2'];};?></div></td>
          	<td align="center"><div class="editheader" id="<?php echo $row_Recordset1['id']; ?>-spec3"><?php if(!isset($row_Recordset1['spec3']))echo "    "; else { echo $row_Recordset1['spec3'];};?></div></td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td align="right"><script>var sumtw<?php echo $row_Recordset1['id']; ?>=totalweight<?php echo $row_Recordset1['id']; ?>.toFixed(3); document.getElementById('sumTW<?php echo $row_Recordset1['id']; ?>').innerHTML = sumtw<?php echo $row_Recordset1['id']; ?> ; wtTotal=wtTotal+totalweight<?php echo $row_Recordset1['id']; ?>;</script></td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td><div align="center"></div></td>
            <td>&nbsp;</td>
          </tr>
        <?php $n++; } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        <tr style="border-top:solid;" bgcolor="#E1F2F7">
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td>&nbsp;</td>
          	<td><div align="center"><b>WT TOTAL</b></div></td>
          	<td>&nbsp;</td>
          	<td><div align="right">
          	  <b>
          	  <script>document.write(wtTotal.toFixed(3))</script>
   	        </b></div></td>
          	<td><div align="right"><b><?php if($tlTotal==0)echo " "; else echo formatFloat($tlTotal); ?></b></div></td>
          	<td><div align="right"><b><?php if($paTotal==0)echo " "; else echo formatFloat($paTotal); ?></b></div></td>
          	<td><div align="right"><b><?php if($patTotal==0)echo " "; else echo formatFloat($patTotal); ?></b></div></td>
          	<td><div align="center"></div></td>
            <td>&nbsp;</td>
          </tr>
    </table><?php } ; ?>
    <p>&nbsp;</p>
     <p>
       <input type="button" name="refresh" id="refresh" value="Refresh" onclick="javascript:document.location.reload();" />
     </p>
  </div>
</content>
</body>
</html>

<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($unit);

mysql_free_result($recFunction);
?>
