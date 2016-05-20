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

mysql_select_db($database_core, $core);
$query_rsdept = "SELECT * FROM h_department";
$rsdept = mysql_query($query_rsdept, $core) or die(mysql_error());
$row_rsdept = mysql_fetch_assoc($rsdept);
$totalRows_rsdept = mysql_num_rows($rsdept);
//$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Setting of Notification</title>
<link rel="stylesheet" type="text/css" href="../css/induk.css" />
</head>

<body class="General">
<?php
$i = 0;
do { ?>
<table>
  <tr>
    <td width="20" rowspan="6" valign="top"><b><?php $i++; echo $i; ?>).</b></td>
    <td>
	<table>
      <tr>
        <td width="80">Department</td>
        <td width="20">:</td>
        <td><b><?php echo $row_rsdept['department']?></b></td>
      </tr>
      <tr>
        <td>Description</td>
        <td>:</td>
        <td><b><?php echo $row_rsdept['departmentdescription']?></b></td>
      </tr>
      <tr>
        <td colspan="3">
        <table width="375">
          <thead>
            <tr>
              <td class="tabel_header"><input name="cboxSet" type="checkbox" value="0" /></td>
              <td width="75" class="tabel_header" align="center">NIK</td>
              <td width="300" class="tabel_header">Name of Employee</td>
            </tr>
          </thead>
          <tbody>
            <?php
				$vdept = $row_rsdept['department'];
				mysql_select_db($database_core, $core);
				$query_rsemply = "SELECT h_employee.id, h_employee.nik, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee WHERE department = '$vdept' AND userlevel <> '' ORDER BY h_employee.firstname ASC";
				$rsemply = mysql_query($query_rsemply, $core) or die(mysql_error());
				$row_rsemply = mysql_fetch_assoc($rsemply);
				$totalRows_rsemply = mysql_num_rows($rsemply);
				
				do { ?>
            <tr class="tabel_body">
              <td align="center"><input name="cboxSet2" type="checkbox" value="0" /></td>
              <td><?php echo $row_rsemply['nik']; ?></td>
              <td><?php echo $row_rsemply['firstname']; ?> <?php echo $row_rsemply['midlename']; ?> <?php echo $row_rsemply['lastname']; ?></td>
            </tr>
            <?php
				} while ($row_rsemply = mysql_fetch_assoc($rsemply)) ?>
          </tbody>
        </table>
          <hr /><br />
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php
} while ($row_rsdept = mysql_fetch_assoc($rsdept)); ?>
</body>
</html>
<?php
	mysql_free_result($rsdept);
	mysql_free_result($rsemply);
?>