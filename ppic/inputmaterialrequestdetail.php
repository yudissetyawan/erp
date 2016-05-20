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
  $insertSQL = sprintf("INSERT INTO m_masterndstatus (id_item, id_mr, id_mstat) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['cmbModel'], "int"),
                       GetSQLValueString($_POST['data'], "int"),
                       GetSQLValueString($_POST['cmbmstat'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO p_mr_core (itemmr, qty, unit, dateinuse, tobeuse, remark, mrheader) VALUES ( %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cmbModel'], "text"),
                       GetSQLValueString($_POST['qty'], "int"),
                       GetSQLValueString($_POST['unit'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['dateinuse']), "date"),
                       GetSQLValueString($_POST['tobeuse'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
					   GetSQLValueString($_POST['data'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "view_detailmrsr.php?data=".$row_Recordset4['id']. "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
$query_rscmbmcatg = "SELECT * FROM m_master_catg";
$rscmbmcatg = mysql_query($query_rscmbmcatg, $core) or die(mysql_error());
$row_rscmbmcatg = mysql_fetch_assoc($rscmbmcatg);
$totalRows_rscmbmcatg = mysql_num_rows($rscmbmcatg);

mysql_select_db($database_core, $core);
$query_rscmbmstat = "SELECT * FROM m_status";
$rscmbmstat = mysql_query($query_rscmbmstat, $core) or die(mysql_error());
$row_rscmbmstat = mysql_fetch_assoc($rscmbmstat);
$totalRows_rscmbmstat = mysql_num_rows($rscmbmstat);
?>

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
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
  
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
			document.getElementById("qty").focus();
		}
	}
	xmlhttp.open("GET","getforMR.php?q="+sid,true);
	xmlhttp.send();
}
</script>
<script type="text/javascript">
	function periksa() {
		if (document.form1.cmbMCatg.value == "") {
			alert("Select Category of Item");
			document.form1.cmbMCatg.focus();
			return false;
		} else if (document.form1.cmbSubcatg.value == "") {
			alert("Select Subcategory of Item");
			document.form1.cmbSubcatg.focus();
			return false;
		} else if (document.form1.cmbModel.value == "") {
			alert("Select Name of Item with Description");
			document.form1.cmbModel.focus();
			return false;
		} else if (document.form1.qty.value == "") {
			alert("Fill Qty");
			document.form1.qty.focus();
			return false;
		} else if (document.form1.dateinuse.value == "") {
			alert("Date in Use can't be empty");
			document.form1.dateinuse.focus();
			return false;
		} else if (document.form1.cmbmstat.value == "") {
			alert("Give Status of Item");
			document.form1.cmbmstat.focus();
			return false;
		}
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

<b>Add Item of Material / Service Request (M/S R)</b>
<br /><br />

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="700" border="0" class="General">
    <tr>
      <td width="150" class="General">Category
        <input name="data" type="hidden" id="data" value="<?php echo $row_Recordset4['id']; ?>" /></td>
      <td width="16">:</td>
      <td width="385">
        <select name="cmbMCatg" id="cmbMCatg">
          <option value="">- Choose Category of Item -</option>
          <?php do { ?>
          <option value="<?php echo $row_rscmbmcatg['id_mcatg']; ?>"> <?php echo $row_rscmbmcatg['mcatg_descr']; ?></option>
          <?php } while ($row_rscmbmcatg = mysql_fetch_assoc($rscmbmcatg)); ?>
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
      <td><textarea name="remark" id="remark" cols="50" rows="2" class="required" title="Remark is required"></textarea></td>
    </tr>
    <tr>
      <td class="General">Status of Item</td>
      <td>:</td>
      <td>
      <select name="cmbmstat" id="cmbmstat">
      <option value="">- Choose Status of Item -</option>
	  <?php
		do {  
		?>
			<option value="<?php echo $row_rscmbmstat['id_mstat']?>"><?php echo $row_rscmbmstat['m_status']?></option>
			<?php
		} while ($row_rscmbmstat = mysql_fetch_assoc($rscmbmstat));
		  $rows = mysql_num_rows($rscmbmstat);
		  if($rows > 0) {
			  mysql_data_seek($rscmbmstat, 0);
			  $row_rscmbmstat = mysql_fetch_assoc($rscmbmstat);
		  }
		?>
      </select></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>&nbsp;</td>
      <td>
          <!-- <input type="hidden" name="statusitemmr" id="statusitemmr" value="Open" />
          <input type="hidden" name="noteitemmr" id="noteitemmr" value="Making Request" /> -->
      </td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General"><input name="mrheader" type="hidden" id="mrheader" value="<?php echo $row_rscmbunit['id']; ?>" />
          <input type="submit" name="submit" id="submit" value="Add to MR" onClick="return periksa();" />
</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

</body>
</html>
<?php
	mysql_free_result($rscmbmstat);
	mysql_free_result($rscmbunit);
	mysql_free_result($Recordset4);
	mysql_free_result($rscmbmcatg);
?>