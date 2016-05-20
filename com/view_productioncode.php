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
$query_Recordset1 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_production_code WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php echo $row_Recordset1['project_code']; ?></p>
  
  <span class="General">
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
  <link href="../css/induk.css" rel="stylesheet" type="text/css" />
  </span>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
  <style type="text/css">
* { font:"Times New Roman", Times, serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
  </style>

</head>

<body class="General">
<form name="form1" method="POST">
  <table width="956" border="0" class="General">
    
    <tr>
      <td class="General"><span class="General">Project Code</span></td>
      <td><span class="General">:</span></td>
<td><span class="General"><?php echo $row_Recordset1['projectcode']; ?></span></td>
     
       <?php
 $cari=$row_Recordset3['projectcode'];
$year=date(y);
 // cari panjang max dari string yg di dapat dari query
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM a_production_code WHERE projectcode LIKE '%$cari%' ORDER BY productioncode DESC LIMIT 1"));
$cekQ=$ceknomor[productioncode];
#menghilangkan huruf
$awalQ=substr($cekQ,-3);
#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextprodcode=sprintf ($year."%03d", $next);

?>
      <td class="General"><span class="General">Quantity</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['quantity']; ?></span></td>
    </tr>
    <tr>
      <td width="103" class="General"><span class="General">Production Code</span></td>
      <td width="14"><span class="General">:</span></td>
      <td width="304"><span class="General"><?php echo $row_Recordset1['productioncode']; ?></span></td>
      <td width="120" class="General"><span class="General">Vendor</span></td>
      <td width="9"><span class="General">:</span></td>
      <td width="380"><span class="General"><?php echo $row_Recordset1['vendor']; ?></span></td>
    </tr>
    <tr>
      <td class="General"><span class="General">Reference</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['Reference']; ?></span></td>
      <td class="General"><span class="General">Contact Person</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['contactperson']; ?></span></td>
    </tr>
    <tr>
      <td class="General"><span class="General">Date</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['date']; ?></span></td>
      <td class="General"><span class="General">Comm. Date</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['commdate']; ?></span></td>
    </tr>
    <tr>
      <td><span class="General">Location</span></td>
      <td><span class="General">:</span></td>
      
      <td><span class="General"><?php echo $row_Recordset1['Location']; ?></span></td>
      <td class="General"><span class="General">Completion Date</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['completedate']; ?></span></td>
    </tr>
    <tr>
      <td class="General"><span class="General">Project Title</span></td>
      <td><span class="General">:</span></td>
      
      <td><span class="General"><?php echo $row_Recordset1['projecttitle']; ?></span></td>
      <td class="General"><span class="General">WR No</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General">
        <label for="nowr"><?php echo $row_Recordset1['wrno']; ?></label>
      </span></td>
    </tr>
    <tr>
      <td class="General"><span class="General">Remark</span></td>
      <td><span class="General">:</span></td>
      
      <td><strong><span class="General"><?php echo $row_Recordset1['remark']; ?></span></strong></td>
      <td class="General"><span class="General">WR Value</span></td>
      <td><span class="General">:</span></td>
      <td><span class="General"><?php echo $row_Recordset1['curency']; ?></span></td>
    </tr>
    <tr>
      <td colspan="8" align="center"><span class="buatform"><a href="editproductioncode.php?data=<?php echo $row_Recordset1['id']; ?>"><strong>EDIT</strong></a></span></td>
    </tr>
  </table>
</form>


</body>
</html><?php
mysql_free_result($Recordset1);
?>
