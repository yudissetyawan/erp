<?php require_once('../Connections/core.php'); 
if (!isset($_SESSION)) {
  session_start();
}

if(isset($_GET['data'])) $data00=explode('-',$_GET['data']); else $data00='';
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO e_header_bom (drawingno, createdby, location, customer, projectcode, productioncode, revision, checkedby, approvedby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['drawingno'], "text"),
                       GetSQLValueString($_POST['createdby'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['production'], "text"),
                       GetSQLValueString($_POST['revision'], "text"),
                       GetSQLValueString($_POST['checkedby'], "text"),
                       GetSQLValueString($_POST['approvedby'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  mysql_select_db($database_core, $core);
  $query_a = sprintf("SELECT * FROM e_header_bom WHERE drawingno= %s AND createdby= %s AND location= %s AND customer= %s AND projectcode= %s AND productioncode= %s AND revision = %s AND checkedby = %s AND approvedby= %s",
                       GetSQLValueString($_POST['drawingno'], "text"),
                       GetSQLValueString($_POST['createdby'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['projectcode'], "text"),
                       GetSQLValueString($_POST['production'], "text"),
                       GetSQLValueString($_POST['revision'], "text"),
                       GetSQLValueString($_POST['checkedby'], "text"),
                       GetSQLValueString($_POST['approvedby'], "text"));
  $Reca = mysql_query($query_a, $core) or die(mysql_error());
  $row_Reca = mysql_fetch_assoc($Reca);
  $totalRows_Reca = mysql_num_rows($Reca);
 
  $insertGoTo = "editbom.php?data=".$row_Reca['id']."";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 =  sprintf("SELECT a.customername,a.id FROM a_customer a JOIN a_crf b ON a.customername=b.customer WHERE b.nocrf=%s",GetSQLValueString($_GET['data'], "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset6 = "SELECT * FROM h_employee WHERE username = '".$_SESSION['MM_Username']."'";
$Recordset6 = mysql_query($query_Recordset6, $core) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM h_employee WHERE username != '".$_SESSION['MM_Username']."'";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM a_proj_code WHERE project_code= '".$data00[1]."' ";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT * FROM a_production_code WHERE productioncode= '".$data00[2]."' ";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_core, $core);
$query_Recordset5 = "SELECT * FROM e_drawing_file";
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Input Bom</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/jquiuni.css" rel="stylesheet"  />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="../css/token-input.css" type="text/css" />
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="General" id="form1">
  <table width="625" border="0" class="General">
    <tr>
      <td width="124" class="General">Drawing Number</td>
      <td width="20">:</td>
      <td width="467"><select name="drawingno" id="drawingno" class="required" title="Please select Drawing Number" >
      <option value="">-- Pilih Drawing Number --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset5['id'] ?>"><?php echo $row_Recordset5['drawingno'] ?></option>
        <?php
} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
  $rows = mysql_num_rows($Recordset5);
  if($rows > 0) {
      mysql_data_seek($Recordset5, 0);
	  $row_Recordset5 = mysql_fetch_assoc($Recordset5);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Created By</td>
      <td>:</td>
      <td><input type="hidden" name="createdby" id="createdby" class="required" value="<?php echo $row_Recordset6['id'] ?>"><?php echo $row_Recordset6['firstname']; echo " "; echo $row_Recordset6['lastname'];?>
    </tr>
    <tr>
      <td class="General">Location</td>
      <td>:</td>
      <td><input type="text" name="location" id="location" class="required" title="Location is required" /></td>
    </tr>
    <tr>
      <td class="General">Customer</td>
      <td>:</td>
      <td><input type="hidden" name="customer" id="customer" class="required" value="<?php echo $row_Recordset1['id'] ?>"><?php echo $row_Recordset1['customername'] ?></td>
    </tr>
    <tr>
      <td class="General">Project Code</td>
      <td>:</td>
      <td><input type="hidden" name="projectcode" id="projectcode" class="required" value="<?php echo $row_Recordset3['project_code'] ?>" onChange="viewProduction()" ><?php echo $row_Recordset3['project_code'] ?>
      </td>
    </tr>
    <tr>
      <td class="General">Production Code</td>
      <td>:</td>
      <td><input type="hidden" name='production' id='production' value="<?php echo $row_Recordset4['productioncode'] ;?>"><?php echo $row_Recordset4['productioncode'] ;?></td>
    </tr>
    <tr>
      <td class="General">Revision</td>
      <td>:</td>
      <td><input type="text" name="revision" id="revision" class="required" title="Revision is required" /></td>
    </tr>
    <tr>
      <td class="General">Checked By</td>
      <td>:</td>
      <td><select name="checkedby" id="checkedby" class="required" title="Please select checked by">
      <option value="">-- Pilih Checked By --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id'] ?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td class="General">Approved By</td>
      <td>:</td>
      <td><select name="approvedby" id="approvedby" class="required" title="Please select required by">
      <option value="">-- Pilih Approved by --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Recordset2['id'] ?>"><?php echo $row_Recordset2['firstname']; echo " "; echo $row_Recordset2['lastname'];?></option>
        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td><input name="submit" type="submit" value="submit" /></td>
    </tr>
  </table>
  <input type="hidden" name="jumM" id="jumM" value="" />
  <p>
    <input type="hidden" name="MM_insert" value="form1"/>
  </p>
</form>


<div id="mydiv-jonh" class="mydiv">
    <input type="button" value="tambah"
</div>
<script>
    $('.mydiv').click(function(){
    window.open(' /chatwindow/?user='+$(this).attr('id').replace('mydiv-',''), '_blank', 'width=800,height=600');
    return false;
    });
</script>


</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset5);

mysql_free_result($Recordset6);

mysql_free_result($Recordset4);
?>
