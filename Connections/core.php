<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_core = "localhost";
$database_core = "form_erp";
$username_core = "root";
$password_core = "Sm4k3nz4";
$core = mysql_pconnect($hostname_core, $username_core, $password_core) or trigger_error(mysql_error(),E_USER_ERROR); 
?>