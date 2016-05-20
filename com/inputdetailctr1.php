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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE c_ctr_detailklo SET totalwovalue=%s WHERE idctr=%s",
                       GetSQLValueString($_POST['jumlah'], "int"),
                       GetSQLValueString($_POST['idctr'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT id, ctrno, projectcode, dateest, projecttitle, requestor FROM c_ctr WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset2 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset2 = sprintf("SELECT * FROM c_ctr_detailklo WHERE idctr = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>

	<link href="../css/metro-bootstrap.css" rel="stylesheet">
    <link href="../css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/docs.css" rel="stylesheet">
    <link href="../js/prettify/prettify.css" rel="stylesheet">
    
    <!-- Load JavaScript Libraries -->
    <script src="../js/jquery/jquery.min.js"></script>
    <script src="../js/jquery/jquery.widget.min.js"></script>
    <script src="../js/jquery/jquery.mousewheel.js"></script>
    <script src="../js/prettify/prettify.js"></script>

    <!-- Local JavaScript -->
    <script src="../js/metro/metro-loader.js"></script>
    <!-- Local JavaScript -->
    <script src="../js/docs.js"></script>
    <script src="../js/github.info.js"></script>
    
</head>

<body class="metro">


<!-- This Header -->
<form>
<div class="grid">
	
    <div class="row">
    
    	<div class="span3"><h2> <img src="../images/chevron.png" alt="Chevron Logo" longdesc="http://erp.btubpn.com">
       Input CTR 
       </h2>
       </div>
       
       
        <div class="span5">       
       <fieldset><h3 align="center"> <?php echo $row_Recordset1['projecttitle']; ?></h3>
       </fieldset>      
        </div>
        
      <div class="span2"><fieldset><h5 align="right"> CW number <?php echo $row_Recordset1['ctrno']; ?>/ US $ <?php echo $row_Recordset2['totalwovalue']; ?></h5></fieldset></div>
    	
    </div>
    
</div>

</form>
<!-- This Header -->


<!-- This Input content -->

<div class="page-region>
<div class="page-region-content>
<form>
	<div class="span10">
    <div class="grid">
    <div class="row">
	<div class="span5">

        	<table class="table">
    <thead>
    <tr>
    <td>Project</td>
    <td>:</td>
    <td><?php echo $row_Recordset1['projecttitle']; ?></td>
    </tr>
    <tr>
      <td>PL</td>
      <td>:</td>
      <td><?php echo $row_Recordset1['requestor']; ?></td>
    </tr>
    <tr>
      <td>Drawing</td>
      <td>:</td>
      <td><div class="input-control text span3" data-role="input-control">
            	<input type="text" placeholder="Drawing Number <?php echo $row_Recordset2['drawingnumber']; ?>">
				<button class="btn-clear"></button>
            </div></td>
    </tr>
    <tr>
    <td>AFE/CC</td>
    <td>:</td>
    <td><div class="input-control text span3" data-role="input-control">
            	<input type="text" placeholder=" AFE/CC <?php echo $row_Recordset2['afecc']; ?>">
				<button class="btn-clear"></button> 
            </div></td>
    </tr>
    </thead>
    </table>             
               	
	</div>
    <div class="span5"  align="right">
	
    <div class="span2">
    </div>
    
    <div class="span3">
    <table class="table bordered">
    <thead>
    <tr>
    <td>CTR No :</td>
    <td><?php echo $row_Recordset1['ctrno']; ?></td>
    </tr>
    <tr>
    <td>DATE :</td>
    <td><?php echo $row_Recordset1['dateest']; ?></td>
    </tr>
    </thead>
    </table>
	</div>
    
    </div>
    
    </div> 
    </div>
   			
    </div>
  </form>
</div>
</div>
<!-- This Input Content -->

<!-- This Tabular Input Data -->
 <div class="span10">
 <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
    <table class="table bordered">
    <thead>
    <tr>
    <td>NO</td>
    <td>DESCRIPTION <input type="text" name="idctr" id="idctr" class="hide" value="<?php echo $row_Recordset2['idctr']; ?>"></td>
    <td>SUB PRICE (US $)</td>
    <td>TOTAL PRICE (US $)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="info">
      <td align="center">1</td>
      <td><div class="span5">Engineering Services</div></td>
      <td>&nbsp;</td>
      <td><?php
$a=$_POST[angka1]+$_POST[angka2];
echo $a;
?>
</td>
    </tr>
    <tr>
    <td align="center">1.1</td>
    <td>Engineering Services</td>
    <td>
    <div class="input-control text span2" data-role="input-control">
      <input type="text" value="<?php echo $row_Recordset2['engineeringservices']; ?>" placeholder="SUB PRICE US $" name="angka1" >
      <button class="btn-clear"></button>
    </div>      
        </td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">1.2</td>
    <td>Project Services</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" id="type2" value="<?php echo $row_Recordset2['projectservices']; ?>" placeholder="SUB PRICE US $" name="angka2" >
                <button class="btn-clear"></button>
        </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">2</td>
    <td>Structures</td>
    <td>&nbsp;</td>
    <td><?php
$b=$_POST[angka3]+$_POST[angka4]+$_POST[angka5]+$_POST[angka6];
echo $b?></td>
    </tr>
    <tr>
    <td align="center">2.1</td>
    <td>Total Material Supply</td>
    <td><div class="input-control text span2" data-role="input-control">
      <input type="text" value="<?php echo $row_Recordset2['structurestotalmaterialsupply']; ?>" placeholder="SUB PRICE US $" name="angka3">
      <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">2.2</td>
    <td>Total Fabrication</td>
    <td><div class="input-control text span2" data-role="input-control">
      <input type="text" value="<?php echo $row_Recordset2['structurestotalfabrication']; ?>" placeholder="SUB PRICE US $" name="angka4">
      <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">2.3</td>
    <td>Total Instalation</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['structurestotalinstallation']; ?>" placeholder="SUB PRICE US $" name="angka5">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">2.4</td>
    <td>Total Painting</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['structurestotalpainting']; ?>" placeholder="SUB PRICE US $" name="angka6">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">3</td>
    <td>Pipings, Fitting and Valves</td>
    <td>&nbsp;</td>
    <td><?php $c=$_POST[angka7]+$_POST[angka8]+$_POST[angka9]+$_POST[angka10];
 echo $c ?></td>
    </tr>
    <tr>
    <td align="center">3.1</td>
    <td>Total Material Supply</td>
    <td><div class="input-control text span2" data-role="input-control">
      <input type="text" value="<?php echo $row_Recordset2['pipingtotalmaterialsupply']; ?>" placeholder="SUB PRICE US $" name="angka7">
      <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">3.2</td>
    <td>Total Fabrication</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['pipingtotalfabrication']; ?>" placeholder="SUB PRICE US $" name="angka8">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">3.3</td>
    <td>Total Instalation</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['pipingtotalinstallation']; ?>" placeholder="SUB PRICE US $" name="angka9">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">3.4</td>
    <td>Total Painting</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['pipingtotalpainting']; ?>" placeholder="SUB PRICE US $" name="angka10">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">4</td>
    <td>Electrical</td>
    <td>&nbsp;</td>
    <td><?php $d=$_POST[angka11]+$_POST[angka12];
 echo $d ?></td>
    </tr>
    <tr>
    <td align="center">4.1</td>
    <td>Total Material Supply</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['electricaltotalmaterialsupply']; ?>" placeholder="SUB PRICE US $" name="angka11">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">4.2</td>
    <td>Total Installation</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['electricaltotalinstallation']; ?>" placeholder="SUB PRICE US $" name="angka12">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">5</td>
    <td>Instrumentation</td>
    <td>&nbsp;</td>
    <td><?php $e=$_POST[angka13]+$_POST[angka14];
 echo $e ?></td>
    </tr>
    <tr>
    <td align="center">5.1</td>
    <td>Total Material Suply</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['instrumentationtotalmaterialsupply']; ?>" placeholder="SUB PRICE US $" name="angka13">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">5.2</td>
    <td>Total Installation</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['instrumentationtotalinstallation']; ?>" placeholder="SUB PRICE US $" name="angka14">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">6</td>
    <td>PWHT</td>
    <td></td>
    <td><?php $f=$_POST[angka15];
echo $f ?></td>
    </tr>
    <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="input-control text span2" data-role="input-control">
      <input type="text" value="<?php echo $row_Recordset2['pwht']; ?>" placeholder="SUB PRICE US $" name="angka15">
      <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">7</td>
    <td>NDT</td>
    <td>&nbsp;</td>
    <td><?php $g=$_POST[angka16];
 echo $g ?></td>
    </tr>
    <tr>
    <td><span class="input-control text span2">
      
    </span></td>
    <td>&nbsp;</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['ndt']; ?>" placeholder="SUB PRICE US $" name="angka16">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">8</td>
    <td>Transportation</td>
    <td>&nbsp;</td>
    <td><?php $h=$_POST[angka17];
echo $h ?></td>
    </tr>
    <tr>
    <td align="center">8.1</td>
    <td>Land Transportation</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['landtransportation']; ?>" placeholder="SUB PRICE US $" name="angka17">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">9</td>
    <td>Civil Work</td>
    <td>&nbsp;</td>
    <td><?php $i=$_POST[angka18];
 echo $i ?></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="input-control text span2" data-role="input-control">
      <input type="text" value="<?php echo $row_Recordset2['civilwork']; ?>" placeholder="SUB PRICE US $" name="angka18">
      <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">10</td>
    <td>Personel & Equipment Day Rate</td>
    <td>&nbsp;</td>
    <td><?php $j=$_POST[angka19]+$_POST[angka20];
echo $j ?></td>
    </tr>
    <tr>
    <td align="center">10.1</td>
    <td>Personel Day Rate</td>
    <td><div class="input-control text span2" data-role="input-control">
            	<input type="text" value="<?php echo $row_Recordset2['personeldayrate']; ?>" placeholder="SUB PRICE US $" name="angka19">
                <button class="btn-clear"></button>
            </div></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">10.2</td>
    <td>Equipment Day Rate</td>
    <td><div class="input-control text span2" data-role="input-control">
      <button class="btn-clear"></button>
            <input type="text" value="<?php echo $row_Recordset2['equipmentdayrate']; ?>" placeholder="SUB PRICE US $" name="angka20"></div></td>
    <td><?php $jumlah = $a+$b+$c+$d+$e+$f+$g+$h+$i+$j; ?></td>
    </tr>
    <tr class="warning">
      <td></td>
      <td>CTR Validity : 60 Days</td>
      <td align="right">Total WO Value</td>
      <td><div class="input-control text span2" data-role="input-control">
            <input style="background-color:#F60" type="text" value="<? echo $jumlah ?>" placeholder="TOTAL PRICE US $" name="jumlah">
      </div>
</td> 
   </tr>
    
    </thead>
    </table>
<div align="right">	  
    <input type="submit" name="submit" class="button success" value="=">
    <button class="button success">Submit</button>    
</div>
<input type="hidden" name="MM_update" value="form1">
</form>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
