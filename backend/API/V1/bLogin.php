<?php

$rStatus = "NULL";
$rError = "NULL";
$websession = "NULL";

//Connect to server
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "spotify";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    $rStatus = "error";
    $rError = "CON_FAILURE: " . $conn->connect_error;
}

if ($rError == "NULL")
{
    if (isset($_GET['username']) && isset($_GET['password'])) {
        $username = $_GET['username'];
        $password = $_GET['password'];
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);
        $sql = "SELECT * FROM users WHERE uUsername = '$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["uPassword"])) {
                $websession = md5(uniqid(rand(), true));
                $sql = "UPDATE users SET uWebsession = '$websession' WHERE uUsername = '$username'";
                if ($conn->query($sql) === TRUE) {
                $rStatus = "success";
                $rError = "NULL";
                $rwebSession = $websession;
                } else {
                    $rStatus = "error";
                    $rError = "SQL_FAILURE: " . $conn->error;
                }
            }
            else
            {
                $rStatus = "error";
                $rError = "USERNAME_PASSWORD_MISMATCH";
            }
        }
        else
        {
            $rStatus = "error";
            $rError = "USER_DOES_NOT_EXIST";
        }
    }
    else
    {
        $rStatus = "error";
        $rError = "MISSING_PARAMS";
    }
}
//Respond
echo json_encode(array(
    "status" => $rStatus,
    "error" => $rError,
    "websession" => $websession,
));

//Functions
function generateRandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 32; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>