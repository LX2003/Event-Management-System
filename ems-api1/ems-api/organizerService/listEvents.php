<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../db.php';

if (!isset($_GET['organizer_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing organizer_id"]);
    exit;
}

$type = $_GET['type'] ?? 'all';
$organizer_id = $_GET['organizer_id'];

$query = "SELECT * FROM events WHERE organizer_id = ?";
if ($type === 'upcoming') {
    $query .= " AND datetime > NOW()";
} elseif ($type === 'past') {
    $query .= " AND datetime <= NOW()";
}
$query .= " ORDER BY datetime DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$organizer_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events);
?>
