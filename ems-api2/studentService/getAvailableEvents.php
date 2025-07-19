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
    SELECT 
        e.*, 
        o.organization AS organizer_name,
        (
            SELECT COUNT(*) 
            FROM registrations r 
            WHERE r.event_id = e.event_id AND r.status = 'registered'
        ) AS registered_count
    FROM events e
    JOIN organizers o ON e.organizer_id = o.organizer_id
    WHERE e.event_id NOT IN (
        SELECT event_id FROM registrations WHERE student_id = ?
    )
    AND e.datetime >= NOW()
    AND e.allow_registration = 1
    AND (
        SELECT COUNT(*) FROM registrations r 
        WHERE r.event_id = e.event_id AND r.status = 'registered'
    ) < e.capacity
";


$stmt = $pdo->prepare($sql);
$stmt->execute([$student_id]);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
