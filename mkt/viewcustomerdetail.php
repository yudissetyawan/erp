<?php require_once('../Connections/core.php'); ?>
<?php require_once('../Connections/core.php'); ?>
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

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM a_customer WHERE id = %s ORDER BY id ASC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$vendor=$row_Recordset1['customername'];
mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT * FROM a_contactperson WHERE customer='$vendor' ORDER BY id ASC";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<body class="General">
<form id="form1" name="form1" method="post" action="">
  <table width="833">
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td width="132" >Customer Name</td>
      <td width="7" >:</td>
      <td width="289"><?php echo $row_Recordset1['customername']; ?></td>
      <td width="104" >Phone 1</td>
      <td width="7" >:</td>
      <td width="266"><?php echo $row_Recordset1['phone1']; ?></td>
    </tr>
    <tr>
      <td >Address 1</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['address1']; ?></td>
      <td >Phone 2</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['phone2']; ?></td>
    </tr>
    <tr>
      <td >Address 2</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['adress2']; ?></td>
      <td >Fax</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['fax']; ?></td>
    </tr>
    <tr>
      <td >City</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['city']; ?></td>
      <td >Email</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['email']; ?></td>
    </tr>
    <tr>
      <td >ZIP Code</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['zip']; ?></td>
      <td >Reference</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['reference']; ?></td>
    </tr>
    <tr>
      <td >Country</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['country']; ?></td>
      <td >NPWP</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['npwp']; ?></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td>&nbsp;</td>
      <td >Remark</td>
      <td >:</td>
      <td><?php echo $row_Recordset1['remark']; ?></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><a href="editcustomer.php?data=<?php echo $row_Recordset1['id']; ?>" class="huruf_besar">Edit</a></td>
    </tr>
  </table>
</form>
<p>
  
</p>
<p>
<h2 class="General">Contact Person :</h2>
<p class="General"><a href="inputcustomercontact.php?data=<?php echo $row_Recordset1['customername']; ?>">Add New</a> </p>
<table width="615" border="0">
  <tr bgcolor="#999999"></tr>
<tr></tr>
</table>
<table width="790" border="0" class="General">
  <tr class="tabel_header">
    <td>No</td>
    <td>Nama</td>
    <td>Departemen</td>
    <td>No. Telepon </td>
    <td>Email</td>
    <td>Alamat</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr class="tabel_body">
      <?php $a=$a+1 ?>
      <td><?php echo $a ?></td>
      <td><?php echo $row_Recordset2['firstname']; ?> <?php echo $row_Recordset2['lastname']; ?></td>
      <td><?php echo $row_Recordset2['department']; ?></td>
      <td><?php echo $row_Recordset2['phone1']; ?> / <?php echo $row_Recordset2['phone2']; ?></td>
      <td><?php echo $row_Recordset2['email']; ?></td>
      <td><?php echo $row_Recordset2['address']; ?></td>
      <td><a href="editcontactpersondetail.php?data=<?php echo $row_Recordset2['id']; ?>">EDIT</a></td>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
</table>
<span class="General">
  <?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>

  </span>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
