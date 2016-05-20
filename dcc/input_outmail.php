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
  $insertSQL = sprintf("INSERT INTO d_out_mail (kd_tahun, no_surat, `date`, `description`, costumer, contact_person, from_approv, from_maker, information) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kodetahun'], "int"),
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['uraian'], "text"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['attn'], "text"),
                       GetSQLValueString($_POST['pembuat'], "text"),
                       GetSQLValueString($_POST['pembuat2'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());

  $insertGoTo = "viewoutmailforhome.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT d_out_mail.id, d_out_mail.`date`, d_out_mail.`description`, d_out_mail.information , a_customer.customername, a_contactperson.firstname, h_employee.`initial` AS apv, mkrr.`initial` AS mkr
FROM d_out_mail LEFT JOIN a_customer ON d_out_mail.costumer=a_customer.id LEFT JOIN a_contactperson ON d_out_mail.contact_person=a_contactperson.id LEFT JOIN h_employee ON  d_out_mail.from_approv = h_employee.id LEFT JOIN h_employee AS mkrr ON d_out_mail.from_maker =mkrr.id ";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_core, $core);
$query_Recordset2 = "SELECT id, firstname FROM a_contactperson";
$Recordset2 = mysql_query($query_Recordset2, $core) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_core, $core);
$query_Recordset3 = "SELECT * FROM a_customer";
$Recordset3 = mysql_query($query_Recordset3, $core) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_core, $core);
$query_Recordset4 = "SELECT `initial` FROM h_employee ORDER BY `initial` ASC";
$Recordset4 = mysql_query($query_Recordset4, $core) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_core, $core);
$query_Recordset5 = "SELECT * FROM d_out_mail WHERE status = 1";
$Recordset5 = mysql_query($query_Recordset5, $core) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_core, $core);
$query_Recordset1 = "SELECT * FROM d_perusahaan";
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$year=date(YY);
$ceknomor=mysql_fetch_array(mysql_query("SELECT * FROM d_out_mail ORDER BY kd_tahun DESC,no_surat DESC"));
$tahun=$ceknomor[date];
$nows=substr($tahun,0,4);
$cekQ=$ceknomor[no_surat];
#menghilangkan huruf
$awalQ=substr($cekQ,3-6);

#ketemu angka awal(angka sebelumnya) + dengan 1
$next=(int)$awalQ+1;
$nextno=sprintf ("%03d",$next);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(function(){
				$('#dialog').dialog({
					autoOpen: false,
					title: 'ADD DATA',
					width: 750,
				});
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});
				$('#datepicker').datepicker({dateFormat: 'yy-mm-dd'});
				$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
		});
        var availableTags = [
        <?php do {  ?>
            "<?php echo $row_Recordset3['customername'] ?>",
		<?php
			} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
			$rows = mysql_num_rows($Recordset3);
			if($rows > 0) {
				mysql_data_seek($Recordset3, 0);
			$row_Recordset3 = mysql_fetch_assoc($Recordset3);
			}
	    ?>
		""
        ];
        $( "#company" ).autocomplete({
            source: availableTags
        });
		var availableTags = [	
			<?php do {  ?>
            	"<?php echo $row_Recordset2['firstname']?>",
            <?php
				} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
				$rows = mysql_num_rows($Recordset2);
				if($rows > 0) {
					mysql_data_seek($Recordset2, 0);
				$row_Recordset2 = mysql_fetch_assoc($Recordset2);
				}
	    	?>
			"Pimpinan",
			"-"
			];
			 $( "#attn" ).autocomplete({
            source: availableTags
		});
		var availableTags = [	
			<?php do {  ?>
            	"<?php echo $row_Recordset4['initial']?>",
            <?php
				} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
				$rows = mysql_num_rows($Recordset4);
				if($rows > 0) {
					mysql_data_seek($Recordset4, 0);
				$row_Recordset4 = mysql_fetch_assoc($Recordset4);
				}
	    	?>
			"-"
			];
			 $( ".initial" ).autocomplete({
            source: availableTags
		});
    });
	//Ajax
	function getidbyname(str,fl,tab,dv) {
		if (str.length==0){ 
			  document.getElementById(dv).innerHTML="";
			  return;
		}
		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
		  	xmlhttp=new XMLHttpRequest();
		}
		else{
			// code for IE6, IE5
		  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(dv).innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","fileajax/employehidden.php?namex="+str+"&fl="+fl+"&tab="+tab+"&dv="+dv,true);
		xmlhttp.send();
	};
