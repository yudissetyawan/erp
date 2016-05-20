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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO p_mr_core (`description`, spec, qty, unit, tobeuse, remark, mrheader) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cmbSubcatg'], "text"),
                       GetSQLValueString($_POST['cmbModel'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "text"),
                       GetSQLValueString($_POST['tobeuse'], "date"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($_POST['data'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "../ppic/view_detailmrsr.php?data=" . $row_Recordset4['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM m_e_type ORDER BY mtrl_type ASC";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT m_master_2.*, m_e_model.id_mmodel, m_e_model.mtrl_model FROM m_master_2, m_e_model WHERE m_master_2.id_mmodel = m_e_model.mtrl_model";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM m_unit";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset4 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset4 = sprintf("SELECT * FROM p_mr_header WHERE id = %s", GetSQLValueString($colname_Recordset4, "int"));
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_core, $core);
$query_Recordset5 = "SELECT m_master_2.*, m_e_model.id_mmodel, m_e_model.mtrl_model FROM m_master_2, m_e_model WHERE m_master_2.id_mmodel = m_e_model.mtrl_model AND m_e_model.id_mmodel='$id_mmodel' ";
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_core, $core);
$query_Recordset6 = "SELECT * FROM m_master_catg";
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_core, $core);
$query_Recordset7 = "SELECT * FROM m_master_subcatg";
$Recordset7 = mysql_query($query_Recordset7, $core) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

mysql_select_db($database_core, $core);
$query_Recordset8 = "SELECT * FROM m_master";
$Recordset8 = mysql_query($query_Recordset8, $core) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);
?>

<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../js/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form1").validate({
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>

<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entry M/S Request Detail</title>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.datatables.js"></script>
<script type="text/javascript" src="/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
  
<!-- Script Ajax untuk Mengontrol Dropdown List Bertingkat -->
<script type="text/javascript">
$(function() {
     $("#cmbMCatg").change(function(){
          $("img#imgLoad").show();
          var idMCatg = $(this).val();
 
          $.ajax({
             type: "POST",
             dataType: "html",
             url: "allmtrl/getSubcatg.php",
             data: "idMCatg="+idMCatg,
             success: function(msg){
                 if(msg == ''){
                         $("select#cmbSubcatg").html('<option value="">- Choose Subcategory -</option>');
                         $("select#cmbModel").html('<option value="">- Choose Name of Item -</option>');
                 } else {
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
             url: "allmtrl/getSpec.php",
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
function showItem(sid) {
	//alert (sid);
	if (sid == "") {
	  document.getElementById("divItemSpec").innerHTML="";
	  return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("divItemSpec").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","getforMR.php?q="+sid,true);
	xmlhttp.send();
}
</script>

</head>

<body class="General">
<?php { include "../date.php"; }
    // requires the class
    require "../menu_assets/class.datepicker.php";
    
    // instantiate the object
    $db=new datepicker();
    
    // uncomment the next line to have the calendar show up in german
    //$db->language = "dutch";
    
    $db->firstDayOfWeek = 1;

    // set the format in which the date to be returned
    $db->dateFormat = "Y-m-d";
?>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="620" border="0" class="General">
    <tr>
      <td width="200" class="General">Category
        <input name="data" type="hidden" id="data" value="<?php echo $row_Recordset4['id']; ?>" /></td>
      <td width="10">:</td>
      <td width="410">
        <select name="cmbMCatg" id="cmbMCatg">
          <option value="">- Choose Category of Item -</option>
          <?php do { ?>
          <option value="<?php echo $row_Recordset6['id_mcatg']; ?>"> <?php echo $row_Recordset6['mcatg_descr']; ?></option>
          <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
        </select>
        &nbsp;&nbsp;<img src="/images/loading.gif" width="18" id="imgLoad" style="display:none;" />
        </td>
    </tr>
    <tr>
      <td class="General">Subcategory</td>
      <td width="16">&nbsp;</td>
      <td><select name="cmbSubcatg" id="cmbSubcatg">
        <option value="">- Choose Subcategory -</option>
      </select>
      &nbsp;&nbsp;<img src="/images/loading.gif" width="18" id="imgLoadMerk" style="display:none;" />
      </td>
    </tr>
    <tr>
      <td class="General">Name of Item [ Description ]</td>
      <td>:</td>
      <td><select name="cmbModel" id="cmbModel" onChange="showItem(this.value)">
        <option value="">- Choose Name of Item -</option>
      </select></td>
    </tr>
    
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      	<div id="divItemSpec">
            
        </div>
      </td>
    </tr>

    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="General">Qty</td>
      <td>:</td>
      <td><input type="text" name="qty" id="qty" class="required" title="Quantity is required" />
        <select name="unit" id="unit" class="required" title="Pilih Unit">
          <option value="">-- Pilih Unit --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['unit']?>"><?php echo $row_Recordset3['unit']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select>
        <a href="../ppic/inputunit.php">Input Unit</a></td>
    </tr>
    <tr>
      <td class="General">Date In Use</td>
      <td>:</td>
      <td><input name="dateinuse" type="text" id="tanggal1" class="required" title="Please select date in use"/></td>
    </tr>
    <tr>
      <td class="General">To Be Use</td>
      <td>:</td>
      <td><input name="tobeuse" type="text" id="tobeuse" class="required" title="Please select to be use" size="52" /></td>
    </tr>
    <tr>
      <td class="General">Remark</td>
      <td>:</td>
      <td><textarea name="remark" id="remark" cols="40" rows="4" class="required" title="Remark is required"></textarea></td>
    </tr>
    <tr>
      <td align="center" colspan="3" class="General"><input name="mrheader" type="hidden" id="mrheader" value="<?php echo $row_Recordset3['id']; ?>" />
      <input type="submit" name="submit" id="submit" value="Submit" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset7);

mysql_free_result($Recordset8);
?>
