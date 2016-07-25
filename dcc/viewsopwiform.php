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

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM h_employee WHERE username = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$usrid = $_SESSION['empID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Home DCC</title>
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
	, //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
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
</head>

<body>
<table width="1270" border="0" align="center">
  <tr>
    <td height="64" colspan="2" rowspan="2"><img src="../images/Logo_ERP.jpg" alt="" width="350" height="62" align="left" /></td>
    <td width="628" align="right" valign="top"><table width="439" border="0" align="right" cellpadding="1" cellspacing="1">
      <tr class="demoHeaders">
        <td width="8" align="right" valign="bottom">|</td>
        <td width="250" align="right" valign="bottom" class="demoHeaders">Your Logged as <a href="../hrd/karyawan/viewdata_karyawan_print.php?data=<?php echo $_SESSION['empID']; ?>"><b><?php echo $_SESSION['MM_Username']?></b></a></td>
        <td width="9" class="demoHeaders">|</a></td>
        <td width="85" class="demoHeaders"><a href="../contact.php">Contact Us</a></td>
        <td width="8" class="demoHeaders">|</td>
        <td width="63" class="demoHeaders"><a href="<?php echo $logoutAction ?>">Logout</a></td>
        <td align="right" width="10">|</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="bottom">
    	<?php { include "../menu_notification.php"; } ?>
    </td>
  </tr>
  
  
  <tr>
    <td align="right" bgcolor="#8db4e3" class="tabel_index" id="font">Standard Document</td>
    <td colspan="2" align="right" bgcolor="#8db4e3" id="font"><table width="387" height="17" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr class="root">
        <td width="48" bgcolor="#EFEFEF" class="root"><a href="../home.php">Home</a></td>
        <td width="1" align="right" bgcolor="#EFEFEF" class="root"></td>
        <td width="338" align="right" bgcolor="#EFEFEF" class="root"><b><?php
                    	if ($_GET[modul] == 'org_doc'){
							$content = "Organization Document";
						} else if ($_GET[modul] == 'sop'){
							$content = "Standard Operating Procedure (SOP)";
						} else if ($_GET[modul] == 'wi'){
							$content = "Work Instruction (WI)";
						} else if ($_GET[modul] == 'form'){
							$content = "Form";
						} else if ($_GET[modul] == 'ohsdoc'){
							$content = "HSe Document (OHSAS 18001)";
						} else if ($_GET[modul] == 'view_qo') {
							$content = "Quality Objective (QO)";
						} elseif ($_GET[modul] == 'audit'){
							$content = "Internal Audit Report (IAR) per Department";
						} else{
							$content = "Standard Operating Procedure (SOP)";
						}
					echo '| '.$content;?></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td rowspan="2" valign="top">  <div class="glossymenu"> 
              <a class="menuitem submenu" href="?modul=sop">Standard Operating Procedure (SOP)</a>
              <a class="menuitem submenu" href="?modul=wi">Work Instruction (WI)</a>
              <a class="menuitem submenu" href="?modul=form">Form</a>
              <a class="menuitem submenu" href="?modul=ohsdoc">HSe Document (OHSAS 18001)</a>
              <a class="menuitem submenu" href="?modul=org_doc" title="It's consist of : Organization Chart (STO), Job Description (JD), Job Specification (JS), Skill Map (SM), Analisa Kompetensi Personil (AKP), Training Need Analysis (TNA), Quality Objective (QO), Internal Audit Report (IAR) per Dept.">Organizational Document</a>
		<?php if (($_SESSION['userlvl'] != 'administrator') && ($_SESSION['userlvl'] != 'branchmanager')) { ?>
              <a class="menuitem submenu" href="?modul=view_qo">Key Performance Indicator(KPI)</a>
              <a class="menuitem submenu" href="?modul=audit">Internal Audit</a>
		<?php } ?>
			</div>
		</td>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><iframe src="<?php
                    	if($_GET[modul] == 'sop'){
							echo "viewSOP.php";
						} else if ($_GET[modul] == 'wi'){
							echo "viewWI.php";
						} else if ($_GET[modul] == 'form'){
							echo "viewForm.php";
						} else if ($_GET[modul] == 'ohsdoc'){
							echo "../hse/hsedoc_view.php";
						} else if ($_GET[modul] == 'org_doc'){
							if (($_SESSION['userlvl'] == 'administrator') || ($_SESSION['userlvl'] == 'branchmanager')) {
								echo "doc_perdept_view.php";
							} else {
								echo "doc_perdept_view.php?vcat=org";
							}
						} else if ($_GET[modul] == 'view_qo'){
							echo "doc_perdept_view.php?vcat=qo";
						} else if ($_GET[modul] == 'audit'){
							echo "doc_perdept_view.php?vcat=adt";
						} else if ($_GET[modul] == 'unapproved'){
							echo "../tm/unapproved_crf.php";
						} else if ($_GET[modul] == 'notif'){
							echo "../prj/bacanotif.php?data=$usrid";
						} else if ($_GET[modul] == 'absenndcuti'){
							echo "../hrd/absnkary/vwabsencendleave.php?data=$usrid";
						} else{
							echo "viewSOP.php";
						}
					?>" frameborder="0" width="1075" height="550"> </iframe></td>
  </tr>
  <tr>
    <td width="174">&nbsp;</td>
    <td width="453">&nbsp;</td>
    <td align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
</body>
</html>
<?php
	mysql_free_result($Recordset1);
?>