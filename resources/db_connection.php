<?php

//load db url
$cleardb_url = getenv("JAWSDB_URL");

if (!$cleardb_url) {
    die("Error: No database URL found.");
}

// Parse the JawsDB URL
$cleardb_config = parse_url($cleardb_url);

//get database credentials
$servername = $cleardb_config["host"];
$username = $cleardb_config["user"];
$password = $cleardb_config["pass"];
$database = substr($cleardb_config["path"], 1);

//create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
