<?php
include "./db_connection.php";
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');
$method = $_SERVER['REQUEST_METHOD'];

//check db connection
if (!$conn) {
    $response['message'] = 'DB connection failed';
    echo json_encode($response);
    exit();
}

//table name
$table = "outfits";

$sql = '';
switch ($method) {
    case 'GET':
        $username = isset($_GET['username']) ? mysqli_real_escape_string($conn, $_GET['username']) : '';
        if ($username) {
            $sql = "SELECT * FROM `$table` WHERE `styler` != '$username'";
        } else {
            $sql = "SELECT * FROM `$table`";
        }
        break;
}

$result = mysqli_query($conn, $sql);
if ($result) {
    if ($method == 'GET') {
        $response['success'] = true;
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $response['data'] = $data;
    }
}
echo json_encode($response);
mysqli_close($conn);
