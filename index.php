<?php require_once('/Connections/core.php'); ?>
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
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "userlevel";
  $MM_redirectLoginSuccess = "/home.php";
  $MM_redirectLoginFailed = "/index.php?pesan=Sorry Username or Password incorrect Please Try Again";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_core, $core);
  	
  $LoginRS__query=sprintf("SELECT username, password, userlevel FROM h_employee WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $core) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'userlevel');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
	

	function antiinjection($data){
	  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	  return $filter_sql;
	}
	
	$username = antiinjection($_POST[username]);
	$pass     = antiinjection($_POST[password]);
	
	$login = mysql_query("SELECT * FROM h_employee WHERE username='$username' AND password='$pass'");
	$ketemu = mysql_num_rows($login);
	$r = mysql_fetch_array($login);
	
	// Apabila username dan password ditemukan
	if ($ketemu > 0) {
	  session_start();
	  $_SESSION['username'] = $r['username'];
	  $_SESSION['Fname'] = $r['firstname'];
	  $_SESSION['Mname'] = $r['midlename'];
	  $_SESSION['Lname'] = $r['lastname'];
	  //$_SESSION['password'] = $r['password'];
	  $_SESSION['empID'] = $r['id'];
	  $_SESSION['userlvl'] = $r['userlevel'];
	  $_SESSION['lvl'] = $r['level'];
	  $_SESSION['init'] = $r['initial'];
	
	  $jam = date("H:i:s");
	  $tgl = date("Y-m-d");
	
	  mysql_query("INSERT INTO a_user(username,
									 tanggal,
									 jamin,
									 jamout,
									 status)
							   VALUES('$_SESSION[username]',
									'$tgl',
									'$jam',
									'logged',
									'online')"); 
	}
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset=utf-8" />

<title>Bi-Smarts</title>
<link href="css/induk.css"css/induk.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function validasi(form){
  if (form.username.value == ""){
    alert("Anda belum mengisikan Username.");
    form.username.focus();
    return (false);
  }

  if (form.password.value == ""){
    alert("Anda belum mengisikan Password.");
    form.password.focus();
    return (false);
  }
  return (true);
}
</script>

<style type="text/css">
<!--
a:link {
	text-decoration: none;
	color: #000;
}
a:visited {
	text-decoration: none;
	color: #000;
}
a:hover {
	text-decoration: underline;
	color: #F00;
}
a:active {
	text-decoration: none;
	color: #000;
}
-->
</style></head>
<body>
<table width="900" border="0" align="center">
  <tr>
    <td height="64" colspan="2"><img src="images/Logo_ERP.jpg" alt="" width="358" height="56" align="left" /></td>
    <td width="488" align="right" valign="bottom"><table width="210" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr class="demoHeaders">
        <td height="17" bgcolor="#FFFFFF">|</td>
        <td bgcolor="#FFFFFF"><a href="index.php"><strong>Home</strong></a></td>
        <td bgcolor="#FFFFFF">|</td>
        <td bgcolor="#FFFFFF"><a href="contact.php"><strong>Contact Us</strong></a></td>
        <td bgcolor="#FFFFFF">|</td>
        <td bgcolor="#FFFFFF"><a href="#"><strong>Help</strong></a></td>
        <td bgcolor="#FFFFFF">|</td>
      </tr>
    </table>
      <table width="278" border="0"  id="menu"><tr class="demoHeaders">
     
    </tr></table></td>
  </tr>
  <tr>
    <td colspan="3"><iframe src="images/banner.html" frameborder="0" width="930" height="150"></iframe></td>
  </tr>
  <tr>
    <td colspan="3"><marquee class="marque" id="marque" scrollamount="5">Bukaka Integrated Smart System - PT. Bukaka Teknik Utama Balikpapan</marquee></td>
  </tr>
  <tr>
    <td colspan="3" id="font" align="center"><p class="judul"><strong>Welcome to Bi-SmartS</strong></p>
    <p class="judul">The web based application you are attempting to access is accessible only by using a UserID issued by Bukaka ERP</p>
    <p class="judul">To acquire the appropriate UserID, please utilize the Help link above.&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
      <table width="210" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="325" border="0">
            <tr>
              <td colspan="7" align="center"><span class="General"><font color="navy" size="+1" face="Tahoma" class="General"><b>Please Login to Continue</b></font></span></td>
            </tr>
            <tr>
              <td width="1" rowspan="7">&nbsp;</td>
              <td width="8">&nbsp;</td>
              <td width="1">&nbsp;</td>
              <td width="144">&nbsp;</td>
              <td width="4">&nbsp;</td>
              <td width="151">&nbsp;</td>
              <td width="101">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" bgcolor="#ffffff">&nbsp;</td>
              <td align="left" bgcolor="#ffffff">&nbsp;</td>
              <td align="left" bgcolor="#ffffff"><span class="General"><b><font color="navy" face="Tahoma" size="-1"> Username </font></b></span></td>
              <td align="left" bgcolor="#ffffff"><span class="General">:</span></td>
              <td align="left" bgcolor="#ffffff"><span class="General">
                <input name="username" id="USERNAME" size="25" style="margin-left: 1px; background-color: rgb(240, 230, 140);" onfocus="getFocus(this);return false;" onblur="loseFocus(this);return false;" />
              </span></td>
              <td width="101">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="101">&nbsp;</td>
            </tr>
            <tr>
              <td bgcolor="#ffffff">&nbsp;</td>
              <td bgcolor="#ffffff">&nbsp;</td>
              <td bgcolor="#ffffff"><span class="General"><b><font color="navy" size="-1" face="Tahoma" id="r2"> Password</font></b></span></td>
              <td align="left" bgcolor="#ffffff"><span class="General">:</span></td>
              <td align="left" bgcolor="#ffffff"><span class="General">
                <input name="password" type="password" id="PASSWORD" style="margin-left: 1px; background-color: rgb(240, 230, 140);" onfocus="getFocus(this);return false;" onblur="loseFocus(this);return false;" size="25" />
              </span></td>
              <td width="101">&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="left"><span class="General">
                <input type="submit" name="submit" id="button2" value="LOGIN" />
              </span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="left" class="pesan"><?php echo $_GET['pesan']; ?></td>
              <td width="101">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td colspan="3" id="font" align="center"><p><strong>This Web site is best navigated using Mozilla Firefox 15.0 or higher.</strong></p>
    <p><span class="judul">NOTE: This is a secure login page. When you login with your User ID 
  and Password above and click the &quot;LOGIN&quot; button, your User ID </span></p>
    <p><span class="judul">and 
          Password are encrypted and then sent over the Internet. Because the data
    is encrypted, this data cannot be viewed while it is being</font></span></p>
    <p><span class="judul">transmitted.
          Data encryption is accomplished using SSL (Secure Sockets Layer,) which
    is a communications protocol for transmitting</span></p>
    <p><span class="judul">private or sensitive data
    over the Internet.</span></p></td>
  </tr>
  <tr>
    <td width="154">&nbsp;</td>
    <td width="247">&nbsp;</td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>