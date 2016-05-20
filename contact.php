<?php require_once('Connections/core.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO contact_us (name, empID, email, ph, type, `comment`, timeofcomment) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['text1'], "text"),
					   GetSQLValueString($_POST['empID'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phonenumb'], "text"),
                       GetSQLValueString($_POST['typecmnt'], "text"),
                       GetSQLValueString($_POST['komentar'], "text"),
                       GetSQLValueString($_POST['issueddate'], "text"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($insertSQL, $core) or die(mysql_error());
  
    $comment = $_POST['komentar'];
  $issueddate = $_POST['issueddate'];
   echo "<script>alert(\"Your Comment has been Sent at $issueddate, Thank you. Your Comment is $comment.  \");
   </script>";
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bi_SmartS - Contact</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 5px;
	margin-top: 5px;
}
a:link {
	color: #000;
	text-decoration: none;
}
a:visited {
	color: #000;
	text-decoration: none;
}
a:hover {
	color: #F00;
	text-decoration: underline;
}
a:active {
	color: #000;
	text-decoration: none;
}
-->
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

</head>

<body class="General">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" class="General">
  <tr>
    <td width="544"><form id="form5" name="form5" method="post" action="">
      <span class="demoHeaders"><img src="images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></span>
    </form></td>
    <td width="389" valign="bottom"><form id="form7" name="form7" method="post" action="">
      <table width="210" border="0" align="right" cellpadding="1" cellspacing="1">
        <tr>
          <td height="17" bgcolor="#FFFFFF"><span class="demoHeaders">|</span></td>
          <td bgcolor="#FFFFFF"><span class="demoHeaders"><a href="home.php"><strong>Home</strong></a></span></td>
          <td bgcolor="#FFFFFF"><span class="demoHeaders">|</span></td>
          <td bgcolor="#FFFFFF"><span class="demoHeaders"><a href="#"><strong>Contact Us</strong></a></span></td>
          <td bgcolor="#FFFFFF"><span class="demoHeaders">|</span></td>
          <td bgcolor="#FFFFFF"><span class="demoHeaders"><a href="#"><strong>Help</strong></a></span></td>
          <td bgcolor="#FFFFFF"><span class="demoHeaders">|</span></td>
        </tr>
      </table>
    </form></td>
    <td width="4">&nbsp;</td>
    <td width="37">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><form id="form2" name="form2" method="post" action="">
      <iframe src="images/banner.html" frameborder="0" width="930" height="150"></iframe>
    </form></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><marquee class="marque" id="tex_judul">
      <strong>Bukaka Integrated Smart System - PT. Bukaka Teknik Utama Balikpapan</strong>
    </marquee></td>
    <td>&nbsp;</td>
    <td width="11">&nbsp;</td>
  </tr>
  <tr>
    <td height="11" colspan="3" align="center"><form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1">
      <p>Silahkan Masukkan Komentar Anda Tentang Sistem Ini</p>
      <table border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="150">Name</td>
          <td width="10">:</td>
          <td width="283"><span id="sprytextfield1">
            <input type="text" name="text1" id="text1" value="<?php echo $_SESSION['Fname']; ?>" />
            <span class="textfieldRequiredMsg">Nama Tidak Boleh Kosong</span><span class="textfieldInvalidFormatMsg">Nama Tidak Boleh Kosong.</span></span>
            <input type="hidden" name="empID" id="empID" value="<?php echo $_SESSION['empID']; ?>" /></td>
</tr>
        <tr>
          <td height="27">Email / Phone Number</td>
          <td>:</td>
          <td><span id="sprytextfield">
            <input type="text" id="email" name="email" />
            <span class="textfieldRequiredMsg">Format Email Tidak Valid</span><span class="textfieldInvalidFormatMsg">Format Email Tidak Valid.</span></span> / 
            <label for="phonenumb"></label>
            <input type="text" name="phonenumb" id="phonenumb" /></td>
</tr>
        <tr>
          <td>Type of Comment</td>
          <td nowrap="nowrap">:</td>
          <td nowrap="nowrap"><label for="typecmnt"></label>
            <select name="typecmnt" id="typecmnt">
              <option value="">-- Type of Comment --</option>
              <option value="1">Information</option>
              <option value="2">Suggestion</option>
              <option value="3">Complaints</option>
            </select></td>
        </tr>
        <tr>
          <td>Comment</td>
          <td nowrap="nowrap">:</td>
          <td nowrap="nowrap"><label for="komentar"></label>
            <textarea name="komentar" id="komentar" cols="45" rows="5"></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td nowrap="nowrap"><label for="time"></label>
            <b>
            <?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang; ?>
            <input name="issueddate" type="hidden" id="issueddate" value="<?php echo $sekarang; ?>" />
            </b></td>
        </tr> 
        <tr>
          <td colspan="3" align="center"><input type="submit" name="button2" id="button2" value="Kirim"
          /></td>
          </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><a href="#" onclick="MM_openBrWindow('it/contactus_yourcomment.php?data=<?php echo $_SESSION['empID']; ?>','','scrollbars=yes,width=600,height=400')">Click Here to View Your Comment</a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="17" colspan="4"><form id="form3" name="form3" method="post" action="">
      <table width="150" border="0" align="right" cellpadding="0" cellspacing="0">
        <tr>
          <td width="177" class="General">&copy; 2012 Bukaka Balikpapan </td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "email", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {validateOn:["blur"]});
</script>
</body>
</html>