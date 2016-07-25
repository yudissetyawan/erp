<?php require_once('../../Connections/core.php'); ?>
<?php require_once ('Classes/PHPExcel.php'); ?>
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

$colname_Recordset1 = "-1";
$dataId=0;
$month = date('n');
$monthName = date('M', mktime(0, 0, 0, $month, 10));
$year = date('Y');
$days = date("t");
if (isset($_GET['data'])) {
  $colname_Recordset1 = $_GET['data'];
    $dataId=$_GET['data'];
}

if ((isset($_GET['month'])) || (isset($_GET['year']))) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $monthName = date('M', mktime(0, 0, 0, $month, 10));
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
}


mysql_select_db($database_core, $core);
$query_Recordset = sprintf("SELECT * FROM h_employee WHERE 
                                 id = %s" , GetSQLValueString($dataId, "int"));
$Recordset = mysql_query($query_Recordset, $core) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);

// Time Calculation operation
/**
 * @param $in
 * @param $out
 * @return int
 */
function getData($id, $tanggal, $bulan, $tahun, $status) {
    global $core;
    $query_Recordset1 = sprintf("SELECT * FROM h_absen_core WHERE 
                                 id = %s AND 
                                 YEAR($status) = $tahun AND 
                                 MONTH($status) = $bulan AND 
                                 DAY($status)= $tanggal", GetSQLValueString($id, "int"));
    $Recordset1 = mysql_query($query_Recordset1, $core) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysql_num_rows($Recordset1);

    $intime = $row_Recordset1['intime'];
    $outtime = $row_Recordset1['outtime'];
    $total = $totalRows_Recordset1;
    mysql_free_result($Recordset1);

    $data = array($total,$intime,$outtime);
    return $data;
}

function totalTime($in, $out) {
  $IN = new DateTime($in);
  $OUT = new DateTime($out);

  $diff = $IN->diff($OUT);
  $data = array($diff->d, $diff->h, $diff->i);
  return $data;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Time Card Details</title>
    <link href="assets/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/eonasdan/build/css/bootstrap-datetimepicker.min.css" />
</head>

<body>
<div class="container-fluid" style="margin-top: 25px;">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-inline">
                <div class="form-group">
                    <lable for="pickBulan"><b>Bulan</b></lable>
                    <input type='text' class="form-control" value="<?php echo "$monthName $year"; ?>" name="pickBulan" id='pickBulan'/>
                </div>
                <button class="btn btn-primary" id='changeButton'>Change Date</button>
                <a href="http://erp.btubpn.com/hrd/absnkary/excel.php?month=<?php echo $month ?>&year=<?php echo $year ?>&data=<?php echo $dataId ?>" class="pull-right btn btn-success">Excel</a>
            </div>
        </div>
    </div>
    <div class="row" style=" margin-top: 25px;">
        <div class="col-xs-12"><p><b>
            <?php
                echo $row_Recordset['firstname'];
                if ($row_Recordset['midlename'] != NULL) echo $row_Recordset['midlename'];
                if ($row_Recordset['lastname'] != NULL) echo $row_Recordset['lastname'];
            ?>
                </b>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th></th>
                    <?php
                    for ($x = 1; $x <= $days; $x++) {
                        echo "<th> $x </th>";
                    }
                    ?>
                    <th>total</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <th>In</th>
                    <?php
                    for ($x = 1; $x <= $days; $x++) {
                        $dataIn = getData($dataId, $x, $month, $year, 'intime');
                        echo "<td>";
                        if($dataIn[0] > 0){
                            echo date("H:i:s",strtotime("$dataIn[1]"));
                        }
                        echo"</td>";
                    }
                    ?>
                    <th></th>
                </tr>
                <tr>
                    <th>Out</th>
                    <?php
                    for ($x = 1; $x <= $days; $x++) {
                        $dataIn = getData($dataId, $x, $month, $year, 'outtime');
                        echo "<td>";
                        if(($dataIn[0] > 0) && ($dataIn[2] != null)){
                            echo date("H:i:s",strtotime("$dataIn[2]"));
                        }
                        echo"</td>";
                    }
                    ?>
                    <th></th>
                </tr>
                <tr>
                    <th>Jam</th>
                    <?php

                    $currentIn = "00:00:00";
                    $currentOut = "00:00:00";
                    $status = 'intime';
                    $totalJam = 0;
                    for ($x = 1; $x <= $days; $x++) {
                        echo "<td>";
                        $dataAbsen = getData($dataId, $x, $month, $year, $status);
                        if ($dataAbsen[0] > 0){
                            $currentIn = $dataAbsen[1];
                            if($dataAbsen[2] != null){
                                $currentOut = $dataAbsen[2];
                                $total = totalTime($currentIn,$currentOut);
                                $status= 'intime';
                                $totalJam = $totalJam + $total[1];
                                echo "$total[1]";
                            }else{
                                $status= 'outtime';
                            }
                        }
                     echo"</td>";
                    }
                    ?>
                    <th><?php echo "$totalJam"; ?></th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="assets/jquery1.11.3/jquery.js"></script>

<script type="text/javascript" src="assets/moment/moment.js"></script>

<script type="text/javascript" src="assets/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="assets/eonasdan/build/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('#pickBulan').datetimepicker({
            viewMode: 'months',
            format: 'MMMM YYYY'
        });
        $('#pickBulan').on("dp.change", function() {
            datePick = $('#pickBulan').data('date');
            datese = datePick.split(' ');
            month = new Date(Date.parse(datese[0] +" 1, 2012")).getMonth()+1;
            dataid = <?php echo $dataId;?>;
            yearPick = datese[1];
            window.open("http://erp.btubpn.com/hrd/absnkary/timecarddetail.php?month=" + month + "&year=" + yearPick + "&data=" +dataid,"_self");

        });
    });
</script>
</body>
</html>
<?php
mysql_free_result($Recordset);
?>