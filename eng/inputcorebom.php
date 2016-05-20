<?php 
	require_once('../Connections/core.php'); 
	include('../library/floatformat.php');
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
$query_Recordset1 = sprintf("SELECT c_material.materialname, e_header_core_bom.id FROM e_header_core_bom LEFT JOIN c_material ON e_header_core_bom.`description`=c_material.id WHERE e_header_core_bom.id_header = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT e_drawing_file.drawingno, maker.firstname AS makername, a_customer.customername, e_header_bom.location, e_header_bom.tw, e_header_bom.tlgh, a_production_code.productioncode, a_proj_code.project_code, e_header_bom.revision, e_header_bom.`date`, checked.firstname AS checkedby, approve.firstname AS approvedby FROM e_header_bom LEFT JOIN e_drawing_file ON e_header_bom.drawingno=e_drawing_file.id LEFT JOIN  h_employee AS maker ON e_header_bom.createdby=maker.id LEFT JOIN a_customer ON e_header_bom.customer=a_customer.id LEFT JOIN a_production_code ON e_header_bom.productioncode=a_production_code.id LEFT JOIN a_proj_code ON e_header_bom.projectcode=a_proj_code.id LEFT JOIN  h_employee AS checked ON e_header_bom.checkedby=checked.id LEFT JOIN h_employee AS approve ON e_header_bom.approvedby = approve.id WHERE e_header_bom.id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet"  />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/token-input.css" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.tokeninput.js"></script>
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
		$.ajax({url:"../fileajax/addunit.php?data=<?php echo $_GET['data']; ?>",success:function(result){
    		$("#dialog2").html(result);
		}});
	};
	function addMaterialUnit(){
		$('#dialog2').dialog('open');
		$('#dialog2').dialog({
				title: 'Create new material',
		});
		$.ajax({url:"../fileajax/addmaterialunit.php?data=<?php echo $_GET['data']; ?>",success:function(result){
    		$("#dialog2").html(result);
		}});
	};
	function editHeaderBom(){
		$('#dialog').dialog({
				title: 'Edit Header Bom',
				width: 700,
		});
		$.ajax({url:"../fileajax/editheaderbom.php?data=<?php echo $_GET['data']; ?>",success:function(result){
    		$("#dialog").html(result);
		}});
	};
	function addDataMaterial(idForm){
		$('#dialog').dialog({
				title: 'Add Data Material',
				width: 700,
		});
		$.ajax({url:"../fileajax/inputcorebomwindow.php?data=<?php echo $_GET['data'] ?>&data2="+idForm+"",success:function(result){
    		$("#dialog").html(result);
		}});
	};
	function editDataMaterial(idForm){
		$('#dialog').dialog({
				title: 'Edit Data Material',
				width: 700,
		});
		$.ajax({url:"../fileajax/editcorebomwindow.php?data=<?php echo $_GET['data']; ?>&data2="+idForm+"act=edit",success:function(result){
    		$("#dialog").html(result);
		}});
	};
	function viewProduction(){
		var projid = document.getElementById("projectcode").value ;
		
		$.ajax({url:"../fileajax/getproduction.php?data="+projid,success:function(result){
    		$("#prodcon").html(result);
		}});
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
</script>
<title>Detail Bom</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
        <td width="250" class="contenthdr"><?php echo $row_Recordset2['productioncode']; ?></td>
      </tr>
      <tr>
        <td class="tableheader">Location</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['location']; ?></td>
        <td class="tableheader">Project Code</td>
        <td class="contenthdr"><?php echo $row_Recordset2['project_code']; ?></td>
      </tr>
      <tr>
        <td class="tableheader">Costumer</td>
        <td class="contenthdr">&nbsp;<?php echo $row_Recordset2['customername']; ?></td>
        <td class="tableheader">Revision</td>
        <td class="contenthdr"><?php echo $row_Recordset2['revision']; ?></td>
      </tr>
      <tr>
        <td class="tableheader">Created By</td>
        <td class="contenthdr"><?php echo $row_Recordset2['makername']; ?></td>
        <td class="tableheader">Date</td>
        <td class="contenthdr"><?php echo $row_Recordset2['date']; ?></td>
      </tr> 	
    </table>
  </div>
  <p>&nbsp;</p>
  <div id="content">
    <table class="tableclass1">
        <tr>
          <td width="123" class="tableheader">Checked By</td>
          <td width="250" class="contenthdr"><?php echo $row_Recordset2['checkedby']; ?></td>
        </tr>
        <tr>
          <td class="tableheader">Approved By</td>
          <td class="contenthdr"><?php echo $row_Recordset2['approvedby']; ?></td>
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
           <td><input type="submit" value="submit" /> 
             <a href="#" onclick="addMaterialUnit()" class="addunitmat" >Create new material</a></td>
         </tr>
       </table>
       <input type="hidden" name="MM_insert" value="addmaterial" />
     </form>
     <?php if($totalRows_Recordset1 == 0){echo "Material Kosong <!--";} ?>
    <p>Material :</p>
    <table width="1282" class="tableclass1">
       <tr class="tableheader" align="center">
         <td width="30">&nbsp;</td>
         <td colspan="2">Description</td>
         <td width="86">specification</td>
         <td width="37">thick</td>
         <td width="46">width</td>
         <td width="47">length</td>
         <td width="37">unit</td>
         <td width="51">unit weight</td>
         <td width="55">qty weight</td>
         <td width="38">qty</td>
         <td width="120">total weight</td>
         <td width="129">total length</td>
         <td width="124">paint area</td>
         <td width="133">total paintarea</td>
         <td width="37">&nbsp;</td>
       </tr>
       <?php $n=0; do { ?>
       <tr class="content1" bgcolor="#00CC66">
         <td><input type="button" value="+" class="actbutton" onclick="addDataMaterial('<?php echo $row_Recordset1['id']; ?>')"  /></td>
         <td colspan="10"><?php echo $row_Recordset1['materialname']; ?></td>
         <td align="right">&nbsp;</td>
         <td align="right">&nbsp;</td>
         <td align="right">&nbsp;</td>
         <td align="right">&nbsp;</td>
          <td align="center"><a href="delcoreheaderbom.php?data=<?php echo $row_Recordset1['id']; ?>&amp;data2=<?php echo $_GET['data'] ?>" class="link_button" onclick="return confirm('Apa anda yakin akan menghapus material : <?php echo $row_Recordset1['materialname']; ?>')" >X</a></td>
      </tr>
       <?php 
		$query_recFunction = sprintf("SELECT e_core_bom.id, e_core_bom.spec, e_core_bom.thickness, e_core_bom.width, e_core_bom.length, e_core_bom.unitweight, e_core_bom.paintarea, e_core_bom.headercorebom, c_unit.unit
FROM e_core_bom LEFT JOIN c_unit ON e_core_bom.unit=c_unit.id WHERE e_core_bom.headercorebom = %s", GetSQLValueString($row_Recordset1['id'], "text"));
		$record = mysql_query($query_recFunction, $core) or die(mysql_error());
		$Rows = mysql_fetch_assoc($record);
		$numRows = mysql_num_rows($record);
		if($numRows == 0)echo "<!--"; $i=0; 
		do{ 
	?>
        <form name="form<?php echo $n."-".$i ; ?>" id="form<?php echo $n."-".$i ; ?>" >
          <tr class="content2" bgcolor="<?php if(($i%2)!=0)echo "#66FFFF" ?>">
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td width="63"><input type="button" value="Edit" class="actbutton" onclick="editDataMaterial('<?php echo $Rows['id']; ?>')"  />
             <a class="link_button" href="delcorebom.php?data=<?php echo $Rows['id'] ?>&amp;data2=<?php echo $_GET['data'] ?>" onclick="return confirm('Apa anda yakin akan menghapus data material ini')" >X</a></td>
            <td width="181" ><?php echo $row_Recordset1['materialname']; ?>
             <input name="headercore<?php echo $n."-".$i; ?>" type="hidden" /></td>
            <td align="center"><?php echo $Rows['spec'] ?></td>
            <td align="right"><?php echo formatFloat($Rows['thickness']) ?></td>
            <td align="right"><?php echo formatFloat($Rows['width']) ?></td>
            <td align="right"><?php echo formatFloat($Rows['length']) ?></td>
            <td align="center"><?php echo $Rows['unit'] ?></td>
            <td align="right"><?php echo formatFloat($Rows['unitweight']) ?></td>
            <td align="right"><?php echo formatFloat($Rows['qtyweight']) ?></td>
            <td align="center"><?php echo $Rows['qty'] ?></td>
            <td align="right"><?php echo formatFloat($Rows['totalweight']) ?></td>
            <td align="right"><?php echo formatFloat($Rows['totallength']) ?></td>
            <td align="right"><?php echo formatFloat($Rows['paintarea']) ?></td>
            <td align="right"><?php echo formatFloat($Rows['totalpaintarea']) ?></td>
            <td align="right">&nbsp;</td>
          </tr>
        </form>
        <?php $i++; } while($Rows = mysql_fetch_assoc($record)); if($numRows == 0)echo "-->";?>
        <tr>
          <td></form></td>
        </tr>
        <?php $n++; } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </table>
    <p>&nbsp;</p>
     <p>
       <input type="button" name="done" id="done" value="Done" onclick="window.location.href='viewheaderbom.php'"/>
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
