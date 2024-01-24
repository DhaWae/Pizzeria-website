<?php
// might need to change the port depending on where you are using mysql
// sometimes it works without specifying port, if it doesnt work try adding :port to localhost
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "ginos";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}