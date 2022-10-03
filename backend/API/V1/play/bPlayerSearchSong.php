<?php

//OnAllRequests
$rStatus = "NULL";
$rError = "NULL";
//OnSuccess
$rFoundSongID = 0;


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
    $songname = $_GET['songname'];
    $sql = "SELECT * FROM songs WHERE songname LIKE '%$songname%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rStatus = "success";
        $rError = "NULL";
        $rFoundSongID = $row["id"];
    }
    else
    {
        $rStatus = "error";
        $rError = "NO_SONGS_FOUND";
    }

}


echo json_encode(array(
    "status" => $rStatus,
    "error" => $rError,
    "id" => $rFoundSongID,
)); 
?>