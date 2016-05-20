<html>
<head>
<title>Hitung Umur</title>

</head>
<body>
<form action="" method="post" name="form">
  <p>
    <label>
      Isi Tanggal lahir :
      <input type="text" name="umur" id="umur">
    </label>
    <label>
      <input type="submit" name="submit" id="submit" value="Submit">
    </label>
  </p>
  <p>NB : Format Penulisan Tanggal Lahir 12-11-2013</p>
</form>
<?php
  //calculate years of age (input string: DD-MM-YYYY)
  function age($age){
    list($day,$month,$year) = explode("-",$age);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0) {
      $year_diff--;
    }
    return $year_diff;
  }
 
echo "Umur saya : ".age('$umur')." tahun";
?>
</body>
</html>