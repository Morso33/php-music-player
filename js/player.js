let player;
let button;
let onNext;
let onLast;
let looping = false;
let autoPlay = false;
let shuffle = false;
let favouriteList = [];

let currentSongID = -1;
let maxSongs = 0;

function onPageLoad() {
  player = document.getElementById("player");
  button = document.getElementById("buttonPlayer");
  onNext = document.getElementById("buttonNext");
  onLast = document.getElementById("buttonLast");
  fetchAsync("/spotify/backend/API/V1/play/bPlayerSongsInfo.php").then(
    function (data) {
      maxSongs = data.amount - 1;
      onPlayerNextTrack();
      onPlayerLastTrack();
      onPlayerLastTrack();
      setInterval(updateSongProgress, 100);
    }
  );
  if (localStorage.getItem("favouriteList") != null) {
    favouriteList = JSON.parse(localStorage.getItem("favouriteList"));
    for (i = 0; i < favouriteList.length; i++) {
      fetchAsync(
        "/spotify/backend/API/V1/play/bPlayerPlaySongByID.php?id=" +
          favouriteList[i]
      ).then(function (data) {
        document.getElementById("favourites").innerHTML +=
          "<li>" +
          "<a onclick ='onPlayerSelectTrack(" +
          data.id +
          ")'><strong>Click here to play! </strong></a>" +
          data.songName +
          " | " +
          data.artistName +
          "</li>";
      });
    }
  }
}

function clearFavourites() {
  localStorage.clear();
  location.reload();
}

function onSongFavourite() {
  if (favouriteList.includes(currentSongID)) {
    alert("Already in favourites!");
    return;
  }

  favouriteList.push(currentSongID);
  localStorage.setItem("favouriteList", JSON.stringify(favouriteList));
  favouriteList = JSON.parse(localStorage.getItem("favouriteList"));
  location.reload();
}

/*PLAYER*/
function onPressPausePlay() {
  if (!player) {
    alert("Player not found.");
    return false;
  }
  if (player.paused) {
    playerEventOnPlay();
  } else {
    playerEventOnPause();
  }
}

function playerEventOnPlay() {
  button.innerHTML = "Pause";
  player.play();
}
function playerEventOnPause() {
  button.innerHTML = "Play";
  player.pause();
}

function playerOnReload() {
  player.load();
}

function toggleDarkMode() {
  var element = document.body;
  element.classList.toggle("dark-mode");
  let darkMode = document.getElementById("darkselector");
  if (darkMode.innerHTML == "Dark Mode: Disabled") {
    darkMode.innerHTML = "Dark Mode: Enabled";
  } else {
    darkMode.innerHTML = "Dark Mode: Disabled";
  }
}

function onPressLooping() {
  if (shuffle) {
    shuffle = false;
    document.getElementById("buttonShuffle").style.color = "black";
    document.getElementById("buttonShuffle").innerHTML = "Shuffle: Disabled";
  }
  if (autoPlay) {
    autoPlay = false;
    document.getElementById("buttonAutoPlay").style.color = "black";
    document.getElementById("buttonAutoPlay").innerHTML = "AutoPlay: Disabled";
  }

  if (looping) {
    looping = false;
    document.getElementById("buttonLoop").style.color = "black";
    document.getElementById("buttonLoop").innerHTML = "Looping: Disabled";
  } else {
    looping = true;
    document.getElementById("buttonLoop").style.color = "red";
    document.getElementById("buttonLoop").innerHTML = "Looping: Enabled";
  }
}

function onPressAutoPlay() {
  if (looping) {
    looping = false;
    document.getElementById("buttonLoop").style.color = "black";
    document.getElementById("buttonLoop").innerHTML = "Looping: Disabled";
  }

  if (autoPlay) {
    autoPlay = false;
    document.getElementById("buttonAutoPlay").style.color = "black";
    document.getElementById("buttonAutoPlay").innerHTML = "AutoPlay: Disabled";
  } else {
    autoPlay = true;
    document.getElementById("buttonAutoPlay").style.color = "red";
    document.getElementById("buttonAutoPlay").innerHTML = "AutoPlay: Enabled";
  }
}

function onPressShuffle() {
  if (looping) {
    looping = false;
    document.getElementById("buttonLoop").style.color = "black";
    document.getElementById("buttonLoop").innerHTML = "Looping: Disabled";
  }

  if (shuffle) {
    shuffle = false;
    document.getElementById("buttonShuffle").style.color = "black";
    document.getElementById("buttonShuffle").innerHTML = "Shuffle: Disabled";
  } else {
    shuffle = true;
    document.getElementById("buttonShuffle").style.color = "red";
    document.getElementById("buttonShuffle").innerHTML = "Shuffle: Enabled";
  }
}

