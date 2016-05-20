<?php

// -- database server initialization
$servername = "localhost";
$username = "root";
$password = "Sm4k3nz4";
$dbname = "form_erp";
$conn = new mysqli($servername, $username, $password, $dbname) or die('No Connection');
$id=$_GET['id'];
$status=$_GET['status'];

// -- get Employee name from database using ID from fingerprint sensor
$sql2 = "SELECT * FROM h_employee WHERE id_attendance='$id'";
$result = $conn->query($sql2);
$dateStamp = date("Y-m-d H:i:s");

if ($result->num_rows > 0) 
{
     // output data of each row
     while($row = $result->fetch_assoc()) 
     {
         $firstname = $row['firstname'];
         $lastname = $row['lastname'];
     }

    // get newest record
    $lastQuery = $conn->query("SELECT * FROM `h_absen_core` WHERE id = '$id' ORDER BY intime DESC LIMIT 1");
    $lastNum = $lastQuery->num_rows;
    if ($lastNum > 0){
        while($last = $lastQuery->fetch_assoc())
        {
            $idTransaksi = $last['transaction_id'];
            $employee = $last['id'];
            $intime = $last['intime'];
            $outtime = $last['outtime'];
        }
    }

    // employee in
    if ($status == 0){
        $sqlIn = "INSERT INTO h_absen_core (id, intime) VALUES ('$id', '$dateStamp')";
        if ($lastNum == 0){
            if ($conn->query($sqlIn) === TRUE) {
                echo "$firstname $lastname Attendance Time Submited";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else {
            $nowTime = "" . date("Y-m-d", strtotime($dateStamp)) ;
            $lastTime = "" . date("Y-m-d", strtotime($intime)) ;

            if (strcmp($nowTime,$lastTime) != 0){
                if ($conn->query($sqlIn) === TRUE) {
                    echo "$firstname $lastname Attendance Time Submited";
                }
                else
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }else{
                echo "Alredy submited";
            }
        }
    }else { // employee out
        if ($lastNum == 0){
            echo "attendance null";
        }elseif($outtime == NULL){
            $sqlOut = "UPDATE h_absen_core SET outtime = '$dateStamp' WHERE h_absen_core.transaction_id = '$idTransaksi'";
            if ($conn->query($sqlOut) === TRUE) {
                echo "$firstname $lastname Attendance Time Submited";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }else{
            echo "Alredy submited";
        }
    }

}
// -- eror handler
else 
{
     echo "ID Employee not found";
}

$conn->close();   
?>
