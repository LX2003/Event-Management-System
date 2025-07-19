<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->event_id) || !isset($data->allow_registration)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing data"]);
    exit;
}

$event_id = intval($data->event_id);
$allowed = $data->allow_registration ? 1 : 0;

$stmt = $pdo->prepare("UPDATE events SET allow_registration = ? WHERE event_id = ?");
if ($stmt->execute([$allowed, $event_id])) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update"]);
}
