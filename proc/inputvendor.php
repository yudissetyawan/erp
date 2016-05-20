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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	include "../dateformat_funct.php";
  $insertSQL = sprintf("INSERT INTO c_vendor (vendorname, vendoraddress, city, zip, `state`, country, officephone, mobilephone, fax, email, email_2, contactperson, contactperson_2, company_profile, registrationdate, product_service, evaluationdate, `result`, remark, npwpno, vendorclass, vendorcategory) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['vendorname'], "text"),
                       GetSQLValueString($_POST['vendoraddress'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['officephone'], "text"),
                       GetSQLValueString($_POST['mobilephone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['email2'], "text"),
                       GetSQLValueString($_POST['contactperson'], "text"),
                       GetSQLValueString($_POST['contactperson2'], "text"),
                       GetSQLValueString($_POST['companyprofile'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['registrationdate']), "text"),
                       GetSQLValueString($_POST['product_service'], "text"),
                       GetSQLValueString(functyyyymmdd($_POST['evaluationdate']), "text"),
                       GetSQLValueString($_POST['result'], "text"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['npwp'], "text"),
                       GetSQLValueString($_POST['vendorclasses'], "text"),
                       GetSQLValueString($_POST['vendorcategory'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewvendor.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_rsvendorcatg = "SELECT * FROM c_vendorcatg";
$rsvendorcatg = mysql_query($query_rsvendorcatg, $core) or die(mysql_error());
$row_rsvendorcatg = mysql_fetch_assoc($rsvendorcatg);
$totalRows_rsvendorcatg = mysql_num_rows($rsvendorcatg);
?>
<!--<script type="text/javascript" src="../js/jquery-1.2.3.pack.js"></script>
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
</script>!-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration of Vendor</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	h4 { font-size: 18px; }
	input { padding: 3px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
	td { padding: 5px; }
</style>
</head>

<script type="text/javascript">
function cekInput() {
	if (document.form1.vendorname.value = "") {
		alert("Please input Vendor Name");
		document.form1.vendorname.focus();
		return false;
	}
}
</script>

<body class="General">
<?php { include "../date.php"; } ?>
<p class="buatform"><b>Vendor Registration Form</b></p>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="900" border="0">
    <tr>
      <td width="160">Vendor Name</td>
      <td width="10">:</td>
      <td width="350">
        <input type="text" name="vendorname" id="vendorname" class="required" title="Silahkan isi Vendor Name" size="40" />
      </td>
      <td width="160">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="100">&nbsp;</td>
    </tr>
    <tr>
      <td>Vendor Classes</td>
      <td>:</td>
      <td>
        <select name="vendorclasses" id="vendorclass" class="required" title="Pilih Vendor Class Terlebih Dahulu">
        <option value="">-- Select Classes --</option>
          <option value="Supplier">Supplier</option>
          <option value="Sub Contractor">Sub Contratctor</option>
        </select>
     </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Vendor Category</td>
      <td>:</td>
      <td><select name="vendorcategory" class="required" id="vendorcategory" title="Silahkan pilih Category">
        <option value="">-- Select Category --</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsvendorcatg['id']?>"><?php echo $row_rsvendorcatg['category']?></option>
        <?php
} while ($row_rsvendorcatg = mysql_fetch_assoc($rsvendorcatg));
  $rows = mysql_num_rows($rsvendorcatg);
  if($rows > 0) {
      mysql_data_seek($rsvendorcatg, 0);
	  $row_rsvendorcatg = mysql_fetch_assoc($rsvendorcatg);
  }
?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Vendor Address</td>
      <td>:</td>
      <td><textarea name="vendoraddress" id="vendoraddress" cols="30" rows="3" class="required" title="Silahkan isi vendor Address"></textarea></td>
      <td>Company Profile</td>
      <td align="center">:</td>
      <td><textarea name="companyprofile" id="companyprofile" rows="3" cols="30"></textarea></td>
    </tr>
    <tr>
      <td align="right">City</td>
      <td align="center">:</td>
      <td><input name="city" type="text" id="city" /></td>
      <td>Registration Date</td>
      <td align="center">:</td>
      <td><label for="registrationdate"></label>
        <input name="registrationdate" type="text" value="" id="tanggal8" /></td>
    </tr>
    <tr>
      <td valign="top" align="right">Zip</td>
      <td valign="top" align="center">:</td>
      <td valign="top"><input name="zip" type="text" id="zip" /></td>
      <td valign="top">&nbsp;</td>
      <td valign="top" align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">State </td>
      <td align="center">:</td>
      <td><input name="state" type="text" id="state" /></td>
      <td>Product / Service</td>
      <td align="center">:</td>
      <td><input name="product_service" type="text" id="product_service" size="40" /></td>
    </tr>
    <tr>
      <td align="right">Country</td>
      <td>:</td>
      <td><input name="country" type="text" id="country" /></td>
      <td>Evaluation Date</td>
      <td align="center">:</td>
      <td><input name="evaluationdate" type="text" id="tanggal9" /></td>
    </tr>
    <tr>
      <td>Office Phone </td>
      <td>:</td>
      <td><input type="text" name="officephone" id="officephone" class="required" title="Silahkan Isi Officephone" /></td>
      <td>Result</td>
      <td align="center">:</td>
      <td><input name="result" type="text" id="result" /></td>
    </tr>
    <tr>
      <td>Mobile Phone </td>
      <td>:</td>
      <td><input type="text" name="mobilephone" id="mobilephone" class="required" title="silahkan isi Mobilephone" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">Fax</td>
      <td valign="top" align="center">:</td>
      <td valign="top"><input name="fax" type="text" id="fax" /></td>
      <td>Remark</td>
      <td>:</td>
      <td><textarea name="note" id="note" cols="30" rows="2" class="required" title="Silahkan isi Note"></textarea></td>
    </tr>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td><input type="text" name="email" id="email" class="required" title="Silahkan Isi Email" /></td>
      <td>NPWP No.</td>
      <td>:</td>
      <td><input type="text" name="npwp" id="npwp" class="required" title="Silahkan isi NPWP" /></td>
    </tr>
    <tr>
      <td valign="top">Email 2</td>
      <td valign="top">:</td>
      <td valign="top"><input name="email2" type="text" id="email2" /></td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>Contact Person</td>
      <td>:</td>
      <td><label for="contactperson"></label>
        <input name="contactperson" type="text" id="contactperson" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Contact Person 2</td>
      <td>:</td>
      <td><input name="contactperson2" type="text" id="contactperson2" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><input type="submit" name="save" id="save" value="Save" onclick="return cek();" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rsvendorcatg);
?>
