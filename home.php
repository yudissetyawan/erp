<?php require_once('Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/index.php?pesan=Sorry Youre not allowed to view this page,Please Contact our administrator";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Home - Bi Smarts</title>
<script type="text/javascript" src="menu_assets/jquery.js"></script>
<script type="text/javascript" src="menu_assets/ddaccordion.js"></script>
<style type="text/css">
<!--
.glossymenu {	margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: 1px solid #9A9A9A;
	border-bottom-width: 0;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
<style type="text/css">

.glossymenu{
	margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: thin solid #000;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	line-height: normal;
	color: #000;
}

.glossymenu a.menuitem{
	color: #000;
	display: block;
	position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
	width: auto;
	padding: 4px 0;
	text-decoration: none;
	background-color: #F7F3F7;
	background-image: url(menu_assets/glossyback.gif);
	background-repeat: repeat-x;
	background-position: left bottom;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	border: thin solid #FFF;
}


.glossymenu a.menuitem:visited, .glossymenu .menuitem:active{
	color: #333;
}

.glossymenu a.menuitem .statusicon{ /*CSS for icon image that gets dynamically added to headers*/
position: absolute;
top: 5px;
right: 5px;
border:0;
}

.glossymenu a.menuitem:hover{
	background-image:url(menu_assets/glossyback2.gif);
	background-color: #F7F3F7;
	color: #09F;
}

.glossymenu div.submenu{ /*DIV that contains each sub menu*/
	background-color: #c5d9f1;
}

.glossymenu div.submenu ul{ /*UL of each sub menu*/
list-style-type: none;
margin: 0;
padding: 0;
}

.glossymenu div.submenu ul li{
border-bottom: 1px solid blue;
}

.glossymenu div.submenu ul li a{
	display: block;
	color: #000;
	text-decoration: none;
	padding: 2px 0;
	padding-left: 10px;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
}

.glossymenu div.submenu ul li a:hover{
	background: #DFDCCB;
	colorz: white;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	color: #09F;
}

</style>
<script type="text/javascript">


ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	, //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})


</script>

<link href="css/induk.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #000;
	text-decoration: none;
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
</style>

	<script type="text/javascript" src="js/jquery/jquery.js"></script>
	<script type="text/javascript">
    $(function(){
		$('.dropdown').mouseenter(function(){
			$('.sublinks').stop(false, true).hide();
			
			var submenu = $(this).parent().next();
			
			submenu.css({
				position:'absolute',
				top: $(this).offset().top + $(this).height() + 'px',
				left: $(this).offset().left + 'px',
				zIndex:1000
			});
			
			submenu.stop().slideDown(300);
			
			submenu.mouseleave(function(){
				$(this).slideUp(300);
			});
		});
    });
    </script>
    <link href="css/dropdown.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	* { font: 11px/20px Verdana, sans-serif; }
	h3 { font-size:14px; font-weight:bold; }
	p {font-size:12px; font-weight:bold;}
	input { padding: 1px; border: 1px solid #999; }
	input.error, select.error { border: 1px solid red; }
	label.error { color:red; margin-left: 10px; }
</style>

</head>
<body>
<table width="1270" border="0" align="center">
  <tr>
    <td height="64" colspan="2" rowspan="2"><img src="images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="628" align="right" valign="bottom">
    <table width="420" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>    
        <td width="5" align="right" valign="middle" class="demoHeaders">|</td>
        <td width="120" align="right" valign="middle" class="demoHeaders">Your Logged as
        <td width="125" align="center" valign="middle" class="demoHeaders">
        	<ul>
            	<li><a href="#" class="dropdown"><?php echo $_SESSION['MM_Username']?><img src="images/dropdown_icon.GIF"></a></li>
                <li class="sublinks">
                    <a href="hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>" target="_blank">Personal Data</a>
                    <a href="?modul=absenndcuti">Absence & Leave</a>
                    <!-- <a href="#">#Message</a> -->
                </li>            
        	</ul>
        </td>
        <td width="8" class="demoHeaders">|</a></td>
        <td width="85" class="demoHeaders"><a href="contact.php">Contact Us</a></td>
        <td width="8" class="demoHeaders">|</td>
        <td width="60" class="demoHeaders"><a href="logout.php">Logout</a></td>
        <td align="right" width="5" class="demoHeaders">|</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom">
		<?php { include "menu_notification.php"; } ?>
    </td>
  </tr>
  
  
  <tr>
    <td align="right" bgcolor="#8db4e3" class="tabel_index" id="font">Department</td>
    <td colspan="2" align="right" bgcolor="#8db4e3" id="font"><table width="500" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" bgcolor="#EFEFEF" class="tabel_index"><?php echo date("l, d F Y"); ?></td>
        <td align="left" bgcolor="#EFEFEF" class="tabel_index"> Welcome <?php echo $_SESSION['Fname']?> <?php echo $_SESSION['Mname']?> <?php echo $_SESSION['Lname']?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"> <div class="glossymenu"> 
          <a class="menuitem submenuheader" href="tm/home_topmanagement.php">Top Management</a>
          <a class="menuitem submenuheader" href="mkt/home_marketing.php" >Marketing</a>
          <a class="menuitem submenuheader" href="com/home_commercial.php">Commercial</a>
          <a class="menuitem submenuheader" href="qly/home_qc.php">QA/QC</a>
          <a class="menuitem submenuheader" href="hse/home_hse.php">HSE</a>
          <a class="menuitem submenuheader" href="eng/home_engineering.php" >Engineering</a>
          <a class="menuitem submenuheader" href="proc/home_procurement.php">Procurement</a>
          <a class="menuitem submenuheader" href="ppic/home_production.php">PPIC</a>
          <a class="menuitem submenuheader" href="fab/home_fabrication.php">Fabrication</a>
          <a class="menuitem submenuheader" href="hrd/home_hrd.php" >HRD/GAFF</a>
          <a class="menuitem submenuheader" href="fin/home_finance.php">Finance</a>
          <a class="menuitem submenuheader" href="mtn/home_maintenance.php">Maintenance</a>
          <a class="menuitem submenuheader" href="it/home_it.php">IT</a>
          <a class="menuitem submenuheader" href="prj/home_project.php" >Project</a>
          <a class="menuitem submenuheader" href="dcc/home_dcc.php">MR/DCC</a>   
          
    </div></td>
    <td colspan="2"><iframe src="<?php
                    	if ($_GET[modul]=='unapproved'){
							echo "tm/unapproved_crf.php";
						}
						elseif ($_GET[modul]=='notif'){
							echo "prj/bacanotif.php?data=$usrid";
						}
						elseif ($_GET[modul]=='absenndcuti'){
							echo "hrd/absnkary/vwabsencendleave.php?data=$usrid";
						}
						elseif ($_GET[modul]=='suratizin'){
							echo "hrd/absnkary/input_suratizin.php?data=$usrid"; 
						}
						else {
							echo "images/home4.html";
							//echo "images/home4clear.html";
						}							
					?>" frameborder="0" width="1075" height="550"> </iframe></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="General" id="font"></td>
  </tr>
  <tr>
    <td width="174">&nbsp;</td>
    <td width="453" class="pesan"><?php echo $_GET['pesan']; ?></td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>

</body>
</html>