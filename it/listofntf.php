<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

mysql_select_db($database_core, $core);
$query_rsntf = "SELECT DISTINCT inisial_pekerjaan.inisial_pekerjaan, inisial_pekerjaan.nama_pekerjaan, log_pesan.id_inisial FROM log_pesan, inisial_pekerjaan WHERE log_pesan.id_inisial = inisial_pekerjaan.id_inisial";
$rsntf = mysql_query($query_rsntf, $core) or die(mysql_error());
$row_rsntf = mysql_fetch_assoc($rsntf);
$totalRows_rsntf = mysql_num_rows($rsntf);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List of Notification</title>
<link rel="stylesheet" type="text/css" href="../css/induk.css" />
</head>

<body class="General">
<a href="ntfsetting.php"><b>Plan setting of notif</b></a>
<br /><br />

<?php
$i = 1;
do { ?>
<table>
<tr>
	<td width="20" rowspan="6" valign="top"><b><?php echo $i?>).</b></td>
	<td>
		<table>
        <tr>
			<td width="80">Job Initial</td>
			<td width="20">:</td>
			<td><b><?php echo $row_rsntf['nama_pekerjaan']?> (<?php echo $row_rsntf['inisial_pekerjaan']?>)</b></td>
		</tr>
        <tr>
          <td colspan="3">
          <table width="375">
            <thead>
              <tr>
                <td class="tabel_header">No.</td>
                <td width="175" class="tabel_header" align="center">Department</td>
                <td width="200" class="tabel_header">Name of Employee</td>
              </tr>
            </thead>
            <tbody>
              <?php
				$vntf = $row_rsntf['id_inisial'];
				mysql_select_db($database_core, $core);
				$query_rsdept = "SELECT DISTINCT h_employee.department FROM h_employee, log_pesan WHERE log_pesan.id_inisial = '$vntf' AND log_pesan.id_empdept = h_employee.id";
				$rsdept = mysql_query($query_rsdept, $core) or die(mysql_error());
				$row_rsdept = mysql_fetch_assoc($rsdept);
				$totalRows_rsdept= mysql_num_rows($rsdept);				
				$j = 0;
				do { ?>
                  <tr class="tabel_body" valign="top">
                    <td align="center"><?php $j = $j+1; echo $j.'.'; ?></td>
                    <td><?php $vdept = $row_rsdept['department']; echo $vdept; ?></td>
                    <td>
					<?php
                        mysql_select_db($database_core, $core);
                        $query_rsemply = "SELECT DISTINCT h_employee.id, h_employee.firstname, h_employee.midlename, h_employee.lastname FROM h_employee, log_pesan WHERE log_pesan.id_inisial = '$vntf' AND log_pesan.id_empdept = h_employee.id AND h_employee.department = '$vdept'";
                        $rsemply = mysql_query($query_rsemply, $core) or die(mysql_error());
                        $row_rsemply = mysql_fetch_assoc($rsemply);
                        $totalRows_rsemply = mysql_num_rows($rsemply);
                        do {
							echo "- "; echo $row_rsemply['firstname']; ?> <?php echo $row_rsemply['midlename']; ?> <?php echo $row_rsemply['lastname']; echo '<br>';
                        } while ($row_rsemply = mysql_fetch_assoc($rsemply)); ?>
					</td>
				<?php
				} while ($row_rsdept = mysql_fetch_assoc($rsdept)); ?>
            </tbody>
          </table>
            <hr /><br />
          </tr>
        </table>
    </td>
</tr>
</table>

<?php
$i++;
} while ($row_rsntf = mysql_fetch_assoc($rsntf));
?>

</body>
</html>
<?php
	mysql_free_result($rsntf);
	mysql_free_result($rsdept);
	mysql_free_result($rsemply);
?>