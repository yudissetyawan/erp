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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project - WPR Detail</title>
<link href="../css/induk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function datediff($tgl1, $tgl2){
	 $tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	 $tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
 	  $diff_secs = abs($tgl1 - $tgl2);
	 $base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	 $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	 return array( "years" => date("Y", $diff) - $base_year,
	"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"months" => date("n", $diff) - 1,
	"days_total" => floor($diff_secs / (3600 * 24)),
	"days" => date("j", $diff) - 1 ),
	 "hours_total" => floor($diff_secs / 3600),
	"hours" => date("G", $diff),
	"minutes_total" => floor($diff_secs / 60),
	"minutes" => (int) date("i", $diff),
	"seconds_total" => $diff_secs,
	"seconds" => (int) date("s", $diff)  );
	 }
</script>

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
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="/css/induk.css" rel="stylesheet" type="text/css" />
</head>

	
<body>
<?php {
include "../date.php";
  }
?>
<table width="1270" border="0" align="center">
  <tr>
    <td colspan="5" align="left" class="General" id="font"><div id="TabbedPanels1" class="VTabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">Activities </li>
        <li class="TabbedPanelsTab" tabindex="0">Major Issue</li>
        <li class="TabbedPanelsTab" tabindex="0">Milestone</li>
        <li class="TabbedPanelsTab" tabindex="0">Activities Cumm.</li>
        <li class="TabbedPanelsTab" tabindex="0">S-Curve</li>
        <li class="TabbedPanelsTab" tabindex="0">SUMMARY</li>
        <li class="TabbedPanelsTab" tabindex="0">E.P.C Activities</li>
      </ul>
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <form id="form1" name="form1" method="POST">
            <table width="638" border="1" cellspacing="0" cellpadding="0">
              <tr class="tabel_header">
                <td width="203" >&nbsp;</td>
                <td width="206" > Planned Date</td>
                <td width="229"> Actual Date</td>
              </tr>
              <tr class="tabel_body">
                <td>Engineering </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr class="tabel_body">
                <td>Procurement</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr class="tabel_body">
                <td>Fabrication</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr class="tabel_body">
                <td> Instalation</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table>
          </form>
          
          </div>
        <div class="TabbedPanelsContent">
          <form id="form3" name="form3" method="POST">
            <table width="627" border="1">
              <tr class="tabel_header">
                <td>No</td>
                <td>Description</td>
                <td>Action Plan</td>
                </tr>
              <tr class="tabel_body">
                <?php $o=$o+1; ?>
                <td><?php echo $o ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <form id="form2" name="form3" method="post">
            <table width="522" border="1">
              <tr class="tabel_header">
                <td width="170">Procurement Complete</td>
                <td width="176">Fabrication Complete</td>
                <td width="154">Instalation Coomplete</td>
              </tr>
              <tr class="tabel_body">
                <?php $o=$o+1; ?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </div>
        <div class="TabbedPanelsContent">
          <table width="502" border="0" cellpadding="2" cellspacing="2">
            <tr class="tabel_header">
              <td>Activities</td>
              <td>Weight</td>
              <td>Planned</td>
              <td>Actual</td>
              <td>Variance</td>
              <td>-------</td>
            </tr>
            <tr class="tabel_body">
              <td class="tabel_body">Engineering</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
              </tr>
            <tr class="tabel_body">
              <td class="tabel_body">Procurement</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
              </tr>
            <tr class="tabel_body">
              <td class="tabel_body">Fabrication</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
              </tr>
            <tr class="tabel_body">
              <td class="tabel_body">Installation</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
              </tr>
            <tr class="tabel_body">
              <td class="tabel_body">Miscellanous</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
              <td class="tabel_body">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6">&nbsp;</td>
              </tr>
            <tr class="tabel_header">
              <td class="tabel_header">Total Progress</td>
              <td class="tabel_header">&nbsp;</td>
              <td class="tabel_header">&nbsp;</td>
              <td class="tabel_header">&nbsp;</td>
              <td class="tabel_header">&nbsp;</td>
              <td class="tabel_header">&nbsp;</td>
            </tr>
          </table>
        </div>
        <div class="TabbedPanelsContent">Content 16</div>
		<div class="TabbedPanelsContent">
		  <table width="344" cellpadding="2" cellspacing="2">
		    <tr>
		      <td width="145" class="tabel_header">Start Date</td>
		      <td width="4">:</td>
		      <td width="74">&nbsp;</td>
		      <td width="74">&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Finish Date</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td colspan="4" bgcolor="#BFC3DE">&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Forecast Completion</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">On Schedule</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td align="center">days</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Planned Duration</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td align="center">days</td>
		      </tr>
		    <tr>
		      <td colspan="4" bgcolor="#BFC3DE">&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Time Elapsed</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td align="center">days</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Time Remaining</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td align="center">days</td>
		      </tr>
		    <tr>
		      <td colspan="4" bgcolor="#BFC3DE">&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Cm/tv Plan Progress</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Cm/tv Actual Progress</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td colspan="4" bgcolor="#BFC3DE">&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Variance </td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Incr. Actual</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td class="tabel_header">Est. Complete</td>
		      <td>:</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    </table>
		</div>
        <div class="TabbedPanelsContent">
          <table width="638" border="0,5" cellpadding="2" cellspacing="2">
            <tr class="tabel_header">
              <td colspan="3">Major Activities</td>
              </tr>
            <tr class="tabel_header">
              <td class="tabel_header">&nbsp;</td>
              <td class="tabel_header"> Accomplishment - This Period</td>
              <td class="tabel_header">Objective - Next Week</td>
            </tr>
            <tr>
              <td>Engineering</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" bgcolor="#BFC3DE">&nbsp;</td>
              </tr>
            <tr>
              <td>Procurement</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" bgcolor="#BFC3DE">&nbsp;</td>
              </tr>
            <tr>
              <td>Fabrication</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" bgcolor="#BFC3DE">&nbsp;</td>
              </tr>
            <tr>
              <td>Installation</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" bgcolor="#BFC3DE">&nbsp;</td>
              </tr>
          </table>
        </div>
</div>
<p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top" id="font"><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="594">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="649" colspan="2" align="right" class="General" id="font">&copy; 2012 Bukaka Balikpapan</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</body>
</html>