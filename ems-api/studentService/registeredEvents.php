<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../db.php';

if (!isset($_GET['student_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing student_id"]);
    exit;
}

$studentId = $_GET['student_id'];

$stmt = $pdo->prepare("
    SELECT e.*, o.organization AS organizer_name
    FROM events e
    INNER JOIN registrations r ON e.event_id = r.event_id
    INNER JOIN organizers o ON e.organizer_id = o.organizer_id
    WHERE r.student_id = ?
      AND e.datetime >= NOW()
    ORDER BY e.datetime ASC
");
$stmt->execute([$studentId]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
