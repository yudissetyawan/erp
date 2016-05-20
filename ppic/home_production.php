<?php require_once('../Connections/core.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrator,branchmanager,ppic";
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

$MM_restrictGoTo = "/home.php?pesan=Sorry You re not Alowed to access PPIC Section";
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
$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Home PPIC</title>
<script type="text/javascript" src="../menu_assets/jquery.js"></script>
<script type="text/javascript" src="../menu_assets/ddaccordion.js"></script>
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
	//Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
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
</style></head>
<body>
<table width="1234" border="0" align="center">
  <tr>
    <td height="64" colspan="2" rowspan="2"><a href="../home.php"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></a></td>
    <td width="629" align="right" valign="top"><table width="439" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr class="demoHeaders">
        <td width="8" align="right" valign="bottom">|</td>
        <td width="250" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="../hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
        <td width="9" class="demoHeaders">|</a></td>
        <td width="85" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
        <td width="8" class="demoHeaders">|</td>
        <td width="63" class="demoHeaders"><a href="../logout.php">Logout</a></td>
        <td align="right" width="8">|</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom">
    <?php { include "../menu_notification.php"; } ?>
    </td>
  </tr>
  
  
  <tr>
    <td align="right" bgcolor="#8db4e3" class="tabel_index" id="font">PPIC Menu</td>
    <td colspan="2" align="right" bgcolor="#8db4e3" id="font">
    <table width="400" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="35" bgcolor="#EFEFEF" class="root"><a href="../home.php">Home</a></td>
        <td width="10" align="right" bgcolor="#EFEFEF" class="root">|</td>
        <td width="35" align="right" bgcolor="#EFEFEF" class="root">PPIC</td>
        <td width="320" align="right" bgcolor="#EFEFEF" class="root"><?php
                    	if($_GET[modul]=='project'){
							$content="Project Handling";
						}
						elseif ($_GET[modul]=='activity'){
							$content="Monitoring Activity";
						}
						elseif ($_GET[modul]=='mr'){
							$content="Material Request";
						}
						elseif ($_GET[modul]=='itempro'){
							$content="Production Item";
						}
						elseif ($_GET[modul]=='unapproved'){
							$content="Need for Approval";
						}
						elseif ($_GET[modul]=='notif'){
							$content="Your Notification";
						}
						elseif ($_GET[modul]=='mtu'){
							$content="Monitoring of Tools Usage";
						}
						elseif ($_GET[modul]=='pkg_list'){
							$content="Packing List";
						}
						elseif ($_GET[modul]=='do'){
							$content="Delivery Order (DO)";
						}
						elseif ($_GET[modul]=='btb'){
							$content="Receiving Goods (BTB)";
						}
						elseif ($_GET[modul]=='ppe'){
							$content="Personal Protective Equipment (PPE) Request";
						}
						elseif ($_GET[modul]=='bpb'){
							$content="Store Room Requisition (BPB)";
						}
						elseif ($_GET[modul]=='bbk'){
							$content="Return Goods (BBK)";
						}
					echo '| '.$content;?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td valign="top">
		<div class="glossymenu"> 
         <a class="menuitem submenu" href="?modul=project">Project Handling</a>
         <?php if ($_SESSION['userlvl'] == 'administrator') {
         	echo '<a class="menuitem submenu" href="?modul=itempro"><em>Production Item</em></a>
				 <a class="menuitem submenu" href="?modul=activity"><em>Monitoring Activity</em></a>
				 <a class="menuitem submenu" href="?modul=mtu"><em>Monitoring of Tools Usage</em></a>';
		 } ?>
         <a class="menuitem submenu" href="viewequipmentstatus.php" target="_blank"><em>Tools & Equipment Status</em></a>
         <a class="menuitem submenu" href="viewcertificateproduct.php" target="_blank">Certificate Products</a>    
         <a class="menuitem submenu" href="allmtrl/viewallmtrl.php" target="_blank">Materials</a>
         <a class="menuitem submenu" href="?modul=mr">Material/Service Request (M/S R)</a>
         <a class="menuitem submenu" href="?modul=pkg_list">Packing List</a>
         <a class="menuitem submenu" href="?modul=do">Delivery Order (DO)</a>
         <a class="menuitem submenu" href="?modul=btb">Receiving Goods (BTB)</a>
         <?php if ($_SESSION['userlvl'] == 'administrator') {
         	echo '<a class="menuitem submenu" href="?modul=ppe">PPE Request</a>';
		 } ?>
         <a class="menuitem submenu" href="?modul=bpb">Store Room Requisition (BPB)</a>
         <a class="menuitem submenu" href="?modul=bbk">Return Goods (BBK)</a>
        </div>
    </td>
    <td colspan="2" valign="top">
    <iframe src="<?php
                    	if($_GET[modul]=='mr'){
							echo "view_topheadermrsr.php";
						}
						elseif ($_GET[modul]=='activity'){
							echo "../fab/viewmonitoringactivity.php";
						}
						elseif ($_GET[modul]=='itempro'){
							echo "../fab/viewproductionitem.php";
						}
						elseif ($_GET[modul]=='unapproved'){
							echo "../tm/unapproved_crf.php";
						}
						elseif ($_GET[modul]=='notif'){
							echo "../prj/bacanotif.php?data=$usrid";
						}
						elseif ($_GET[modul]=='project'){
							echo "form_ppic.php";
						}
						elseif($_GET[modul]=='mtu'){
							echo "viewmonoftoolsusage.php";
						}
						elseif($_GET[modul]=='pkg_list'){
							echo "pkg_list/view_pl_topheader.php";
						}
						elseif($_GET[modul]=='do'){
							echo "do_viewheader.php";
						}
						elseif($_GET[modul]=='btb'){
							echo "btb/viewpoheader.php";
						}
						elseif($_GET[modul]=='ppe'){
							echo "ppereq_viewheader.php";
						}
						elseif($_GET[modul]=='bpb'){
							echo "bpb_viewheader.php";
						}
						elseif($_GET[modul]=='bbk'){
							echo "bbk/view_bbk_header.php";
						}
						else {
							echo "flash/ppic.html";
						}
					?>" frameborder="0" width="1075" height="550"> </iframe></td>
  </tr>
  <tr>
    <td width="174">&nbsp;</td>
    <td width="453" class="pesan"><?php echo $_GET['pesan']; ?></td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>