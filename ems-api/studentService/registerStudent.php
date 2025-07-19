<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
require_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name, $data->email, $data->password, $data->student_number, $data->course)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$hash = password_hash($data->password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();

    // Insert into users
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$data->name, $data->email, $hash]);
    $user_id = $pdo->lastInsertId();

    // Insert into students
    $stmt = $pdo->prepare("INSERT INTO students (user_id, student_number, course) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $data->student_number, $data->course]);

    $pdo->commit();
    echo json_encode(["message" => "Student registered"]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(["error" => "Email already used"]);
}
?>
