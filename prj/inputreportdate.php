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
?>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<p class="General">Input Production detail from Project 
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
  <style type="text/css">
* { font:"Times New Roman", Times, serif; }
h4 { font-size: 18px; }
input { padding: 3px; border: 1px solid #999; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
  </style>
  </span>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body class="General">
<form name="form1" method="POST">
  <table width="956" border="0">
    <tr>
      <td class="General">Uraian</td>
      <td>:</td>
      <td class="General"><label>
        <select name="departemen" id="departemen">
        </select>
      </label></td>
     
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
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td width="138" class="General">&nbsp;</td>
      <td width="11">:</td>
      <td width="249" class="General"><input name="productioncode" type="text" class="required" id="productioncode" title="Production Code tidak boleh kosong" readonly="readonly" /></td>
      <td width="192" class="General">&nbsp;</td>
      <td width="24" class="General">&nbsp;</td>
      <td width="316" class="General">&nbsp;</td>
    </tr>
    <tr>
      <td width="138" class="General">Unit</td>
      <td>:</td>
      <td class="General"><input name="reference" type="text" id="reference" /></td>
      <td class="General">Weight Sch Rev.</td>
      <td>:</td>
      <td class="General"><input name="contactperson" type="text" id="contactperson" /></td>
    </tr>
    <tr>
      <td class="General">Quantity</td>
      <td>:</td>
      <td class="General"><input name="date" type="text" id="tanggal1" /></td>
      <td class="General">Quantity</td>
      <td>:</td>
      <td class="General"><input name="commdate" type="text" id="tanggal2" value="" /></td>
    </tr>
    <tr>
      <td class="General">Weight</td>
      <td>:</td>
      <td class="General"><input name="location" type="text" id="location" /></td>
      <td class="General">Vendor</td>
      <td>:</td>
      <td class="General"><input name="completedate" type="text" id="tanggal3" /></td>
    </tr>
    <tr>
      <td class="General">WBS Edit Weight</td>
      <td>:</td>
      <td class="General"><input name="projecttitle" type="text" id="projecttitle" /></td>
      <td class="General">WR No</td>
      <td>:</td>
      <td class="General"><label for="nowr"></label>
      <input name="wrno" type="text" id="wrno" value="" /></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>:</td>
      <td class="General"><input name="quantity" type="text" id="quantity" /></td>
      <td class="General">WR Value</td>
      <td>:</td>
      <td class="General"><input name="principalvalue" type="text" class="required" id="principalvalue" title="Silahkan isi Budget" value="" />
<select name="curency" id="curency">
          <option value="USD">USD</option>
          <option value="IDR">IDR</option>
      </select></td>
    </tr>
    <tr>
      <td class="General">&nbsp;</td>
      <td>:</td>
      <td class="General"><input name="vendor" type="text" id="vendor" /></td>
      <td class="General">&nbsp;</td>
      <td class="General">&nbsp;</td>
<td class="General">&nbsp;</td>
    </tr>
    <tr>
      <td class="General"><input name="projectcode" type="hidden" id="projectcode"></td>
      <td colspan="5"><label>
        <input type="submit" name="Save" id="Save" value="Save">
      </label></td>
    </tr>
  </table>
</form>


</body>
</html>