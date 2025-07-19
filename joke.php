<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "jokedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE joke (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100),
    type VARCHAR(50),
    religiousCount INT
)";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
	$category = $_POST["category"];
	$religiousCount = $_POST["count"];
    $sql = "INSERT INTO joke VALUES ('$id', '$category', '$religiousCount')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Joke saved successfully"]);
    } else {
        echo json_encode(["error" => "Error saving joke"]);
    }
}
$conn->close();
?>