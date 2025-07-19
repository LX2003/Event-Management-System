<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../db.php';

if (!isset($_GET['student_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing student_id"]);
    exit;
}

$student_id = intval($_GET['student_id']);

$sql = "
    SELECT e.*
    FROM events e
    WHERE e.event_id NOT IN (
        SELECT event_id FROM registrations WHERE student_id = ?
    )
    AND e.datetime >= NOW()
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$student_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events);
