<<<<<<< HEAD
<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing email or password"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data->email]);
$user = $stmt->fetch();

if ($user && password_verify($data->password, $user['password_hash'])) {
    $user_id = $user["user_id"];

    // Check if organizer
    $stmt = $pdo->prepare("SELECT * FROM organizers WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $org = $stmt->fetch();

    if ($org) {
        echo json_encode([
            "role" => "organizer",
            "user_id" => $user_id,
            "organizer_id" => $org['organizer_id'],
            "name" => $user['name'],
            "email" => $user['email']
        ]);
        exit;
    }

    // Else, check if student
    $stmt = $pdo->prepare("SELECT * FROM students WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $stu = $stmt->fetch();

    if ($stu) {
        echo json_encode([
            "role" => "student",
            "user_id" => $user_id,
            "student_id" => $stu['student_id'],
            "name" => $user['name'],
            "email" => $user['email']
        ]);
        exit;
    }

    // If user exists but has no role
    echo json_encode(["error" => "Role not assigned"]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials"]);
}
?>
=======
<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(["error" => "Missing email or password"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data->email]);
$user = $stmt->fetch();

if ($user && password_verify($data->password, $user['password_hash'])) {
    $user_id = $user["user_id"];

    // Check if organizer
    $stmt = $pdo->prepare("SELECT * FROM organizers WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $org = $stmt->fetch();

    if ($org) {
        echo json_encode([
            "role" => "organizer",
            "user_id" => $user_id,
            "organizer_id" => $org['organizer_id'],
            "name" => $user['name'],
            "email" => $user['email']
        ]);
        exit;
    }

    // Else, check if student
    $stmt = $pdo->prepare("SELECT * FROM students WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $stu = $stmt->fetch();

    if ($stu) {
        echo json_encode([
            "role" => "student",
            "user_id" => $user_id,
            "student_id" => $stu['student_id'],
            "name" => $user['name'],
            "email" => $user['email']
        ]);
        exit;
    }

    // If user exists but has no role
    echo json_encode(["error" => "Role not assigned"]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials"]);
}
?>
>>>>>>> 52b08eb65272a53c2b5fdb97768a0a8184349f61
