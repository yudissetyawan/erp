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
<link type="text/css" href="css/custom-theme/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>

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

<title>Home - Monitoring Material/Service Request</title>
<link href="css/induk.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>

<body class="General">
<table width="1200" border="0" align="center">
  <tr>
    <td width="1255" class="General" id="font">
    	
        <div id="TabbedPanels1" class="TabbedPanels">
        	<ul class="TabbedPanelsTabGroup">
            	<li class="TabbedPanelsTab" tabindex="0">Material / Service Request (M/S R)</li>
				<li class="TabbedPanelsTab" tabindex="0">Purchase Order (PO)</li>
			</ul>
            <div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent">
                    <iframe src="ppic/mr_mon/view_headermrsr_mon.php" frameborder="0" width="1200" height="520"> </iframe>
                </div>
                <div class="TabbedPanelsContent">
                    <?php
                    //if (($_SESSION['userlvl'] == 'procurement') || ($_SESSION['userlvl'] == 'administrator')) {
						echo '<iframe src="proc/viewpoheader.php" frameborder="0" width="1200" height="520"> </iframe>';
					//} else {
						//echo 'In Progress';
					//} ?>
                </div>
			</div>
		</div>
	</td>
  </tr>
</table>

<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1", {defaultTab:1});
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>

</body>
</html>