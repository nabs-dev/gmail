<?php
include("db.php");

function getUserName($id) {
    global $conn;
    $q = $conn->query("SELECT name FROM users WHERE id=$id");
    if ($q->num_rows > 0) {
        return $q->fetch_assoc()['name'];
    }
    return "Unknown";
}
?>
