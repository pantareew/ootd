<?php
include "./db_connection.php";
header('Content-Type: application/json');
$input = json_decode(file_get_contents("php://input"), true);
$response = array('success' => false, 'message' => '');
$method = $_SERVER['REQUEST_METHOD'];

//table name
$table = "fav";
$outfit = "outfits";

$sql = '';
switch ($method) {
    case 'GET':
        $username = mysqli_real_escape_string($conn, $_GET['username']);
        $sql = "SELECT `outfits`.* FROM `$table` INNER JOIN `$outfit` ON `$table`.`outfit_id` = `outfits`.`id` WHERE `$table`.`favBy` = '$username'";
        break;
    case 'POST':
        $username = mysqli_real_escape_string($conn, $input['username']);
        $id = mysqli_real_escape_string($conn, $input['id']);
        $sql = "INSERT INTO `$table` (`favBy`, `outfit_id`) VALUES ('$username', '$id')";
        break;
    case 'DELETE':
        $username = mysqli_real_escape_string($conn, $_GET['username']);
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "DELETE FROM `$table` WHERE `favBy` = '$username' AND `outfit_id` = '$id'";
        break;
}

$result = mysqli_query($conn, $sql);
if ($result) {
    $response['success'] = true;
    if ($method == 'GET') {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $response['data'] = $data;
    } elseif ($method == 'POST') {
        $response['message'] = "Outfit added to fav";
    } elseif ($method == 'DELETE') {
        $response['message'] = "Outfit removed from fav";
    }
}

echo json_encode($response);

mysqli_close($conn);
