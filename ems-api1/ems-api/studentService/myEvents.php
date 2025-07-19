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

$stmt = $pdo->prepare("
    SELECT e.*
    FROM events e
    WHERE e.datetime > NOW()
      AND e.event_id NOT IN (
          SELECT event_id FROM registrations WHERE student_id = ?
      )
    ORDER BY e.datetime ASC
");
$stmt->execute([$_GET['student_id']]);

echo json_encode($stmt->fetchAll());
?>