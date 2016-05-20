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

$colname_sectionframe = "-1";
if (isset($_GET['header'])) {
  $colname_sectionframe = $_GET['header'];
}
mysql_select_db($database_core, $core);
$query_sectionframe = sprintf("SELECT id, framemodel, idheader FROM e_framemodel WHERE idheader = %s ORDER BY framemodel ASC", GetSQLValueString($colname_sectionframe, "text"));
$sectionframe = mysql_query($query_sectionframe, $core) or die(mysql_error());
$row_sectionframe = mysql_fetch_assoc($sectionframe);
$totalRows_sectionframe = mysql_num_rows($sectionframe);
?>
<table width="673">
	<tr>
    	<td width="673" align="left"><p>
        <?php if($totalRows_sectionframe==0){ echo "Empty..! <!--";} ?>
        	<?php do { ?>
       	    <button name="section" onClick="window.location.href='inputcorebom00.php?idframe=<?php echo $row_sectionframe['id']; ?>&data=<?php echo $_GET['data']; ?>&data2=<?php echo $_GET['data2']; ?>'"><?php echo $row_sectionframe['framemodel']; ?></button>
        	  <?php } while ($row_sectionframe = mysql_fetch_assoc($sectionframe)); ?>
        <?php if($totalRows_sectionframe==0){ echo "-->"; }?>
        </p></td>
    </tr>
</table>
<?php
mysql_free_result($sectionframe);
?>