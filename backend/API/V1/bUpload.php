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

$songName = $_POST['songName'];
$artistName = $_POST['artistName'];
$imageURL = $_POST['imageURL'];
$songFile = $_FILES['fileToUpload'];
$lyricsURL = $_POST['lyricsURL'];

$target_dir = "../../../songs/";

$file_location = "/spotify/songs/" . basename($songFile["name"]);



$target_file = $target_dir . basename($songFile["name"]);
if (move_uploaded_file($songFile["tmp_name"], $target_file)) {
    echo "The file ". basename( $songFile["name"]). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

$sql = "SELECT * FROM songs";
$result = $conn->query($sql);
$songCount = $result->num_rows;

$sql = "INSERT INTO songs (songname, artistname, songpicture, songurl, id, lyricsurl) VALUES ('$songName', '$artistName', '$imageURL', '$file_location', '$songCount + 1' , '$lyricsURL')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
