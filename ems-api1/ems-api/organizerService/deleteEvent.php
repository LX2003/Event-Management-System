<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->event_id)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing event_id"]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
$stmt->execute([$data->event_id]);

echo json_encode(["message" => "Event deleted successfully"]);
?>
