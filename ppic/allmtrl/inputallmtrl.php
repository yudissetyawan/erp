<?php require_once('../../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO m_master (item_code, id_mmodel, descr_name, descr_spec, brand, id_unit, last_updated, updated_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode'], "text"),
                       GetSQLValueString($_POST['cmbModel'], "text"),
                       GetSQLValueString($_POST['itemdescr'], "text"),
					   GetSQLValueString($_POST['itemspec'], "text"),
                       GetSQLValueString($_POST['brand'], "text"),
					   GetSQLValueString($_POST['cmbunit'], "text"),
					   GetSQLValueString(date("Y-m-d"), "text"),
					   GetSQLValueString($_SESSION['empID'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
    $insertGoTo = "viewallmtrl_det.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO p_stock_item (id_item) VALUES (%s)",
                       GetSQLValueString($_POST['id_items'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO it_asset_header (id_material) VALUES (%s)",
                       GetSQLValueString($_POST['id_material'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

mysql_select_db($database_core, $core);
$query_rsmcat = "SELECT * FROM m_master_catg WHERE catg_stat = '1'";
$rsmcat = mysql_query($query_rsmcat, $core) or die(mysql_error());
$row_rsmcat = mysql_fetch_assoc($rsmcat);
$totalRows_rsmcat = mysql_num_rows($rsmcat);

mysql_select_db($database_core, $core);
$query_rsunit = "SELECT * FROM m_unit";
$rsunit = mysql_query($query_rsunit, $core) or die(mysql_error());
$row_rsunit = mysql_fetch_assoc($rsunit);
$totalRows_rsunit = mysql_num_rows($rsunit);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM m_master";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM m_master ORDER BY id_item DESC LIMIT 1"));
$cekQ=$ceknomor[id_item];
$next=$cekQ+1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../css/induk.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry Item</title>

<script type="text/javascript" src="../../js/jquery-1.7.2.min.js"></script>
 
<!-- Script Ajax untuk Mengontrol Dropdown List Bertingkat -->
<script type="text/javascript">
$(function() {
     $("#cmbMCatg").change(function(){
          $("img#imgLoad").show();
          var idMCatg = $(this).val();
 
          $.ajax({
             type: "POST",
             dataType: "html",
             url: "getSubcatg.php",
             data: "idMCatg="+idMCatg,
             success: function(msg){
                 if(msg == ''){
                         $("select#cmbSubcatg").html('<option value="">- Choose Subcategory -</option>');
                         $("select#cmbModel").html('<option value="">- Choose Name of Item -</option>');
                 }else{
                         $("select#cmbSubcatg").html(msg);                                                      
                 }
                 $("img#imgLoad").hide();
 
                 getAjaxCatg();                                                       
             }
          });                   
     });
 
     $("#cmbSubcatg").change(getAjaxCatg);
     function getAjaxCatg(){
          $("img#imgLoadMerk").show();
          var idSubcatg = $("#cmbSubcatg").val();
 
          $.ajax({
             type: "POST",
             dataType: "html",
             url: "getItemName.php",
             data: "idSubcatg="+idSubcatg,
             success: function(msg){
                 if(msg == ''){
                         $("select#cmbModel").html('<option value="">- Choose Name of Item -</option>');                                                                                 
                 }else{
                           $("select#cmbModel").html(msg);                             
                 }
                 $("img#imgLoadMerk").hide();                                                       
             }
          });
     }    
});
</script>

<script type="text/javascript">
function showData(str) {
	//alert (str);
	if (str=="") {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status == 200) {
			document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","getIDSub.php?q="+str,true);
	xmlhttp.send();
}
</script>
<script type="text/javascript">
	function periksa() {
		if (document.form1.kode.value.length < 10) {
			alert("Sorry, item code is not valid, please select category and subcategory again");
			location.reload();
			document.form1.cmbMCatg.focus();
			return false;
		} else if (document.form1.cmbMCatg.value == "") {
			alert("Select Category of Item");
			document.form1.cmbMCatg.focus();
			return false;
		}
	}
</script>

<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>


</head>

<body onLoad="document.form1.cmbMCatg.focus();">
<?php { include "../date.php";  include "uploads.php"; } ?>
<b>Entry Item</b>
<br /><br />

<form action="<?php echo $editFormAction; ?>"  method="POST" name="form1" class="General" id="form1">
  <table width="550" border="0">
    <tr>
      <td width="100" class="General">Category</td>
      <td width="8">:</td>
      <td width="276"><select name="cmbMCatg" id="cmbMCatg">
        <option value="">- Choose Category of Item -</option>
        <?php do { ?>
        <option value="<?php echo $row_rsmcat['id_mcatg']; ?>"> <?php echo $row_rsmcat['mcatg_descr']; ?></option>
        <?php } while ($row_rsmcat = mysql_fetch_assoc($rsmcat)); ?>
      </select>
      &nbsp;&nbsp;<img src="../../images/loading.gif" width="18" id="imgLoad" style="display:none;" />
      </td>
    </tr>
    <tr>
      <td class="General">Subcategory
      <input name="id_subcatg" type="hidden" id="id_subcatg" /></td>
      <td>:</td>
      <td><select name="cmbSubcatg" id="cmbSubcatg" onchange="showData(this.value)">
        <option value="">- Choose Subcategory -</option>
      </select>        &nbsp;&nbsp;<img src="../../images/loading.gif" width="18" id="imgLoadMerk" style="display:none;" /></td>
    </tr>
    <tr>
      <td class="General">Name of Item</td>
      <td>:</td>
      <td><select name="cmbModel" id="cmbModel">
        <option value="">- Choose Name of Item -</option>
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td>
      	<div id="txtHint"></div>
      </td>
    </tr>
    <tr>
      <td colspan="3" class="General"><b>Description of Item</b></td>
    </tr>
    <tr>
      <td class="General">Description</td>
      <td>:</td>
      <td><textarea cols="50" rows="2" name="itemdescr" id="itemdescr"></textarea></td>
    </tr>
    <tr>
      <td class="General">Specification</td>
      <td>:</td>
      <td><textarea cols="50" rows="2" name="itemspec" id="itemspec"></textarea></td>
    </tr>
    <tr>
      <td class="General">Brand</td>
      <td>:</td>
      <td><input type="text" name="brand" size="30" /></td>
    </tr>
    <tr>
      <td class="General">Unit</td>
      <td>:</td>
      <td>
        <select name="cmbunit" id="cmbunit">
          <?php
do {  
?>
          <option value="<?php echo $row_rsunit['id_unit']?>"><?php echo $row_rsunit['unit']?></option>
          <?php
} while ($row_rsunit = mysql_fetch_assoc($rsunit));
  $rows = mysql_num_rows($rsunit);
  if($rows > 0) {
      mysql_data_seek($rsunit, 0);
	  $row_rsunit = mysql_fetch_assoc($rsunit);
  }
?>
        </select>
		<?php
        //if (($_SESSION['userlvl'] == 'ppic') || ($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) { ?>
			<a href="inputunit.php?data=<?php echo $row_rssubcatg['id_msubcatg']; ?>">Input Unit</a></td>
        <?php //} ?>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="pricepu" type="hidden" id="pricepu" size="15" /></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="hidden" name="id_items" id="id_items" value="<?php echo $next; ?>" />        
      <input type="submit" name="submit" id="submit" value="Save" onClick="return periksa();" /></td>
    </tr>
  </table>
  
	<input name="nama_fileps" type="hidden" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_departemen" type="hidden" id="id_departemen" value="PPIC"/>
    <input type="hidden" name="idms" id="idms" value="<?php echo $nextpracode; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="id_material" id="id_material" value="<?php echo $next; ?>" />
</form>

</p>
</body>
</html>
<?php
	mysql_free_result($rsmcat);
	mysql_free_result($rsunit);
	mysql_free_result($Recordset1);
?>