<?php
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

if (isset($_GET['session'])) {
    $session = $_GET['session'];
    $session = $conn->real_escape_string($session);
    $sql = "SELECT * FROM users WHERE uWebsession = '$session'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    } else {
        echo ("Your session has expired. Please log in again.");
        echo ("<br>");
        echo ("Automatically redirecting you to the login page.");
        echo ("<br>");
        echo ("If your browser does not redirect you, please click <a href='/spotify/log_reg/login.html'>here</a>.");
        header('Refresh: 2; URL=/spotify/log_reg/login.html');
        exit;
    }
} else {
    echo ("You are not logged in.");
    echo ("<br>");
    echo ("Automatically redirecting you to the login page.");
    echo ("<br>");
    echo ("If your browser does not redirect you, please click <a href='/spotify/log_reg/login.html'>here</a>.");
    header('Refresh: 2; URL=/spotify/log_reg/login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GorgoFy</title>
    <link rel="stylesheet" href="../css/player.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body onload="onPageLoad()">


    <button onclick="clearFavourites()">Clear Favourites</button>
    <button id="darkselector" onclick="toggleDarkMode()">Dark Mode: Disabled</button>
    <button onclick="location.href='/spotify/upload.php'">Upload Songs</button>


    <h1 id="searchSongIndicatior">Search</h1>
    <input type="text" id="searchSong" placeholder="Search for songs, artists, albums, playlists, etc.">
    <button onclick="searchSong()"><i class="bi bi-search"></i></button>

    <h1>Favourites</h1>
    <div id="favourites">
    </div>

    <!--SongInfo-->
    <div id="songInfo">
        <img width="200" height="200" id="artistImage"></img>
        <h1 id="songTitle"></h1>
        <br>
        <h1 id="songArtist"></h1>
        <div id="lyrics"></div>
    </div>

    <div class="footer">

        <!--The player-->
        <button class="footerItem" onclick="onPressPausePlay()" id="buttonPlayer">Play</button>
        <!--The HTML player. This will be hidden using the hidden style attribute-->
        <audio id="player">
            <source src="">
        </audio>
        <!--Audio slider-->
        <input class="footerItem" type="range" min="1" max="100" value="50" id="audioSlider" oninput="onAudioChangeCallback()">
        <!--OnNext-->
        <button class="footerItem" onclick="onPlayerNextTrack()" id="buttonNext">Next</button>
        <!--OnLast-->
        <button class="footerItem" onclick="onPlayerLastTrack()" id="buttonLast">Previous</button>
        <!--progress bar-->
        <input class="footerItem" type="range" min="0" max="1" value="0" id="progressSlider" oninput="onProgressChangeCallback()">
        <!--Time indicatior-->
        <a class="footerItem" id="timeIndicator">0:00 / 0:00</a>
        <!--Looping button-->
        <button class="footerItem" onclick="onPressLooping()" id="buttonLoop">Looping: Disabled</button>
        <!--Shuffle button-->
        <button class="footerItem" onclick="onPressShuffle()" id="buttonShuffle">Shuffle: Disabled</button>
        <!--AutoPlay button-->
        <button class="footerItem" onclick="onPressAutoPlay()" id="buttonAutoPlay">AutoPlay: Disabled</button>
        <!--Favourite button-->
        <img id="favBtn" class="footerItem" onclick="onSongFavourite()" height=20 width=20 src="/spotify/img/heart.png"></img>
        <!--Player end-->

    </div>
    <!--The player javascript must be loaded last-->
    <script src="../js/player.js"></script>
</body>

</html>