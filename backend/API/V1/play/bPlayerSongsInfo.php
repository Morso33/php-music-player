<?php

//OnAllRequests
$rStatus = "NULL";
$rError = "NULL";
//OnSuccess
$rSongsAmount = 0;


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "spotify";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    $rStatus = "error";
    $rError = "MySql: CON_FAILURE: " . $conn->connect_error;
}

if ($rError == "NULL")
{
    $sql = "SELECT * FROM songs";
    $result = $conn->query($sql);
    $rSongsAmount = $result->num_rows;
}
echo json_encode(array(
    "status" => $rStatus,
    "error" => $rError,
    "amount" => $rSongsAmount,
));
?>