<?php

//load .env file
$env = parse_ini_file(__DIR__ . "/.env");

//check for .env 
if (!$env) {
    die("Failed to load .env file.");
}

//get data from .env file
$servername = $env['DB_SERVER'];
$username = $env['DB_USERNAME'];
$password = $env['DB_PASSWORD'];
$database = $env['DB_DATABASE'];

//create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
