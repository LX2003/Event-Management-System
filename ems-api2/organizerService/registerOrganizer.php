<?php
require_once __DIR__ . '/../db.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");


$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name, $data->email, $data->password, $data->organization, $data->phone)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$hash = password_hash($data->password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$data->name, $data->email, $hash]);
    $user_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO organizers (user_id, organization, phone) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $data->organization, $data->phone]);

    $pdo->commit();
    echo json_encode(["message" => "Organizer registered"]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(["error" => "Email already used"]);
}
?>
