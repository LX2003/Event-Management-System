<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_GET['event_id'])) {
    http_response_code(400);
    echo "Missing event_id";
    exit;
}

$event_id = $_GET['event_id'];

$stmt = $pdo->prepare("SELECT u.name, u.email, s.student_number, s.course FROM registrations r JOIN students s ON r.student_id = s.student_id JOIN users u ON s.user_id = u.user_id WHERE r.event_id = ?");
$stmt->execute([$event_id]);
$participants = $stmt->fetchAll();

if (empty($participants)) {
    echo "No participants found.";
    exit;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Participants");
$sheet->setCellValue('A1', 'Name');
$sheet->setCellValue('B1', 'Email');
$sheet->setCellValue('C1', 'Student Number');
$sheet->setCellValue('D1', 'Course');

$row = 2;
foreach ($participants as $p) {
    $sheet->setCellValue("A$row", $p['name']);
    $sheet->setCellValue("B$row", $p['email']);
    $sheet->setCellValue("C$row", $p['student_number']);
    $sheet->setCellValue("D$row", $p['course']);
    $row++;
}

$filename = "participants_event_$event_id.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
