<?php
$rStatus = "NULL";
$rError = "NULL";

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

$sql = "SELECT * FROM songs";
$result = $conn->query($sql);
$songCount = $result->num_rows;

echo("<h1> Upload Songs</h1>");
echo("<form action='/spotify/backend/API/V1/bUpload.php' method='post' enctype='multipart/form-data'>");
echo("Select song to upload:<br>");
echo("<input type='file' name='fileToUpload' id='fileToUpload'>");
echo("<br>");
echo("<input type='text' placeholder='Song Name' name='songName'>");
echo("<br>");
echo("<input type='text' placeholder='Song Artist' name='artistName'>");
echo("<br>");
echo("<input type='text' placeholder='Song Image URL' name='imageURL'>");
echo("<br>");
echo("<input type='text' placeholder='Song Lyrics' name='lyricsURL'>");
echo("<br>");
echo("<a>Song ID will be: " . $songCount . "</a><br>");

echo("<input type='submit' value='Upload Song' name='submit'>");
echo("</form>");
