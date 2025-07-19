<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");

require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$required = ['organizer_id', 'title', 'description', 'datetime', 'location', 'capacity'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing field: $field"]);
        exit;
    }
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO events (organizer_id, title, description, datetime, location, capacity)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $data['organizer_id'],
        $data['title'],
        $data['description'],
        $data['datetime'],
        $data['location'],
        $data['capacity']
    ]);

    echo json_encode(["success" => true, "event_id" => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error", "details" => $e->getMessage()]);
}
?>
