<?php

//OnAllRequests
$rStatus = "NULL";
$rError = "NULL";
//OnSuccess
$rSongName = "NULL";
$rArtistName = "NULL";
$rSongUrl = "NULL";
$lyricsURL = "NULL";
$rSongImageUrl = "NULL";



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

if ($rError == "NULL") {
    if (isset($_GET['id'])) {
        $songid = $_GET['id'];
        $songid = $conn->real_escape_string($songid);
        $sql = "SELECT * FROM songs WHERE id = '$songid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $rSongName = $row["songname"];
            $rArtistName = $row["artistname"];
            $rSongUrl = $row["songurl"];
            $rSongImageUrl = $row["songpicture"];
            $lyricsURL = $row['lyricsurl'];
            $rStatus = "success";
            $rError = "NULL";
        } else {
            $rStatus = "error";
            $rError = "SONG_NOT_FOUND";
        }
    } else {
        $rStatus = "error";
        $rError = "MISSING_PARAMS";
    }
}



echo json_encode(array(
    "status" => $rStatus,
    "error" => $rError,
    "id" => $songid,
    "songName" => $rSongName,
    "artistName" => $rArtistName,
    "songURL" => $rSongUrl,
    "songImageUrl" => $rSongImageUrl,
    "lyricsURL" => $lyricsURL
));
