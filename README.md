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

