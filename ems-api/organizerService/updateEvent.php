<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->event_id, $data->title, $data->description, $data->datetime, $data->capacity, $data->location)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE events 
    SET title = ?, description = ?, datetime = ?, capacity = ?, location = ?
    WHERE event_id = ?
");
$stmt->execute([
    $data->title,
    $data->description,
    $data->datetime,
    $data->capacity,
    $data->location,
    $data->event_id
]);

echo json_encode(["message" => "Event updated successfully"]);
?>
