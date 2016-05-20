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
  $updateSQL = sprintf("UPDATE a_crf_schedulle SET drawingprogress=%s, file_drawing=%s WHERE crf=%s",
                       GetSQLValueString($_POST['drawingprogress'], "text"),
                       GetSQLValueString($_POST['file_drawing'], "text"),
                       GetSQLValueString($_POST['nocrfdrawing'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_crf WHERE nocrf = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$tanggal=date("d M Y");
?>
<html>
<head>
  <title>EasyTabs Demo</title>
  <script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script> 
  <script src="../js/jquery.hashchange.min.js" type="text/javascript"></script>
  <script src="../library/jquery.easytabs.min.js" type="text/javascript"></script>

  <style>
    /* Example Styles for Demo */
    .etabs { margin: 0; padding: 0; }
    .tab { display: inline-block; zoom:1; *display:inline; background: #eee; border: solid 1px #999; border-bottom: none; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; }
    .tab a { font-size: 14px; line-height: 2em; display: block; padding: 0 10px; outline: none; }
    .tab a:hover { text-decoration: underline; }
    .tab.active { background: #fff; padding-top: 6px; position: relative; top: 1px; border-color: #666; }
    .tab a.active { font-weight: bold; }
    .tab-container .panel-container { background: #fff; border: solid #666 1px; padding: 10px; -moz-border-radius: 0 4px 4px 4px; -webkit-border-radius: 0 4px 4px 4px; }
    .panel-container { margin-bottom: 10px; }
  </style>
  <script type="text/javascript">
    $(document).ready( function() {
      $('#tab-container').easytabs();
    });
  </script>
<link href="/css/induk.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: none;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style></head>
<body>

 
<div id="tab-container" class='tab-container'>
 <ul class='etabs'>
   <li class='tab'><a href="#tabs1-dinput">Design Input</a></li>
   <li class='tab'><a href="#tabs1-dcalculation">Design Calculation</a></li>
   <li class='tab'><a href="#tabs1-dreview">Design Review</a></li>
   <li class='tab'><a href="#tabs1-drawing">Drawing</a></li>
 </ul>
 <div class='panel-container'>
  <div id="tabs1-dinput">
   <link href="../css/induk.css" rel="stylesheet" type="text/css" />
   <form method="POST" enctype="multipart/form-data" name="form" class="General">
     <table width="700" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td class="General">
Attachment File:
  <input name="file" type="file" style="cursor:pointer;" />
  <input type="submit" name="submit" value="Upload" /></td>
      </tr>
    </table><p>
      <input type="text" name="drawingprogress1" id="drawingprogress1">
      <input type="text" name="nocrf" id="nocrf">
      <input type="text" name="file_drawing1" id="file_drawing1" >
    </form>
  </div>
   <div id="tabs1-dcalculation">
   <h2>TAB 2</h2>

  </div>
  <div id="tabs1-dreview">
   <h2>TAB 3    </h2>
   <code>  </code>

  </div>
   <div id="tabs1-drawing">
   <?php {include "uploadfile.php";}?>
   <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
     <input type="text" name="drawingprogress" id="drawingprogress" value="<?php echo $tanggal;?>" />
     <input name="nocrfdrawing" type="text" id="nocrfdrawing" value="<?php echo $row_Recordset1['nocrf']; ?>" />
     <input type="text" name="file_drawing" id="file_drawing" value="<?php echo $nama_file;?>" />
     <input type="submit" name="submit3" id="submit" value="Submit" />
     <input type="hidden" name="MM_update" value="form1" />
   </form>
   <h2>&nbsp;</h2>

  </div>
 </div>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>
