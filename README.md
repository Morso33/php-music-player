# PHP Music Player

## A simple music player written in PHP that supports playback of MP3 songs.

Uses MySql for database management.

Has a simple Login + Register system inbuilt (bcrypt encryption on sensitive user data). 

Supports the user uploading their own songs (root/upload.php)

Built-in rudimentary session system (user sessions).

Some images, API documentation etc: https://docs.google.com/document/d/1tBFMMRYDAC6Ro8HnsnVE0W71duABRAdJDFcnEnJputo/edit?usp=sharing


# Setup
### 1. Setup a MySql database on port 3006.
### 2. Create a database called "Spotify".
### 3. Execute spotify.sql (root/sql/spotify.sql) inside the database).
### 4. Setup Apache.
### 5. Setup PHP (https://www.php.net/manual/en/install.php).
### 6. Create a folder called Spotify inside Apaches root directory (var/www/html).
### 7. Clone this repository inside the Spotify folder.
#### Everything should be correctly configured. Default MySql credentials are username: root | password root .

#Images
![image](https://user-images.githubusercontent.com/69962221/193657157-e650f846-7a9b-474a-963d-c876c243f203.png)
![image](https://user-images.githubusercontent.com/69962221/193657189-c72f7b54-496d-40c3-8427-7149b998bbb0.png)
![image](https://user-images.githubusercontent.com/69962221/193657220-8630ca6b-1233-4fb4-b625-c8fe5c6d3541.png)
![image](https://user-images.githubusercontent.com/69962221/193657246-53a38d4b-2226-447c-a3bf-0582e5f07f9c.png)
![image](https://user-images.githubusercontent.com/69962221/193657290-4e02623c-b760-496c-8042-934cd8b3fc77.png)
![image](https://user-images.githubusercontent.com/69962221/193657321-2adb802f-df85-488d-9451-cfd1ae7464ec.png)
API Documentation

HTTP GET /API/V1/bLogin.php
Arguments:
GET username
GET password
Response (JSON):
status: Returns success on successful login, else: error.
error: Returns an error, if present.
websession: Returns a 16 character randomly generated string, if successful login.

HTTP POST /API/V1/bRegister.php
Arguments:
POST username
POST password
POST firstName
POST lastName
POST email
Response (JSON):
status: Returns success on successful login, else: error.
error: Returns an error, if present.

HTTP POST /API/V1/bUpload.php
Arguments:
POST songName
POST artistName
POST imageURL
POST fileToUpload
POST lyricsURL
Response (text):
New record created successfully / Error: $error




HTTP GET /API/V1/play/bPlayerPlaySongByID.php
Arguments:
GET id
Response (JSON):
status: Returns success on successful query, else: error.
error: Returns an error, if present.
id: The song’s id.
songName: The song's name as a string.
artistName: The artist's name as a string.
songURL: The songs mp3 file URL, from the root directory.
lyricsURL: The lyrics of the song, as a string.

HTTP GET /API/V1/play/bPlayerSearchSong.php
Arguments:
GET songname
Response (JSON):
status: Returns success on successful query, else: error.
error: Returns an error, if present.
id: The id of the returned song, if present.





HTTP GET /API/V1/play/bPlayerSongsInfo.php
Arguments:

Response (JSON):
status: Returns success on successful query, else: error.
error: Returns an error, if present.
amount: the amount of songs in the database.


