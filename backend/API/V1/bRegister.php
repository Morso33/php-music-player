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


if ($rError == "NULL") {
    if (isset($_GET['username']) && isset($_GET['firstname']) && isset($_GET['lastname']) && isset($_GET['password']) && isset($_GET['email'])) {
        $username = $_GET['username'];
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        $password = $_GET['password'];
        $email = $_GET['email'];
        $username = $conn->real_escape_string($username);
        $sql = "SELECT * FROM users WHERE uUsername = '$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $rStatus = "error";
            $rError = "USERNAME_TAKEN";
        } else {
            //bcrypt password
            $ePassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (uUsername, uFirstname, uLastname, uPassword, uEmail) VALUES ('$username', '$firstname', '$lastname', '$ePassword', '$email')";
            if ($conn->query($sql) === TRUE) {
                $rStatus = "success";
                $rError = "NULL";
            } else {
                $rStatus = "error";
                $rError = "SQL_FAILURE: " . $conn->error;
            }
        }
    } else {
        $rStatus = "error";
        $rError = "MISSING_PARAMS";
    }
}
echo json_encode(array(
    "status" => $rStatus,
    "error" => $rError,
));
