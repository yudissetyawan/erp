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

$colname_framemodel = "-1";
if (isset($_GET['idframe'])) {
  $colname_framemodel = $_GET['idframe'];
}
mysql_select_db($database_core, $core);
$query_framemodel = sprintf("SELECT * FROM e_framemodel WHERE id = %s", GetSQLValueString($colname_framemodel, "int"));
$framemodel = mysql_query($query_framemodel, $core) or die(mysql_error());
$row_framemodel = mysql_fetch_assoc($framemodel);
$totalRows_framemodel = mysql_num_rows($framemodel);
?>
<script>
	function calculateForm(){
		<?php if($row_framemodel['t3'] != ""){ ?>
		var t3 = document.getElementById("t3").value;
		<?php } ?>
		<?php if($row_framemodel['t2'] != ""){ ?>
		var t2 = document.getElementById("t2").value;
		<?php } ?>
		<?php if($row_framemodel['tf'] != ""){ ?>
		var tf = document.getElementById("tf").value;
		<?php } ?>
		<?php if($row_framemodel['tw'] != ""){ ?>
		var tw = document.getElementById("tw").value;
		<?php } ?>
		<?php if($row_framemodel['t2b'] != ""){ ?>
		var t2b = document.getElementById("t2b").value;
		<?php } ?>
		<?php if($row_framemodel['tfb'] != ""){ ?>
		var tfb = document.getElementById("tfb").value;
		<?php } ?>
		var areawidth = <?php echo $row_framemodel['calculation']; ?>;
		document.getElementById("areawidth").setAttribute("value",0);
	};
</script>
<?php
mysql_free_result($framemodel);
?>
