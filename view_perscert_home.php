<?php require_once('Connections/core.php');

if (!isset($_SESSION)) {
  session_start();
}

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="js/jquiuni.css" rel="stylesheet" />
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

<title>Home - Personnel Certification</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<table width="1200" border="0" align="center">
  <tr>
    <td height="64" colspan="2" rowspan="2"><a href="home.php"><img src="images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></a></td>
    <td width="628" align="right" valign="bottom"><table width="400" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>
        <td width="8" align="right" valign="bottom">|</td>
        <td width="250" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
        <td width="8" class="demoHeaders">|</a></td>
        <td width="85" class="demoHeaders"><a href="contact.php">Contact Us</a></td>
        <td width="8" class="demoHeaders">|</td>
        <td width="60" class="demoHeaders"><a href="logout.php">Logout</a></td>
        <td align="right" width="10">|</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom"><?php { include "menu_notification.php"; } ?></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#8db4e3" class="tabel_index" id="font">Personnel Certification</td>
    <td colspan="2" align="right" bgcolor="#8db4e3" id="font"><table width="500" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" bgcolor="#EFEFEF" class="tabel_index"><?php echo "Date : " . date("d F Y");?></td>
        <td align="left" bgcolor="#EFEFEF" class="tabel_index"> Welcome <?php echo $_SESSION['MM_Username']?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="General" id="font"><iframe src="<?php
                    	if ($_GET[modul]=='unapproved'){
							echo "tm/unapproved_crf.php";
						}
						elseif ($_GET[modul]=='notif'){
							echo "prj/bacanotif.php?data=$usrid";
						}
						else {
							echo "hrd/view_personnel_certificate_header.php";
						}										
					?>" width="1200" height="600" style="border:thin"></iframe></td>
  </tr>
  <tr>
    <td width="174">&nbsp;</td>
    <td width="453" class="pesan"><?php echo $_GET['pesan']; ?></td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>