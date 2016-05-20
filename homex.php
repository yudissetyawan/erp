<?php
include "config.php";
session_start();
if (empty($_SESSION[username]) AND empty($_SESSION[password]))
{
 header('location:index.php');
}
else
{
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>HOME</title>
<style>
th{
    color: #FFFFFF;
    font-size: 8pt;
    text-transform: uppercase;
    text-align: center;
    padding: 0.1em;
    border-width: 1px;
    border-style: solid;
    border-color: #969BA5;
    border-collapse: collapse;
    background-color: #265180;
}
</style>
</head>
<body>
<?php                 
echo"
<center>USER ONLINE
<table border=1 width='650' align=center>
<tr><th>No</th><th>Username</th><th>Tanggal Login</th><th>Jam Login</th><th>Jam Logout</th><th>Status</th></tr>";
   $sql = mysql_query("SELECT * FROM a_user ORDER BY no DESC");    
   $no=1;
   while($d=mysql_fetch_array($sql))
     {
      echo "<tr><td align=center>$no</td>
                 <td align=center>$d[username]</td>
                 <td align=center>$d[tanggal]</td>
                 <td align=center>$d[jamin]</td>
                 <td align=center>$d[jamout]</td>";
      if($d[status]=='offline')
      {
      echo"<td style='background-color:red' align=center>OFFLINE</td>";
      }      
      else
      {
      echo"<td style='background-color:00ff00' align=center>ONLINE</td>";
      }                            
     echo"</tr>";
      $no++;      
     }
echo "</table>";    
echo "$d[username]";
echo "<br /><br /><input type=button value='LOGOUT' onclick=location.href='logout.php'></a></center>";    
?>
</body>
</html>
<?php
}
?>