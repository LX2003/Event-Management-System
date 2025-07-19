<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");

require_once __DIR__ . '/../db.php';

if (!isset($_GET['student_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing student_id"]);
    exit;
}

$student_id = intval($_GET['student_id']);

$sql = "
    SELECT e.*, o.organization AS organizer_name, r.status
    FROM registrations r
    JOIN events e ON r.event_id = e.event_id
    JOIN organizers o ON e.organizer_id = o.organizer_id
    WHERE r.student_id = ?
      AND r.status = 'registered'
      AND e.datetime < NOW()
    ORDER BY e.datetime DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$student_id]);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
