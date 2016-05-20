<?php require_once('Connections/core.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE contact_us SET respond=%s WHERE id=%s",
                       GetSQLValueString($_POST['message'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_core, $core);
  $Result1 = mysql_query($updateSQL, $core) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
}
mysql_select_db($database_core, $core);
$query_Recordset1 = sprintf("SELECT * FROM contact_us WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<h2>Feedback Form</h2>
<?php
// display form if user has not clicked submit
if (!isset($_POST["submit"])) {
  ?>
<form action="<?php echo $editFormAction; ?>" name="form" method="POST">
  <table width="404" border="0">
    <tr>
      <td>From</td>
      <td>:</td>
      <td><input size="35" type="text" name="from" placeholder="Administrator of Bi-SmartS (Bukaka Integrated Smart System)">
        <label for="id"></label>
      <input name="id" type="text" id="id" size="10"></td>
    </tr>
    <tr>
      <td>To</td>
      <td>:</td>
      <td><input name="to" type="text" value="<?php echo $row_Recordset1['email']; ?>" size="35"></td>
    </tr>
    <tr>
      <td>Subject</td>
      <td>:</td>
      <td><input type="text" name="subject" size="50"></td>
    </tr>
    <tr>
      <td>Message</td>
      <td>:</td>
      <td><textarea rows="10" cols="40" name="message"></textarea></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><b>
        <?php
			date_default_timezone_set('Asia/Balikpapan');
			//Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
			$namaHari = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat","Sun");
			$namaBulan = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			$today = date('l, F j, Y');
			$jam = date("H:i");
			$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y')." - ".$jam;
			echo $sekarang; ?>
        <input name="issueddate" type="hidden" id="issueddate" value="<?php echo $sekarang; ?>" />
      </b></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="submit" value="Submit Feedback"></td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="MM_update" value="form">
</form>
  <?php
} else {    // the user has submitted the form
  // Check if the "from" input field is filled out
  if (isset($_POST["from"])) {
    $from = $_POST["from"]; // sender
    $subject = $_POST["subject"];
    $message = $_POST["message"];
	 $to = $_POST["to"];
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 170);
    // send mail
 $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully...";
   }
   else
   {
      echo "Message could not be sent...";
   }
   }
   }

mysql_free_result($Recordset1);
?>