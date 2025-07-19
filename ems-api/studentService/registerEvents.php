<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");

require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->student_id, $data->event_id)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing student_id or event_id"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM registrations WHERE student_id = ? AND event_id = ?");
$stmt->execute([$data->student_id, $data->event_id]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["message" => "Already registered"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO registrations (student_id, event_id, status) VALUES (?, ?, 'registered')");
$stmt->execute([$data->student_id, $data->event_id]);

echo json_encode(["message" => "Registration successful"]);
?>
