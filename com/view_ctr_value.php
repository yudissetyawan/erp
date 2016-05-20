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

$colname_Recordset3 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset3 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset3 = sprintf("SELECT * FROM c_total_ctr WHERE id_ctr = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Detail CTR</title>

	<link href="../css/metro-bootstrap.css" rel="stylesheet">
    <link href="../css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/docs.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet">
    
    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/prettify/prettify.js"></script>

    <!-- Local JavaScript -->
    <script src="js/metro/metro-loader.js"></script>
    <!-- Local JavaScript -->
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>
</head>

<body class="metro">
.
<div class="page">


<!-- This Header -->

<form>
<div class="grid">
	
    <div class="row">
    
    	<div class="span3">
    	  <h2> <img src="../images/chevron.png" alt="Chevron Logo" longdesc="http://erp.btubpn.com">
       Detail CTR 
       </h2>
       </div>
       
       
        <div class="span5">       
       <fieldset><h3 align="center"> <?php echo $row_Recordset1['projecttitle']; ?> </h3>
       </fieldset>      
        </div>
        
      <div class="span2"><fieldset><h5 align="right"> CW number  <?php echo $row_Recordset1['ctrno']; ?>/ US$ <?php echo $row_Recordset2['totalwovalue']; ?></h5>
      </fieldset></div>
    	
    </div>
    
</div>


<!-- This Header -->


<!-- This Input content -->



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
            <td><?php echo $row_Recordset2['drawingnumber']; ?></td>
            </tr>
          <tr>
            <td>AFE/CC</td>
            <td>:</td>
            <td><?php echo $row_Recordset2['afecc']; ?></td>
            </tr>
          </thead>
        </table>
        <p class="hide">
<div class="listview hide">
    <a href="com/edit_detailctr.php?data=<?php echo $row_Recordset1['id']; ?>" class="list">
        <div class="list-content">
            <img src="../images/Notebook-Save.png" class="icon">
            <div class="data">
                <span class="list-title">Click Here To Edit</span>
                <span class="list-subtitle">CTR NO :<?php echo " ",$row_Recordset1['ctrno']; ?></span>
                <span class="list-remark">Price: $<?php echo $row_Recordset3['total_wovalue']; ?></span>
            </div>
        </div>       
    </a>
	</div>    
      
      </div>
    <div class="span5"  align="right">
      
      <div class="span1">
        </div>
      
      <div class="span4">
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
          
<div class="listview">
    <a href="../com/edit_detailctr.php?data=<?php echo $row_Recordset1['id']; ?>" class="list">
        <div class="list-content">
            <img src="../images/Notebook-Save.png" class="icon">
            <div class="data">
                <span class="list-title">Click Here To Revise</span>
                <span class="list-subtitle">CTR NO :<?php echo " ",$row_Recordset1['ctrno']; ?></span>
                <span class="list-remark">Price: $<?php echo number_format(  $row_Recordset2['totalwovalue'],2 ); ?></span>
            </div>
        </div>
    </a>
	</div>      </div>
    
    </div>
  
</div>            


<!-- This Input Content -->

<!-- This Tabular Input Data -->

 <div class="span10">
    <table class="table bordered" >
    <thead>
    <tr>
    <td>NO</td>
    <td>DESCRIPTION</td>
    <td>SUB PRICE (US $)</td>
    <td>TOTAL PRICE (US $)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="info">
      <td align="center">1</td>
      <td><div class="span5">Engineering Services</div></td>
      <td>&nbsp;</td>
      <td><?php echo number_format(  $row_Recordset3['total_eng'],2); ?></td>
    </tr>
    <tr>
    <td align="center">1.1</td>
    <td>Engineering Services</td>
    <td><?php echo number_format(  $row_Recordset2['engineeringservices'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">1.2</td>
    <td>Project Services</td>
    <td><?php echo number_format(  $row_Recordset2['projectservices'],2); ?></td>
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
    <td><?php echo number_format(  $row_Recordset3['total_stuc'],2); ?></td>
    </tr>
    <tr>
    <td align="center">2.1</td>
    <td>Total Material Supply</td>
    <td><?php echo number_format(  $row_Recordset2['structurestotalmaterialsupply'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">2.2</td>
    <td>Total Fabrication</td>
    <td><?php echo number_format(  $row_Recordset2['structurestotalfabrication'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">2.3</td>
    <td>Total Instalation</td>
    <td><?php echo number_format(  $row_Recordset2['structurestotalinstallation'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">2.4</td>
    <td>Total Painting</td>
    <td><?php echo number_format(  $row_Recordset2['structurestotalpainting'],2); ?></td>
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
    <td><?php echo number_format(  $row_Recordset3['total_pipings'],2); ?></td>
    </tr>
    <tr>
    <td align="center">3.1</td>
    <td>Total Material Supply</td>
    <td><?php echo number_format(  $row_Recordset2['pipingtotalmaterialsupply'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">3.2</td>
    <td>Total Fabrication</td>
    <td><?php echo number_format(  $row_Recordset2['pipingtotalfabrication'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">3.3</td>
    <td>Total Instalation</td>
    <td><?php echo number_format(  $row_Recordset2['pipingtotalinstallation'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">3.4</td>
    <td>Total Painting</td>
    <td><?php echo number_format(  $row_Recordset2['pipingtotalpainting'],2); ?></td>
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
    <td><?php echo number_format(  $row_Recordset3['total_elect'],2); ?></td>
    </tr>
    <tr>
    <td align="center">4.1</td>
    <td>Total Material Supply</td>
    <td><?php echo number_format(  $row_Recordset2['electricaltotalmaterialsupply'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">4.2</td>
    <td>Total Installation</td>
    <td><?php echo number_format(  $row_Recordset2['electricaltotalinstallation'],2); ?></td>
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
    <td><?php echo number_format(  $row_Recordset3['total_instrument'],2); ?></td>
    </tr>
    <tr>
    <td align="center">5.1</td>
    <td>Total Material Suply</td>
    <td><?php echo number_format(  $row_Recordset2['instrumentationtotalmaterialsupply'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">5.2</td>
    <td>Total Installation</td>
    <td><?php echo number_format(  $row_Recordset2['instrumentationtotalinstallation'],2); ?></td>
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
    <td><?php echo number_format(  $row_Recordset3['total_pwht'],2); ?></td>
    </tr>
    <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo number_format(  $row_Recordset2['pwht'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">7</td>
    <td>NDT</td>
    <td>&nbsp;</td>
    <td><?php echo number_format(  $row_Recordset3['total_ndt'],2); ?></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo number_format(  $row_Recordset2['ndt'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">8</td>
    <td>Transportation</td>
    <td>&nbsp;</td>
    <td><?php echo number_format(  $row_Recordset3['total_transport'],2); ?></td>
    </tr>
    <tr>
    <td align="center">8.1</td>
    <td>Land Transportation</td>
    <td><?php echo number_format(  $row_Recordset2['landtransportation'],2); ?></td>
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
    <td><?php echo number_format(  $row_Recordset3['total_civil'],2); ?></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo number_format(  $row_Recordset2['civilwork'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr class="info">
    <td align="center">10</td>
    <td>Personel & Equipment Day Rate</td>
    <td>&nbsp;</td>
    <td><?php echo number_format(  $row_Recordset3['total_personel'],2); ?></td>
    </tr>
    <tr>
    <td align="center">10.1</td>
    <td>personel Day Rate</td>
    <td><?php echo number_format(  $row_Recordset2['personeldayrate'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td align="center">10.2</td>
    <td>Equipment Day Rate</td>
    <td><?php echo number_format(  $row_Recordset2['equipmentdayrate'],2); ?></td>
    <td>&nbsp;</td>
    </tr>
    
    <tr class="warning">
    <td></td>
    <td>CTR Validity : 60 Days</td>
    <td align="right">Total WO Value</td>
    <td><?php echo number_format(  $row_Recordset2['totalwovalue'],2 ); ?></td>
    </tr>
    
    </thead>
    </table>
   
            
    </div>
   </form> 
       
</div>    
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
