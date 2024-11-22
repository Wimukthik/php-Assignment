<?php
header("Content-Type: application/json");
require_once 'Api.php';

$api = new Api();

// Determine the request method
$method = $_SERVER['REQUEST_METHOD'];
$url = explode('/', $_SERVER['REQUEST_URI']);
$index_no = isset($url[3]) ? intval($url[3]) : null;

switch ($method) {
    case 'GET':
        if ($index_no) {
            $response = $api->getStudent($index_no);
        } else {
            $response = $api->getStudents();
        }
        echo json_encode($response);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($api->createStudent($data)) {
            echo json_encode(["message" => "Student created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create student."]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($api->updateStudent($index_no, $data)) {
            echo json_encode(["message" => "Student updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update student."]);
        }
        break;

    case 'DELETE':
        if ($api->deleteStudent($index_no)) {
            echo json_encode(["message" => "Student deleted successfully."]);
        } else {
            echo json_encode(["message" => "Failed to delete student."]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request method."]);
        break;
}
