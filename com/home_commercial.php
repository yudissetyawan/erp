<?php require_once('../Connections/core.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator,bussinesdevelopment,branchmanager,commercial";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/home.php?pesan=Sorry You re not Alowed to access Commercial Section";
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

<title>Home Commercial</title>
<!--
	<link href="../css/metro-bootstrap.css" rel="stylesheet">
    <link href="../css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/docs.css" rel="stylesheet">
    <link href="preproduction/js/prettify/prettify.css" rel="stylesheet">
    
    <!-- Load JavaScript Libraries 
    <script src="preproduction/js/jquery/jquery.min.js"></script>
    <script src="preproduction/js/jquery/jquery.widget.min.js"></script>
    <script src="preproduction/js/jquery/jquery.mousewheel.js"></script>
    <script src="preproduction/js/prettify/prettify.js"></script>

    <!-- Local JavaScript 
    <script src="preproduction/js/metro/metro-loader.js"></script>
    <script src="preproduction/js/metro/metro-dropdown.js"></script>
    <script src="preproduction/js/docs.js"></script>
    <script src="preproduction/js/github.info.js"></script>
-->
<script type="text/javascript" src="../menu_assets/jquery.js"></script>
<script type="text/javascript" src="../menu_assets/ddaccordion.js"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>

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
<script type="text/javascript">
	function showUser(str) {
		if (str=="") {
			document.getElementById("txtHint").innerHTML="";
			return;
		} if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		} xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","getpc_eng.php?q="+str,true);
		xmlhttp.send();
	}
</script>

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
	background-image: url(../menu_assets/glossyback.gif);
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
	background-image:url(../menu_assets/glossyback2.gif);
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

<link href="../css/induk.css" rel="stylesheet" type="text/css" />
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
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.glossymenu1 {margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: 1px solid #9A9A9A;
	border-bottom-width: 0;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
.glossymenu1 {	margin: 5px 0;
	padding: 0;
	width: 170px; /*width of menu*/
	border: thin solid #000;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
	line-height: normal;
	color: #000;
}
-->
</style>


	<script type="text/javascript" src="../js/jquery/jquery.js"></script>
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
    <link href="../css/dropdown.css" rel="stylesheet" type="text/css" />


</head>
<body>
<span id="sprycheckbox1"><span class="checkboxRequiredMsg">Please make a selection.</span></span>

<table width="1208" border="0" align="center">
  <tr>
    <td height="64" colspan="2" rowspan="2"><a href="../home.php"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></a></td>
    <td width="628" align="right" valign="bottom">
    <table width="420" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr>  
        <td width="5" align="right" valign="middle" class="demoHeaders">|</td>
        <td width="120" align="right" valign="middle" class="demoHeaders">Your Logged as </td>
        <td width="125" align="center" valign="middle" class="demoHeaders">
        	<ul>
            	<li><a href="#" class="dropdown"><?php echo $_SESSION['MM_Username']?><img src="../images/dropdown_icon.GIF"></a></li>
                <li class="sublinks">
                    <a href="../hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>">Personal Data</a>
                    <a href="?modul=absenndcuti">Absence & Leave</a>
                    <a href="#">#Message</a>
                </li>            
        	</ul>
        </td>
        <td width="8" class="demoHeaders">|</a></td>
        <td width="85" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
        <td width="8" class="demoHeaders">|</td>
        <td width="65" class="demoHeaders"><a href="../logout.php">Logout</a></td>
        <td align="right" width="5" class="demoHeaders">|</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom">
    	<?php { include "../menu_notification.php"; } ?>
    </td>
  </tr>

  <tr>
    <td align="right" bgcolor="#8db4e3" class="tabel_index" id="font">Commercial Menu</td>
    <td colspan="2" align="right" bgcolor="#8db4e3" id="font"><table width="296" height="18" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="50" bgcolor="#EFEFEF" class="root"><a href="../home.php">Home</a></td>
        <td width="7" align="right" bgcolor="#EFEFEF" class="root">|</td>
        <td width="67" align="right" bgcolor="#EFEFEF" class="root">Commercial</td>
        <td width="172" align="right" bgcolor="#EFEFEF" class="root"><?php
                    	if($_GET[modul]=='project'){
							$content="Project Handling";
							}
						elseif ($_GET[modul]=='crf'){
							$content="CRF & Production Code";
							}					
					echo '| '.$content;?>  
        </td>
        </tr>
    </table>
    </td>
  </tr>

  <tr>
    <td rowspan="2" valign="top"><div class="glossymenu"> 
   	<a class="menuitem submenu" href="?modul=project">Project Handling</a>
    <a class="menuitem submenu" href="?modul=crf">CRF & Production Code </a></span></div></td>
    <td colspan="2"> </td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><iframe src="<?php
									if($_GET[modul]=='crf'){
										echo "crf.php";
										}
									elseif ($_GET[modul]=='project'){
										echo "form_comm.php";
										}
									elseif ($_GET[modul]=='unapproved'){
										echo "../tm/unapproved_crf.php";
									}
									elseif ($_GET[modul]=='notif'){
										echo "../prj/bacanotif.php?data=$usrid";
									}
									elseif ($_GET[modul]=='absenndcuti'){
										echo "../hrd/absnkary/vwabsencendleave.php?data=$usrid";
									}
									else {
										echo "flash/commercial.html";
										}
								?>" frameborder="0" width="1075" height="550"> </iframe>  </tr>
  <tr>
    <td width="174">
    </td>
    <td width="185">&nbsp;</td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
//-->
</script>
</body>
</html>