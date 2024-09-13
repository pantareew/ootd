<?php
include "./db_connection.php";
// get the HTTP method and body
$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);

mysqli_set_charset($conn, 'utf8');

// initialise the table name accordingly
$table = "users";


switch ($method) {
    case 'GET':
        if (isset($_GET['username'])) {
            $username = mysqli_real_escape_string($conn, $_GET['username']);
            $sql = "SELECT * FROM `$table` WHERE username='$username'";
        }
        break;
    case 'POST':
        if ($input) {
            $columns = preg_replace('/[^a-z0-9_]+/i', '', array_keys($input));
            $values = array_map(function ($value) use ($conn) {
                return mysqli_real_escape_string($conn, (string)$value);
            }, array_values($input));

            $set = '';
            for ($i = 0; $i < count($columns); $i++) {
                $set .= ($i > 0 ? ',' : '') . '`' . $columns[$i] . '`=';
                $set .= '"' . $values[$i] . '"';
            }

            $sql = "INSERT INTO `$table` SET $set";
        }
        break;
}

$result = mysqli_query($conn, $sql);

if ($result) {
    if ($method == 'GET') {
        header('Content-Type: application/json');
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } elseif ($method == 'POST') {
        echo json_encode(['success' => true, 'username' => $input['username']]);
    }
}

// close mysql connection
mysqli_close($conn);
