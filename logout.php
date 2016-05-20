<?php
 include "config.php";
 $jam = date("H:i:s");
  session_start();                        
  mysql_query("UPDATE a_user SET jamout='$jam',
                              status='offline'
  WHERE username = '$_SESSION[username]' AND jamout='logged' AND status='online'");
  session_destroy();
  header('location:index.php?pesan=You has been Successfully Loged Out from System');
?>