function searchSong() {
  document.getElementById("searchSongIndicatior").innerHTML = "Searching...";
  var startTime = performance.now();
  fetchAsync(
    "/spotify/backend/API/V1/play/bPlayerSearchSong.php?songname=" +
      document.getElementById("searchSong").value
  ).then(function (data) {
    if (data.error != "NULL") {
      document.getElementById("searchSongIndicatior").innerHTML = data.error;
      document.getElementById("searchSongIndicatior").style.color = "red";
      setTimeout(function () {
        document.getElementById("searchSongIndicatior").innerHTML = "Search";
        document.getElementById("searchSongIndicatior").style.color = "black";
      }, 2000);
      return;
    }
    var endTime = performance.now();
    document.getElementById("searchSongIndicatior").innerHTML =
      "Found Song! API took:  " + Math.floor(endTime - startTime) + "ms";
    document.getElementById("searchSongIndicatior").style.color = "green";
    setTimeout(function () {
      document.getElementById("searchSongIndicatior").innerHTML = "Search";
      document.getElementById("searchSongIndicatior").style.color = "black";
    }, 2000);

    onPlayerSelectTrack(data.id);
    document.getElementById("searchSong").value = "";
  });
}

function onAudioChangeCallback() {
  var audioLevel = document.getElementById("audioSlider").value;
  player.volume = (audioLevel - 1) / 100; //The players volume is 0-1 while the slider is 0-100
}
function onProgressChangeCallback() {
  var songProgress = document.getElementById("progressSlider").value;
  player.currentTime = songProgress;
}

async function updateSongProgress() {
  var songMaxLength = document.getElementById("player").duration;
  document.getElementById("progressSlider").max = songMaxLength;

  var songProgress = player.currentTime;
  var songTimeIndicator = document.getElementById("timeIndicator");
  var progressMinutes = Math.floor(songProgress / 60);
  var progressSeconds = Math.floor(songProgress % 60);
  var timeMinutes = Math.floor(player.duration / 60);
  var timeSeconds = Math.floor(player.duration % 60);
  if (progressSeconds < 10) {
    progressSeconds = "0" + progressSeconds;
  }
  if (timeSeconds < 10) {
    timeSeconds = "0" + timeSeconds;
  }
  songTimeIndicator.innerHTML =
    progressMinutes +
    ":" +
    progressSeconds +
    " / " +
    timeMinutes +
    ":" +
    timeSeconds;

  document.getElementById("progressSlider").value = songProgress;
}

function updateSongData(songname, artistname, songpicture, lyricurl) {
  document.title = "Playing - " + songname + " - " + artistname;

  document.getElementById("lyrics").innerHTML = "<a>" + lyricurl + "</a>";

  document.getElementById("songTitle").innerHTML = songname;
  document.getElementById("songArtist").innerHTML = artistname;
  document.getElementById("artistImage").src = songpicture;
}

function onPlayerNextTrack() {
  if (currentSongID < maxSongs) {
    playerEventOnPause();
    currentSongID++;
    fetchAsync(
      "/spotify/backend/API/V1/play/bPlayerPlaySongByID.php?id=" + currentSongID
    ).then(function (data) {
      updateSongData(
        data.songName,
        data.artistName,
        data.songImageUrl,
        data.lyricsURL
      );
      player.src = data.songURL;
      playerOnReload();
      if (autoPlay) {
        playerEventOnPlay();
      }
    });
    document.getElementById("buttonNext").style.visibility = "visible";
    document.getElementById("buttonLast").style.visibility = "visible";
  } else {
    document.getElementById("buttonNext").style.visibility = "hidden";
  }
}
function onPlayerLastTrack() {
  if (currentSongID > 0) {
    playerEventOnPause();
    currentSongID--;
    fetchAsync(
      "/spotify/backend/API/V1/play/bPlayerPlaySongByID.php?id=" + currentSongID
    ).then(function (data) {
      updateSongData(
        data.songName,
        data.artistName,
        data.songImageUrl,
        data.lyricsURL
      );
      player.src = data.songURL;
      playerOnReload();
      if (autoPlay) {
        playerEventOnPlay();
      }
    });
    document.getElementById("buttonNext").style.visibility = "visible";
    document.getElementById("buttonLast").style.visibility = "visible";
  } else {
    document.getElementById("buttonLast").style.visibility = "hidden";
  }
}

function onPlayerSelectTrack(trackID) {
  document.getElementById("buttonNext").style.visibility = "visible";
  document.getElementById("buttonLast").style.visibility = "visible";
  playerEventOnPause();
  currentSongID = trackID;
  fetchAsync(
    "/spotify/backend/API/V1/play/bPlayerPlaySongByID.php?id=" + currentSongID
  ).then(function (data) {
    updateSongData(
      data.songName,
      data.artistName,
      data.songImageUrl,
      data.lyricsURL
    );
    player.src = data.songURL;
    playerOnReload();
    if (autoPlay) {
      playerEventOnPlay();
    }
  });
}

//OnTrackEnded
player = document.getElementById("player");
player.onended = function () {
  if (looping) {
    playerOnReload();
    playerEventOnPlay();
  } else if (shuffle) {
    var randomSongID = getRandomInt(maxSongs + 1);
    while (randomSongID == currentSongID) {
      randomSongID = getRandomInt(maxSongs + 1);
      console.log("Random Song ID: " + randomSongID);
    }
    console.log(randomSongID);
    onPlayerSelectTrack(randomSongID);
  } else if (autoPlay) {
    onPlayerNextTrack();
  } else {
    playerEventOnPause();
  }
};

/*PLAYER END*/

async function fetchAsync(url) {
  let response = await fetch(url);
  let data = await response.json();
  return data;
}

function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}
