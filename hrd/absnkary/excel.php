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

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->applyFromArray(
                                                     array(
                                                         'borders' => array(
                                                             'allborders' => array(
                                                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                                                             )
                                                         ),
                                                         'font' => array(
                                                                         'bold' => true
                                                                     )
                                                     )
                                                 );

$str = 'A';
$objPHPExcel->getActiveSheet()
        ->getColumnDimension($str)->setWidth(25);

$daysO = $days+1;

for ($n=1; $n<=$days; $n++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension(++$str)->setWidth(10);

    if($n == $days){
        for($k = 1; $k<=4;$k++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$k.':'.$str.''.$k)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
            );
        }
    }
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($str.'1', ''.$n);
}


$objPHPExcel->getActiveSheet()
        ->getColumnDimension(++$str)->setWidth(15);

for($k = 1; $k<=4;$k++){
    $objPHPExcel->getActiveSheet()->getStyle('A'.$k.':'.$str.''.$k)->applyFromArray(
        array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );
}


$objPHPExcel->getProperties()->setTitle("Absensi-Prototype")
        ->setDescription("prototype document excel");

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Date')
        ->setCellValue('A2', 'In Time')
        ->setCellValue('A3', 'Out Time')
        ->setCellValue('A4', 'Jam')
        ->setCellValue($str.'1','Total');

$str = 'B';
for ($x = 1; $x <= $days; $x++) {
    $dataIn = getData($dataId, $x, $month, $year, 'intime');
    if(($dataIn[0] > 0) && ($dataIn[2] != null)){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($str.'2' , ''.date("H:i:s",strtotime("$dataIn[2]")));
    }
    ++$str;
}

$str = 'B';
for ($x = 1; $x <= $days; $x++) {
    $dataIn = getData($dataId, $x, $month, $year, 'outtime');
    if(($dataIn[0] > 0) && ($dataIn[2] != null)){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($str.'3' , ''.date("H:i:s",strtotime("$dataIn[2]")));
    }else{
        if(($dataIn[0] > 0) && ($dataIn[2] != null)){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($str.'3' , '0');
        }
    }
    ++$str;
}

$currentIn = "00:00:00";
$currentOut = "00:00:00";
$status = 'intime';
$totalJam = 0;
$str = 'B';
for ($x = 1; $x <= $days; $x++) {
    $dataAbsen = getData($dataId, $x, $month, $year, $status);
    if ($dataAbsen[0] > 0){
        $currentIn = $dataAbsen[1];
        if($dataAbsen[2] != null){
            $currentOut = $dataAbsen[2];
            $total = totalTime($currentIn,$currentOut);
            $status= 'intime';
            $totalJam = $totalJam + $total[1];
            echo "$total[1]";
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($str.'4' , ''.$total[1]);
        }else{
            $status= 'outtime';
        }
    }
    if($x == $days){
        $plusone = $x +2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(++$str.'4', ''.$totalJam);
    }
    ++$str;
}

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A7', 'Year = '.$year.'/ Month ='.$month);

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Data Absensi');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
ob_end_clean();


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');


$objWriter->save('php://output');
exit;

?>