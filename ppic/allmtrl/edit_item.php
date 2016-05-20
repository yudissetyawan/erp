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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE m_master SET item_code=%s, id_mmodel=%s, descr_name=%s, descr_spec=%s, id_unit=%s, brand=%s, updated_by=%s WHERE id_item=%s",
                       GetSQLValueString($_POST['kode'], "text"),
                       GetSQLValueString($_POST['cmbModel'], "text"),
                       GetSQLValueString($_POST['itemdescr'], "text"),
                       GetSQLValueString($_POST['itemspec'], "text"),
                       GetSQLValueString($_POST['cmbunit'], "text"),
                       GetSQLValueString($_POST['brand'], "text"),
                       GetSQLValueString($_SESSION['empID'], "text"),
                       GetSQLValueString($_POST['iditem'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());

  $updateGoTo = "viewallmtrl_det.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_core, $core);
$query_rsmcatg = "SELECT * FROM m_master_catg";
$rsmcatg = mysql_query($query_rsmcatg, $core) or die(mysql_error());
$row_rsmcatg = mysql_fetch_assoc($rsmcatg);
$totalRows_rsmcatg = mysql_num_rows($rsmcatg);

mysql_select_db($database_core, $core);
$query_rsunit = "SELECT * FROM m_unit";
$rsunit = mysql_query($query_rsunit, $core) or die(mysql_error());
$row_rsunit = mysql_fetch_assoc($rsunit);
$totalRows_rsunit = mysql_num_rows($rsunit);

$iditem = $_GET['data'];
mysql_select_db($database_core, $core);
$query_rsitem = "SELECT m_master.*, m_e_model.mtrl_model, m_master_subcatg.id_msubcatg, m_master_subcatg.msubcatg_descr, m_master_catg.id_mcatg, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM m_master, m_e_model, m_master_subcatg, m_master_catg, h_employee WHERE m_e_model.id_mmodel = m_master.id_mmodel AND m_e_model.id_subcatg = m_master_subcatg.id_msubcatg AND m_master_catg.id_mcatg = m_master_subcatg.id_mcatg AND h_employee.id = m_master.updated_by AND id_item = '$iditem'";
$rsitem = mysql_query($query_rsitem, $core) or die(mysql_error());
$row_rsitem = mysql_fetch_assoc($rsitem);
$totalRows_rsitem = mysql_num_rows($rsitem);
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
		} else if (document.form1.cmbMCatg.value = "") {
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
<?php { include "../../dateformat_funct.php"; include "uploads.php"; } ?>
<b>Edit Item</b>
<br /><br />

<form action="<?php echo $editFormAction; ?>"  method="POST" name="form1" class="General" id="form1">
  <table width="550" border="0">
    <tr>
      <td width="100" class="General">Category</td>
      <td width="8">:</td>
      <td width="276">
      <select name="cmbMCatg" id="cmbMCatg">
        <!-- <option value="">- Choose Category of Item -</option> -->
        <?php do { ?>
        <option value="<?php echo $row_rsmcatg['id_mcatg']; ?>" <?php if ($row_rsmcatg['id_mcatg'] == $row_rsitem['id_mcatg']) { ?> selected="selected" <?php } ?>> <?php echo $row_rsmcatg['mcatg_descr']; ?></option>
        <?php } while ($row_rsmcatg = mysql_fetch_assoc($rsmcatg)); ?>
      </select>
      &nbsp;&nbsp;<img src="../../images/loading.gif" width="18" id="imgLoad" style="display:none;" />
      </td>
    </tr>
    <tr>
      <td class="General">Subcategory      
      <input name="id_subcatg" type="hidden" id="id_subcatg" /></td>
      <td>:</td>
      <td>
      <select name="cmbSubcatg" id="cmbSubcatg" onchange="showData(this.value)">
        <option value="<?php echo $row_rsitem['id_msubcatg']; ?>"><?php echo $row_rsitem['msubcatg_descr']; ?></option>
        <option value="">- Choose Subcategory -</option>
      </select>
      &nbsp;&nbsp;<img src="../../images/loading.gif" width="18" id="imgLoadMerk" style="display:none;" />
      </td>
    </tr>
    <tr>
      <td class="General">Name of Item</td>
      <td>:</td>
      <td>
      <select name="cmbModel" id="cmbModel">
        <option value="<?php echo $row_rsitem['id_mmodel']; ?>"><?php echo $row_rsitem['mtrl_model']; ?></option>
        <option value="">- Choose Name of Item -</option>
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="General">&nbsp;</td>
      <td>
      	<div id="txtHint">
        	Item Code : <input type="text" id="kode" name="kode" value="<?php echo $row_rsitem['item_code']; ?>" />
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="3" class="General"><b>Description of Item</b> <input name="iditem" type="hidden" id="iditem" value="<?php echo $row_rsitem['id_item']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Description</td>
      <td>:</td>
      <td><textarea cols="50" rows="3" name="itemdescr" id="itemdescr"><?php echo $row_rsitem['descr_name']; ?></textarea></td>
    </tr>
    <tr>
      <td class="General">Specification</td>
      <td>:</td>
      <td><textarea cols="50" rows="3" name="itemspec" id="itemspec"><?php echo $row_rsitem['descr_spec']; ?></textarea></td>
    </tr>
    <tr>
      <td class="General">Brand</td>
      <td>:</td>
      <td><input type="text" name="brand" size="30" value="<?php echo $row_rsitem['brand']; ?>" /></td>
    </tr>
    <tr>
      <td class="General">Unit</td>
      <td>:</td>
      <td>
        <select name="cmbunit" id="cmbunit">
          <?php
		do {  
		?>
          <option value="<?php echo $row_rsunit['id_unit']?>" <?php if ($row_rsunit['id_unit'] == $row_rsitem['id_unit']) { ?> selected="selected" <?php } ?>><?php echo $row_rsunit['unit']?></option>
          <?php
		} while ($row_rsunit = mysql_fetch_assoc($rsunit));
		  $rows = mysql_num_rows($rsunit);
		  if($rows > 0) {
			  mysql_data_seek($rsunit, 0);
			  $row_rsunit = mysql_fetch_assoc($rsunit);
		  }
?>
        </select>
      <a href="inputunit.php?data=<?php echo $row_rssubcatg['id_msubcatg']; ?>">Input Unit</a></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="pricepu" type="hidden" id="pricepu" size="15" /></td>
    </tr>
    
    <tr>
      <td colspan="3" align="center"><input type="submit" name="SUBMIT" id="SUBMIT" value="Save" onClick="return periksa();" /></td>
    </tr>
    <tr>
      <td colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><b><i>Last Updated</i></b></td>
      <td valign="bottom"><b>on</b></td>
      <td valign="bottom"><b><?php echo functddmmmyyyy($row_rsitem['last_updated']); ?></b></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top"><b>by</b></td>
      <td valign="top"><b><?php echo $row_rsitem['fname']; ?> <?php echo $row_rsitem['mname']; ?> <?php echo $row_rsitem['lname']; ?></b></td>
    </tr>
  </table>
  
	<input type="hidden" name="nama_fileps" id="nama_fileps" value="<?php echo $nama_file;?>"/>
    <input name="id_departemen" type="hidden" id="id_departemen" value="PPIC"/>
    <input type="hidden" name="idms" id="idms" value="<?php echo $nextpracode; ?>" />
    <input type="hidden" name="MM_update" value="form1" />
</form>

</p>
</body>
</html>
<?php
	mysql_free_result($rsmcatg);
	mysql_free_result($rsunit);
	mysql_free_result($rsitem);
?>