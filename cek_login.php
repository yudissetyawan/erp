<?php
include "config.php";
function antiinjection($data){
  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;
}

$username = antiinjection($_POST[username]);
$pass     = antiinjection($_POST[password]);

$login = mysql_query("SELECT * FROM h_employee WHERE username='$username' AND password='$pass'");
$ketemu = mysql_num_rows($login);
$r = mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0)
{
  session_start();
  session_register("username");
  session_register("password");

  $_SESSION[username] = $r[username];
  $_SESSION[password] = $r[password];
  $_SESSION['empID'] = $r['id'];

  $jam = date("H:i:s");
  $tgl = date("Y-m-d");

  mysql_query("INSERT INTO a_user(username,
                                 tanggal,
                                 jamin,
                                 jamout,
                                 status)
                           VALUES('$_SESSION[username]',
                                '$tgl',
                                '$jam',
                                'logged',
                                'online')");

  header('location:home.php');
}
else
{
  echo "<center><br><br><br><br><br><br><b>LOGIN GAGAL! </b><br>
        Username atau Password Anda tidak benar.<br>";
    echo "<br>";
  echo "<input type=button value='ULANGI LAGI' onclick=location.href='index.php'></a></center>";

}
?>