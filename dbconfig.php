<?php
//DB details
$dbHost = 'localhost:3370';
$dbUsername = 'root';
$dbPassword = 'Filipenses413@';
$dbName = 'tiendasrey';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}

?>