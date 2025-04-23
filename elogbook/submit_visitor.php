<?php
// submit_visitor.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $agency = $_POST['agency'];
    $position = $_POST['position'];
    $purpose = $_POST['purpose'];

    // Optional: Save signature or photo in future

    $stmt = $conn->prepare("INSERT INTO visitors (fullName, agency, position, purpose, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $fullName, $agency, $position, $purpose);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to insert."]);
    }
    $stmt->close();
    $conn->close();
}
?>
