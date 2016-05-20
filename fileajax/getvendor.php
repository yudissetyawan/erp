<?php
$q=$_GET["q"];

require_once('../Connections/core.php'); 

//$sql="SELECT * FROM solusi WHERE no_po = ".$q." AND no_tabel =".$nota ;
$sql="SELECT c.*, o.category FROM c_vendor c, 1_category o where c.vendorcategory=o.id and vendorcategory=".$q."";
//$sql ="select * from c_vendor";

$result = mysql_query($sql);

echo "<table border='0' cellpadding='0' cellspacing='2'>
<tr>
<th align='center' bgcolor='#CCCCCC' width='170'>Vendor Name</th>
<th align='center' bgcolor='#CCCCCC' width='180'>Vendor Class</th>
<th align='center' bgcolor='#CCCCCC' width='183'>Vendor Category</th>
<th align='center' bgcolor='#CCCCCC' width='230'>Vendor Email</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td >" . $row['vendorname'] . "</td>";
  echo "<td >" . $row['vendorclass'] . "</td>";
  echo "<td >" . $row['category'] . "</td>";
  echo "<td >" . $row['email'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?>