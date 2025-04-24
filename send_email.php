<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>location.href='login.php';</script>";
    exit;
}

// Collect data from form
$sender_id = $_SESSION['user']['id'];
$receiver_email = isset($_POST['receiver_email']) ? trim($_POST['receiver_email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$body = isset($_POST['body']) ? trim($_POST['body']) : '';
$starred = isset($_POST['starred']) ? 1 : 0;

// Validate all fields
if (empty($receiver_email) || empty($subject) || empty($body)) {
    echo "<script>alert('All fields are required.'); window.history.back();</script>";
    exit;
}

// Connect to database
$conn = new mysqli("localhost", "u8gr0sjr9p4p4", "9yxuqyo3mt85", "dbz8tsb1fdymho");

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Find receiver's ID by email
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $receiver_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Recipient not found!'); window.history.back();</script>";
    exit;
}

$receiver = $result->fetch_assoc();
$receiver_id = $receiver['id'];

// Insert email (without timestamp)
$stmt = $conn->prepare("INSERT INTO emails (sender_id, receiver_id, subject, body, starred) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("iissi", $sender_id, $receiver_id, $subject, $body, $starred);

// Send the email
if ($stmt->execute()) {
    echo "<script>alert('Email sent successfully!'); location.href='inbox.php';</script>";
} else {
    echo "<script>alert('Failed to send email.'); window.history.back();</script>";
}

$conn->close();
?>
