<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

if (!isset($_GET['event_id'])) {
    http_response_code(400);
    echo "Missing event_id";
    exit;
}

$event_id = $_GET['event_id'];

// Fetch participants
$stmt = $pdo->prepare("SELECT u.name, u.email, s.student_number, s.course FROM registrations r JOIN students s ON r.student_id = s.student_id JOIN users u ON s.user_id = u.user_id WHERE r.event_id = ?");
$stmt->execute([$event_id]);
$participants = $stmt->fetchAll();

// Fetch event title
$stmt_event = $pdo->prepare("SELECT title FROM events WHERE event_id = ?");
$stmt_event->execute([$event_id]);
$event_data = $stmt_event->fetch();
$event_title = $event_data ? $event_data['title'] : "Unknown Event";

if (empty($participants)) {
    echo "No participants found.";
    exit;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Participants");

// --- Event Title Styling ---
$sheet->setCellValue('A1', 'Event Participants List');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

$sheet->setCellValue('A2', 'Event Name:');
$sheet->setCellValue('B2', $event_title);
$sheet->mergeCells('B2:D2');
$sheet->getStyle('A2:D2')->getFont()->setBold(true);
$sheet->getStyle('A2:D2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2F2F2'); // Light gray background

// Add a blank row for separation
$sheet->insertNewRowBefore(3, 1); // Insert blank row at row 3

// --- Header Styling ---
$headerRow = 4;
$sheet->setCellValue('A'.$headerRow, 'Name');
$sheet->setCellValue('B'.$headerRow, 'Email');
$sheet->setCellValue('C'.$headerRow, 'Student Number');
$sheet->setCellValue('D'.$headerRow, 'Course');

$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'], // White font
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF4F81BD'], // Dark blue background
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
];
$sheet->getStyle('A'.$headerRow.':D'.$headerRow)->applyFromArray($headerStyle);

// --- Populate data and apply row styling ---
$row = $headerRow + 1;
foreach ($participants as $index => $p) {
    $sheet->setCellValue("A$row", $p['name']);
    $sheet->setCellValue("B$row", $p['email']);
    $sheet->setCellValue("C$row", $p['student_number']);
    $sheet->setCellValue("D$row", $p['course']);

    // Alternating row colors
    if ($index % 2 == 0) {
        $sheet->getStyle('A'.$row.':D'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE0FFFF'); // Light blue for even rows
    } else {
        $sheet->getStyle('A'.$row.':D'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); // White for odd rows
    }

    // Add borders to data cells
    $sheet->getStyle('A'.$row.':D'.$row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $row++;
}

// --- Auto-size columns ---
foreach (range('A', 'D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Clean up event title for filename
$sanitized_event_title = preg_replace('/[^a-zA-Z0-9-]/', '_', $event_title);
$filename = "participants_{$sanitized_event_title}_event_$event_id.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;