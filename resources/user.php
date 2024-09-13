<?php
include "./db_connection.php";
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);  // json string to associative array(true)


mysqli_set_charset($conn, 'utf8');

$table = "users";

// retrieve the search key field name and value from the path
$fld = preg_replace('/[^a-z0-9_]+/i', '', array_shift($request));
$key = array_shift($request);
// retrieve the data to prepare set values
if (isset($input)) {
    $columns = preg_replace('/[^a-z0-9_]+/i', '', array_keys($input));
    $values = array_map(function ($value) use ($conn) {
        if ($value === null) return null;
        return mysqli_real_escape_string($conn, (string)$value);
    }, array_values($input));
}

// create SQL
switch ($method) {
    case 'POST':
        $sql = "select * from `$table` WHERE username='" . $input['username'] . "' and password ='" . $input['password'] . "'";
        break;
}

// execute SQL statement
$result = mysqli_query($conn, $sql);
if ($result) {
    if ($method == 'POST') {
        echo json_encode(mysqli_fetch_object($result));
    } else {
        echo mysqli_affected_rows($conn);
    }
}

// close mysql connection
mysqli_close($conn);
