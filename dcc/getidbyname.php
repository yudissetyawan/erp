<?php
require_once('../Connections/core.php');

$sql="SELECT * FROM ".$_GET['tab']." WHERE ".$_GET['fl']." = '".$_GET['namex']."'";

$result = mysql_query($sql);
$jum = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
if($jum == 0){
	echo $_GET['namex']." Belum terdaftar ";
	}
else{
	echo"<input type='hidden' name='".$_GET['dv']."' value='".$row['id']."' /> OK";
	}

mysql_close($con);
?>