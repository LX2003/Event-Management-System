<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
require_once __DIR__ . '/../db.php';

if (!isset($_GET['event_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing event_id"]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT u.name AS student_name, f.rating, f.comment
    FROM feedback f
    JOIN students s ON f.student_id = s.student_id
    JOIN users u ON s.user_id = u.user_id
    WHERE f.event_id = ?
");
$stmt->execute([$_GET['event_id']]);

echo json_encode($stmt->fetchAll());
?>
