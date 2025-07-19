<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->student_id, $data->event_id)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing data"]);
    exit;
}

$student_id = intval($data->student_id);
$event_id = intval($data->event_id);

// Check if event is full
$checkStmt = $pdo->prepare("
    SELECT 
        (SELECT COUNT(*) FROM registrations WHERE event_id = ? AND status = 'registered') AS current_count,
        capacity,
        allow_registration
    FROM events
    WHERE event_id = ?
");
$checkStmt->execute([$event_id, $event_id]);
$event = $checkStmt->fetch(PDO::FETCH_ASSOC);

if (!$event || !$event['allow_registration']) {
    echo json_encode(["error" => "Registration is closed for this event."]);
    exit;
}

if ($event['current_count'] >= $event['capacity']) {
    echo json_encode(["error" => "Event is full."]);
    exit;
}

// Proceed with registration
$insertStmt = $pdo->prepare("INSERT INTO registrations (student_id, event_id, status) VALUES (?, ?, 'registered')");
$success = $insertStmt->execute([$student_id, $event_id]);

if ($success) {
    echo json_encode(["message" => "Registration successful"]);
} else {
    echo json_encode(["error" => "Registration failed"]);
}
