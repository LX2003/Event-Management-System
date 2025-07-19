<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->student_id, $data->event_id, $data->rating)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$comment = isset($data->comment) ? $data->comment : null;

$stmt = $pdo->prepare("SELECT * FROM feedback WHERE student_id = ? AND event_id = ?");
$stmt->execute([$data->student_id, $data->event_id]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["message" => "Feedback already submitted"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO feedback (student_id, event_id, rating, comment) VALUES (?, ?, ?, ?)");
$stmt->execute([$data->student_id, $data->event_id, $data->rating, $comment]);

echo json_encode(["message" => "Feedback submitted"]);
?>
