<?php
require_once('../Connections/core.php');
$con = $core;
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("form_erp", $con);

$sql="SELECT * FROM a_production_code WHERE projectcode = ".$_GET['data'];

$result = mysql_query($sql);
$jum = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);

if($jum <=0){
	echo "Production code fo this Project code does not exist";
	}
else{
	echo "<select name='production' id='production'>
			<option value=''>-- production code --</option>";
	
	do {  
			echo "<option value=".$row['id'].">".$row['productioncode']."</option>";
	} while ($row = mysql_fetch_assoc($result));
	  if($jum > 0) {
		  mysql_data_seek($result, 0);
		  $row = mysql_fetch_assoc($result);
	  }
}
mysql_close($con);

?>