</script>
<link type="text/css" href="../js/jquiuni.css" rel="stylesheet" />
<style type="text/css">
			table {border-collapse:collapse;}
			.tdclass{border-right:1px solid #333333;}
			body{
	font: 75.5% "Trebuchet MS", sans-serif;
	margin: 50px;
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
	margin-bottom: 5px;
}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
.headerdate {	text-align: left;
}
.headertable {
	text-align: center;
	color: #FFF;
	font-weight: 900;
}
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>

<title>Home - Input Outmail</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
    include("../css/tanggal.php");?>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table border="0" cellpadding="2" cellspacing="2" align="center">
      <tr>
        <td colspan="3" class="tabel_header" > Nomor Surat</td>
      </tr>
      <tr>
        <td class="General" ><input name="kodetahun" type="text" class="hidentext" id="kodetahun" value="<?php echo date(Y) ?>" /></td>
        <td>&nbsp;</td>
        <td><label>
          <input name="id" type="text" id="id" value="<? echo $nextno; ?>" size="5" readonly="readonly" />
        </label></td>
      </tr>
      <tr>
        <td class="General" >Tanggal</td>
        <td>:</td>
        <td><label for="tanggal"></label>
        <input type="text" name="tanggal" id="datepicker" /></td>
      </tr>
      <tr>
        <td class="General">Uraian</td>
        <td>:</td>
        <td><label for="uraian"></label>
          <label for="uraian"></label>
        <textarea name="uraian" id="uraian" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <td class="General">Kepada Perusahaan</td>
        <td>:</td>
        <td><label>
          <select name="customer" id="company">
            <option value="">--Silahkan Pilih Perusahaan--</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['customername']?>"><?php echo $row_Recordset1['customername']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
        </label>
        <span id="idcos"><input type='hidden' name='idcos'/> <?php {include "popup.html";}?></span></td>
      </tr>
      <tr>
        <td class="General">Kepada Attn.</td>
        <td>:</td>
         <td><input name="attn" id="attn" onkeyup="getidbyname(this.value,'firstname','a_contactperson','idatn')" /><span id="idatn"><input type='hidden' name='idatn'/> </span></td>
      </tr>
      <tr>
        <td class="General">Dari(inisial) Penanda tangan</td>
        <td>:</td>
        <td><input type="text" name="pembuat" class="initial" width="10" maxlength="4" onkeyup="getidbyname(this.value,'initial','h_employee','idaprov')" />
          <span id="idaprov"><input type='hidden' name='idaprov'/> 
          </span></td>
      </tr>
      <tr>
        <td class="General">Dari(inisial) Pembuat surat</td>
        <td>:</td>
<td><input type="text" name="pembuat2" class="initial" width="10" maxlength="4" onkeyup="getidbyname(this.value,'initial','h_employee','idmaker')" />
  <span id="idmaker">
          <input type='hidden' name='idmaker'/>
        </span></td>
      </tr>
      <tr>
        <td class="General">Keterangan</td>
        <td>:</td>
        <td><label for="keterangan"></label>
          <textarea name="keterangan" id="keterangan" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <td colspan="3" class="tabel_header" align="center"><input name="submit" type="submit" value="SUBMIT" /></td>
      </tr>
    </table>
<input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset2);

mysql_free_result($Recordset6);

mysql_free_result($Recordset1);

mysql_free_result($Recordset5);

mysql_free_result($Recordset4);

mysql_free_result($Recordset3);
?>
